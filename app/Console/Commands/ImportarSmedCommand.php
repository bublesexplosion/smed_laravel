<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class ImportarSmedCommand extends Command
{
    protected $signature = 'smed:import
        {arquivo? : Caminho do dump SQL do SMED}
        {--dry-run : Apenas contar os registros, sem gravar}
        {--publicadas : Importar somente posts/pages publicados}';

    protected $description = 'Importa noticias e midias do dump legado SMED/WordPress';

    private const NOTICIA_COLUMNS = [
        'id', 'origem_id', 'autor_id', 'noticia_pai_id', 'tipo', 'status',
        'titulo', 'slug', 'resumo', 'conteudo', 'data_criacao', 'data_publicacao',
        'data_modificacao', 'comentario_status', 'ping_status', 'ordem', 'mime_type',
        'url_origem',
    ];

    private const MIDIA_COLUMNS = [
        'id', 'origem_id', 'noticia_pai_id', 'titulo', 'slug', 'descricao', 'legenda',
        'url', 'caminho_relativo', 'mime_type', 'data_criacao',
    ];

    public function handle(): int
    {
        $arquivo = $this->argument('arquivo') ?: database_path('smed_novo.sql');

        if (! is_file($arquivo)) {
            $this->error("Dump não encontrado: {$arquivo}");
            return self::FAILURE;
        }

        $sql = file_get_contents($arquivo);
        if ($sql === false) {
            throw new RuntimeException("Não foi possível ler {$arquivo}");
        }

        $noticias = array_values(array_filter(
            $this->readTable($sql, 'noticias', self::NOTICIA_COLUMNS),
            static fn (array $row): bool => in_array($row['tipo'], ['page', 'post'], true)
        ));
        $midias = $this->readTable($sql, 'midias', self::MIDIA_COLUMNS);
        $publicadas = (bool) $this->option('publicadas');

        if ($publicadas) {
            $noticias = array_values(array_filter($noticias, fn (array $row) =>
                $row['status'] === 'publish' && ! in_array($row['tipo'], ['revision', 'attachment'], true)
            ));
        }

        $this->info(sprintf('Encontradas %d notícias e %d mídias no dump.', count($noticias), count($midias)));

        if ($this->option('dry-run')) {
            return self::SUCCESS;
        }

        DB::transaction(function () use ($noticias, $midias): void {
            $noticiaIds = $this->importNoticias($noticias);
            $this->importMidias($midias, $noticiaIds);
        });

        $this->info('Importação concluída sem apagar tabelas existentes.');
        return self::SUCCESS;
    }

    /** @return array<int, array<string, mixed>> */
    private function readTable(string $sql, string $table, array $expectedColumns): array
    {
        $statements = $this->extractInserts($sql, $table);
        if ($statements === []) {
            return [];
        }

        $rows = [];
        foreach ($statements as $statement) {
            preg_match('/INSERT INTO `[^`]+`\s*\((.*?)\)\s*VALUES\s*(.*);\s*$/s', $statement, $matches);
            if (! isset($matches[1], $matches[2])) {
                throw new RuntimeException("Formato de INSERT inesperado para {$table}");
            }

            $columns = array_map(static fn (string $column) => trim($column, " `\t\r\n"), explode(',', $matches[1]));
            foreach ($this->parseTuples($matches[2]) as $tuple) {
                $values = $this->parseFields($tuple);
                if (count($values) !== count($columns)) {
                    throw new RuntimeException("Quantidade de campos inválida em {$table}");
                }
                $row = array_combine($columns, $values);
                $rows[] = array_replace(array_fill_keys($expectedColumns, null), $row);
            }
        }

        return $rows;
    }

    /** @return array<int, string> */
    private function extractInserts(string $sql, string $table): array
    {
        $marker = 'INSERT INTO `' . $table . '`';
        $statements = [];
        $offset = 0;
        $length = strlen($sql);

        while (($start = strpos($sql, $marker, $offset)) !== false) {
            $quote = false;
            $escaped = false;
            for ($i = $start; $i < $length; $i++) {
                $char = $sql[$i];
                if ($quote && $char === '\\' && ! $escaped) {
                    $escaped = true;
                    continue;
                }
                if ($char === "'" && ! $escaped) {
                    $quote = ! $quote;
                }
                if ($char === ';' && ! $quote) {
                    $statements[] = substr($sql, $start, $i - $start + 1);
                    $offset = $i + 1;
                    continue 2;
                }
                $escaped = false;
            }

            throw new RuntimeException("INSERT incompleto para {$table}");
        }

        return $statements;
    }

    /** @return array<int, string> */
    private function parseTuples(string $values): array
    {
        $tuples = [];
        $depth = 0;
        $quote = false;
        $escaped = false;
        $start = null;
        for ($i = 0, $length = strlen($values); $i < $length; $i++) {
            $char = $values[$i];
            if ($quote && $char === '\\' && ! $escaped) {
                $escaped = true;
                continue;
            }
            if ($char === "'" && ! $escaped) {
                $quote = ! $quote;
            } elseif (! $quote && $char === '(') {
                if ($depth === 0) {
                    $start = $i + 1;
                }
                $depth++;
            } elseif (! $quote && $char === ')') {
                $depth--;
                if ($depth === 0 && $start !== null) {
                    $tuples[] = substr($values, $start, $i - $start);
                    $start = null;
                }
            }
            $escaped = false;
        }
        return $tuples;
    }

    /** @return array<int, string|null> */
    private function parseFields(string $tuple): array
    {
        $fields = [];
        $field = '';
        $quote = false;
        $escaped = false;
        for ($i = 0, $length = strlen($tuple); $i < $length; $i++) {
            $char = $tuple[$i];
            if ($quote && $char === '\\' && ! $escaped) {
                $escaped = true;
                $field .= $char;
                continue;
            }
            if ($char === "'") {
                if ($quote && $escaped) {
                    $field .= $char;
                } else {
                    $quote = ! $quote;
                }
            } elseif ($char === ',' && ! $quote) {
                $fields[] = $this->decodeValue(trim($field));
                $field = '';
            } else {
                $field .= $char;
            }
            $escaped = false;
        }
        $fields[] = $this->decodeValue(trim($field));
        return $fields;
    }

    private function decodeValue(string $value): ?string
    {
        if (strcasecmp($value, 'NULL') === 0) {
            return null;
        }
        return strtr($value, [
            '\\\\' => '\\', '\\0' => "\0", '\\n' => "\n", '\\r' => "\r",
            '\\t' => "\t", '\\Z' => "\x1a", "\\'" => "'", '\\"' => '"',
        ]);
    }

    /** @return array<int, int> mapa id legado => id atual */
    private function importNoticias(array $noticias): array
    {
        $ids = [];
        foreach ($noticias as $row) {
            $origemId = (int) $row['origem_id'];
            $existing = DB::table('noticias')->where('origem_id', $origemId)->first();
            $slug = $this->uniqueSlug((string) $row['slug'], $origemId, $existing ? $existing->id : null);
            $data = [
                'autor_id' => $this->existingUserId($row['autor_id']),
                'tipo' => $row['tipo'] ?: 'post', 'status' => $row['status'] ?: 'draft',
                'titulo' => $row['titulo'] ?: '(sem título)', 'slug' => $slug,
                'resumo' => $row['resumo'], 'conteudo' => $row['conteudo'] ?: '',
                'data_criacao' => $row['data_criacao'], 'data_publicacao' => $row['data_publicacao'],
                'data_modificacao' => $row['data_modificacao'], 'comentario_status' => $row['comentario_status'],
                'ping_status' => $row['ping_status'], 'ordem' => (int) ($row['ordem'] ?? 0),
                'mime_type' => $row['mime_type'], 'url_origem' => $row['url_origem'],
                'updated_at' => now(),
            ];
            if ($existing) {
                DB::table('noticias')->where('id', $existing->id)->update($data);
                $ids[(int) $row['id']] = (int) $existing->id;
            } else {
                $data['origem_id'] = $origemId;
                $data['created_at'] = now();
                $ids[(int) $row['id']] = (int) DB::table('noticias')->insertGetId($data);
            }
        }

        foreach ($noticias as $row) {
            if ($row['noticia_pai_id'] !== null && isset($ids[(int) $row['noticia_pai_id']], $ids[(int) $row['id']])) {
                DB::table('noticias')->where('id', $ids[(int) $row['id']])->update([
                    'noticia_pai_id' => $ids[(int) $row['noticia_pai_id']], 'updated_at' => now(),
                ]);
            }
        }
        return $ids;
    }

    private function importMidias(array $midias, array $noticiaIds): void
    {
        foreach ($midias as $row) {
            $existing = DB::table('midias')->where('origem_id', (int) $row['origem_id'])->first();
            $data = [
                'noticia_pai_id' => $noticiaIds[(int) $row['noticia_pai_id']] ?? null,
                'titulo' => $row['titulo'] ?: '(sem título)', 'slug' => $row['slug'] ?: null,
                'descricao' => $row['descricao'], 'legenda' => $row['legenda'], 'url' => $row['url'],
                'caminho_relativo' => $row['caminho_relativo'], 'mime_type' => $row['mime_type'],
                'data_criacao' => $row['data_criacao'], 'updated_at' => now(),
            ];
            if ($existing) {
                DB::table('midias')->where('id', $existing->id)->update($data);
            } else {
                $data['origem_id'] = (int) $row['origem_id'];
                $data['created_at'] = now();
                DB::table('midias')->insert($data);
            }
        }
    }

    private function existingUserId(mixed $id): ?int
    {
        return $id && DB::table('users')->where('id', (int) $id)->exists() ? (int) $id : null;
    }

    private function uniqueSlug(string $slug, int $origemId, mixed $currentId): string
    {
        $slug = Str::slug($slug) ?: 'noticia';
        $candidate = $slug;
        $suffix = 0;
        while (DB::table('noticias')->where('slug', $candidate)->when($currentId, fn ($q) => $q->where('id', '!=', $currentId))->exists()) {
            $suffix++;
            $candidate = $slug . '-smed-' . $origemId . ($suffix > 1 ? '-' . $suffix : '');
        }
        return $candidate;
    }
}
