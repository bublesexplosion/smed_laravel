<?php

namespace Database\Seeders;

use App\Models\Midia;
use App\Models\Noticia;
use Illuminate\Database\Seeder;

class NoticiaSeeder extends Seeder
{
    public function run(): void
    {
        $noticias = [
            [
                'origem_id' => 1001,
                'titulo' => 'Município amplia atendimento dos serviços públicos',
                'slug' => 'municipio-amplia-atendimento-dos-servicos-publicos',
                'resumo' => 'Novos horários e canais digitais facilitam o acesso da população aos serviços municipais.',
                'conteudo' => '<p>A Prefeitura ampliou os horários de atendimento e os canais digitais disponíveis à população.</p><p>Consulte os serviços e acompanhe as novidades pelo portal institucional.</p>',
                'data_publicacao' => '2026-09-15 10:00:00',
            ],
            [
                'origem_id' => 1002,
                'titulo' => 'Portal institucional recebe melhorias de acessibilidade',
                'slug' => 'portal-institucional-recebe-melhorias-de-acessibilidade',
                'resumo' => 'A nova interface segue o padrão Gov.br e oferece recursos para uma navegação mais inclusiva.',
                'conteudo' => '<p>O portal institucional recebeu melhorias de acessibilidade, contraste e organização das informações.</p><p>As mudanças seguem as boas práticas do Design System Gov.br.</p>',
                'data_publicacao' => '2026-09-10 14:30:00',
            ],
            [
                'origem_id' => 1003,
                'titulo' => 'Agenda municipal: confira os próximos eventos',
                'slug' => 'agenda-municipal-confira-os-proximos-eventos',
                'resumo' => 'Veja a programação de atividades abertas à comunidade nesta semana.',
                'conteudo' => '<p>A programação reúne atividades culturais, educativas e de atendimento à comunidade.</p>',
                'data_publicacao' => '2026-09-05 09:00:00',
            ],
        ];

        foreach ($noticias as $dados) {
            $noticia = Noticia::updateOrCreate(
                ['origem_id' => $dados['origem_id']],
                array_merge($dados, [
                    'tipo' => 'post',
                    'status' => 'publish',
                    'data_criacao' => $dados['data_publicacao'],
                    'data_modificacao' => $dados['data_publicacao'],
                ])
            );

            Midia::updateOrCreate(
                ['origem_id' => $dados['origem_id'] + 10000],
                [
                    'noticia_pai_id' => $noticia->id,
                    'titulo' => 'Imagem ilustrativa: '.$noticia->titulo,
                    'slug' => $noticia->slug.'-imagem',
                    'url' => '/images/logo.png',
                    'mime_type' => 'image/png',
                    'data_criacao' => $noticia->data_publicacao,
                ]
            );
        }
    }
}
