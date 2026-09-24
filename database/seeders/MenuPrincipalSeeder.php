<?php

namespace Database\Seeders;

use App\Models\MenuPrincipal;
use Illuminate\Database\Seeder;

class MenuPrincipalSeeder extends Seeder
{
    /**
     * Estrutura real do menu de páginas do site
     * https://www.riogrande.rs.gov.br/smed/ (extraída do widget "twentytwelve-page-list-menu").
     */
    private function arvore(): array
    {
        $base = 'https://www.riogrande.rs.gov.br/smed/';

        return [
            ['label' => 'Início', 'href' => $base],
            ['label' => 'Recursos Educacionais', 'href' => $base . '?page_id=46276'],
            [
                'label' => 'Gestão Pedagógica', 'href' => $base . '?page_id=40',
                'children' => [
                    [
                        'label' => 'Atividades', 'href' => $base . '?page_id=44453',
                        'children' => [
                            ['label' => 'Notícias 2023/2024', 'href' => $base . '?page_id=44440'],
                            [
                                'label' => 'Atividades 2021', 'href' => $base . '?page_id=39852',
                                'children' => [
                                    ['label' => 'Dança Estudantes 2021', 'href' => $base . '?page_id=39917'],
                                    ['label' => 'CLEs', 'href' => $base . '?page_id=40720'],
                                    ['label' => 'Matrículas 2021/2022', 'href' => $base . '?page_id=41638'],
                                    ['label' => 'Julho da Mulher Negra', 'href' => $base . '?page_id=40784'],
                                ],
                            ],
                            [
                                'label' => 'Atividades 2020', 'href' => $base . '?page_id=38239',
                                'children' => [
                                    ['label' => 'Eleição de Diretores e Vice-diretores das Escolas da Rede Municipal', 'href' => $base . '?page_id=38241'],
                                    ['label' => 'Currículo da Língua Brasileira de Sinais – LIBRAS: Componente Curricular como primeira língua', 'href' => $base . '?page_id=38258'],
                                    ['label' => 'Workshop com a escritora Léia Cassol', 'href' => $base . '?page_id=38557'],
                                    ['label' => 'Documento Orientador Curricular do Território Rio-grandino', 'href' => $base . '?page_id=38648'],
                                    ['label' => '16ª OBMEP', 'href' => $base . '?page_id=38750'],
                                    ['label' => 'Dança Estudantes', 'href' => $base . '?page_id=39040'],
                                    ['label' => 'Planos de Contingência para a COVID-19', 'href' => $base . '?page_id=39408'],
                                    ['label' => 'Processo de Matrículas 2020/2021', 'href' => $base . '?page_id=39493'],
                                ],
                            ],
                            [
                                'label' => 'Atividades 2019', 'href' => $base . '?page_id=31208',
                                'children' => [
                                    ['label' => '3ª OMMERG', 'href' => $base . '?page_id=31210'],
                                    ['label' => 'Processo Formativo sobre "Produção de Material Didático"', 'href' => $base . '?page_id=31566'],
                                    ['label' => 'Escola Viva', 'href' => $base . '?page_id=31588'],
                                    ['label' => 'Curso de Práticas Corporais na Educação Infantil', 'href' => $base . '?page_id=31726'],
                                    ['label' => 'Processo Formativo Professores(as) Alfabetizadores(as)', 'href' => $base . '?page_id=31642'],
                                    ['label' => 'Olimpíada de Língua Portuguesa 2019', 'href' => $base . '?page_id=31797'],
                                    [
                                        'label' => 'Consulta Popular Rio-grandina', 'href' => $base . '?page_id=32045',
                                        'children' => [
                                            ['label' => 'Consulta Popular Rio-grandina Formulários', 'href' => $base . '?page_id=32087'],
                                        ],
                                    ],
                                    ['label' => 'Reflexões sobre a aprendizagem do Campo Conceitual Multiplicativo no Ciclo de Alfabetização', 'href' => $base . '?page_id=32105'],
                                    ['label' => 'Formação "Arte Educacional"', 'href' => $base . '?page_id=32124'],
                                    ['label' => 'Formação "Esporte Educacional"', 'href' => $base . '?page_id=32133'],
                                    ['label' => '6º Festival de Vídeo Estudantil do Rio Grande/RS', 'href' => $base . '?page_id=32223'],
                                    ['label' => '1ª Conferência Municipal Infantojuvenil de Educação Ambiental – Pertencer é preciso!', 'href' => $base . '?page_id=32308'],
                                    ['label' => 'Projeto Aluno Monitor 2019', 'href' => $base . '?page_id=32328'],
                                    ['label' => 'Oficinas de Musicalização', 'href' => $base . '?page_id=32576'],
                                    ['label' => '7º Seminário Municipal de Diversidade e Inclusão', 'href' => $base . '?page_id=33988'],
                                    [
                                        'label' => 'Projeto Político Pedagógico e Regimento Escolar das Escolas da Rede Municipal de Educação de Rio Grande', 'href' => $base . '?page_id=34162',
                                        'children' => [
                                            ['label' => 'PROJETO POLITICO PEDAGÓGICO – PPP', 'href' => $base . '?page_id=34166'],
                                        ],
                                    ],
                                    ['label' => 'Etapa Sul do 6º Campeonato Gaúcho de Punhobol Escolar', 'href' => $base . '?page_id=34248'],
                                    ['label' => 'Curso de Formação Continuada em Esporte Educacional', 'href' => $base . '?page_id=34798'],
                                    ['label' => '2ª edição do Festival Paralímpico', 'href' => $base . '?page_id=34838'],
                                    ['label' => '3ª Edição do Festival "Dança Estudantes"', 'href' => $base . '?page_id=34973'],
                                    ['label' => 'Escuta e Diálogo sobre a escola possível frente aos desafios do século XXI', 'href' => $base . '?page_id=35082'],
                                    ['label' => 'Atividade em homenagem ao Dia do Alfabetizador', 'href' => $base . '?page_id=35382'],
                                    ['label' => 'Referencial Curricular Rio-grandino', 'href' => $base . '?page_id=36038'],
                                    ['label' => 'IV Copa Cidade do Rio Grande de Punhobol Escolar', 'href' => $base . '?page_id=36231'],
                                    ['label' => 'Matrículas 2019/2020', 'href' => $base . '?page_id=36372'],
                                    ['label' => '3º Seminário de Partilha de Práticas Formativas', 'href' => $base . '?page_id=37477'],
                                    ['label' => '6º Festival de Esporte Educacional Especial', 'href' => $base . '?page_id=36766'],
                                ],
                            ],
                            [
                                'label' => 'Atividades 2018', 'href' => $base . '?page_id=25220',
                                'children' => [
                                    ['label' => '3ª CONAE/2018', 'href' => $base . '?page_id=25218'],
                                    ['label' => 'PNAIC 2018', 'href' => $base . '?page_id=25819'],
                                    ['label' => 'Projeto Aluno Monitor 2018', 'href' => $base . '?page_id=25867'],
                                    ['label' => 'Encontro Formativo "As Contribuições da Neurociência para a Prática Pedagógica"', 'href' => $base . '?page_id=27096'],
                                    ['label' => '5º Festival de Vídeo Estudantil', 'href' => $base . '?page_id=27242'],
                                    ['label' => 'Escritas pelo Rio Grande 2018', 'href' => $base . '?page_id=27667'],
                                    ['label' => 'Curso de Violão', 'href' => $base . '?page_id=27838'],
                                    ['label' => 'Oficinas Anos Iniciais', 'href' => $base . '?page_id=27790'],
                                    ['label' => '"6º Seminário Municipal de Diversidade e Inclusão"', 'href' => $base . '?page_id=28043'],
                                    ['label' => '2º Edição do Festival "Dança Estudantes"', 'href' => $base . '?page_id=28163'],
                                    ['label' => '2ª OMMERG', 'href' => $base . '?page_id=28434'],
                                    ['label' => 'Vivências do Dia do Alfabetizador 2018', 'href' => $base . '?page_id=28444'],
                                    ['label' => 'Literatura Afro-Brasileira', 'href' => $base . '?page_id=28587'],
                                    ['label' => 'Matrículas 2018/2019', 'href' => $base . '?page_id=28627'],
                                    ['label' => '3ª Copa Cidade do Rio Grande de Punhobol Escolar', 'href' => $base . '?page_id=29187'],
                                    ['label' => 'II Encontro Formativo da EJA', 'href' => $base . '?page_id=29377'],
                                    ['label' => '4º Seminário Municipal da EJA', 'href' => $base . '?page_id=29859'],
                                    ['label' => 'Revista Digital do Projeto "Escritas pelo Rio Grande: uma cidade para se amar, cuidar e sentir"', 'href' => $base . '?page_id=30206'],
                                ],
                            ],
                            [
                                'label' => 'Atividades 2017', 'href' => $base . '?page_id=21088',
                                'children' => [
                                    ['label' => '1ª OMMERG – 2017', 'href' => $base . '?page_id=21090'],
                                    ['label' => 'Edital de Seleção Pública para Professores Formadores Locais do PNAIC', 'href' => $base . '?page_id=23175'],
                                    ['label' => 'Matrículas 2017/2018', 'href' => $base . '?page_id=23192'],
                                    ['label' => 'Eleição de Diretores e Vice-diretores das Escolas da Rede Municipal 2017', 'href' => $base . '?page_id=23261'],
                                    ['label' => '1º Festival "Dança Estudantes"', 'href' => $base . '?page_id=23838'],
                                ],
                            ],
                            [
                                'label' => 'Atividades 2016', 'href' => $base . '?page_id=18582',
                                'children' => [
                                    ['label' => 'Matrículas 2016/2017', 'href' => $base . '?page_id=19237'],
                                ],
                            ],
                            [
                                'label' => 'Atividades 2015', 'href' => $base . '?page_id=13363',
                                'children' => [
                                    ['label' => 'EDITAL VALDIR CASTRO – Nº 01/2015', 'href' => $base . '?page_id=12212'],
                                    ['label' => 'Inscrições para EBAHL 1/2015', 'href' => $base . '?page_id=12378'],
                                    ['label' => 'Inscrições para EBAHL 2/2015', 'href' => $base . '?page_id=12713'],
                                    ['label' => 'Oficina de Jogos Boole', 'href' => $base . '?page_id=12474'],
                                    ['label' => 'Oficina de Matemática Anos Iniciais e Anos Finais', 'href' => $base . '?page_id=12519'],
                                    ['label' => 'Fórum 127 anos Pós-abolição', 'href' => $base . '?page_id=13361'],
                                    ['label' => 'Oficina de Produção Textual', 'href' => $base . '?page_id=12827'],
                                    ['label' => 'Conversas sobre 11ª OBMEP', 'href' => $base . '?page_id=13325'],
                                    ['label' => 'Oficina de Punhobol', 'href' => $base . '?page_id=13356'],
                                ],
                            ],
                            [
                                'label' => 'Atividades 2014', 'href' => $base . '?page_id=12164',
                                'children' => [
                                    ['label' => 'EDITAL BELAS ARTES – Nº 01/2014', 'href' => $base . '?page_id=11003'],
                                    ['label' => 'EDITAL BELAS ARTES – Nº 02/2014', 'href' => $base . '?page_id=11191'],
                                    ['label' => 'Matrículas 2014', 'href' => $base . '?page_id=11404'],
                                    ['label' => '2º Seminário Municipal de Diversidade e Inclusão', 'href' => $base . '?page_id=11447'],
                                    ['label' => 'II Encontro de Educação e Tecnologia', 'href' => $base . '?page_id=11681'],
                                    ['label' => 'Inscrições para Novembro Negro SMEd', 'href' => $base . '?page_id=11734'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Núcleos Pedagógicos', 'href' => $base . '?page_id=291',
                        'children' => [
                            ['label' => 'Núcleo de Bibliotecas', 'href' => $base . '?page_id=416'],
                            [
                                'label' => 'Núcleo de Diversidade e Inclusão', 'href' => $base . '?page_id=1561',
                                'children' => [
                                    ['label' => 'Educação Especial/ Inclusiva', 'href' => $base . '?page_id=44470'],
                                ],
                            ],
                            ['label' => 'Núcleo de Educação de Jovens e Adultos (EJA)', 'href' => $base . '?page_id=6045'],
                            ['label' => 'Núcleo de Educação do Campo', 'href' => $base . '?page_id=6041'],
                            [
                                'label' => 'Núcleo de Educação Infantil', 'href' => $base . '?page_id=445',
                                'children' => [
                                    ['label' => 'Documentos', 'href' => $base . '?page_id=9772'],
                                    ['label' => 'Oficinas Abril 2014', 'href' => $base . '?page_id=9480'],
                                    ['label' => 'Oficinas Maio 2014', 'href' => $base . '?page_id=9905'],
                                    ['label' => 'Oficinas Julho 2014', 'href' => $base . '?page_id=10453'],
                                ],
                            ],
                            ['label' => 'Núcleo de Educação Integral', 'href' => $base . '?page_id=6043'],
                            [
                                'label' => 'Núcleo de Ensino Fundamental', 'href' => $base . '?page_id=459',
                                'children' => [
                                    ['label' => 'Anos Iniciais do Ensino Fundamental', 'href' => $base . '?page_id=6029'],
                                    [
                                        'label' => 'Anos Finais do Ensino Fundamental', 'href' => $base . '?page_id=467',
                                        'children' => [
                                            ['label' => 'Assessoria das Relações Étnico-Raciais (ARER)', 'href' => $base . '?page_id=3670'],
                                        ],
                                    ],
                                ],
                            ],
                            ['label' => 'Núcleo de Gestão', 'href' => $base . '?page_id=6047'],
                            ['label' => 'Núcleo de Iniciação Esportiva', 'href' => $base . '?page_id=6037'],
                            ['label' => 'Núcleo de Supervisão e Orientação Escolar', 'href' => $base . '?page_id=474'],
                            [
                                'label' => 'Núcleo de Tecnologia Municipal (NTM)', 'href' => $base . '?page_id=340',
                                'children' => [
                                    ['label' => 'Banco de Projetos do NTM', 'href' => $base . '?page_id=14701'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Programas e Projetos', 'href' => $base . '?page_id=289',
                        'children' => [
                            ['label' => 'Brasil Alfabetizado', 'href' => $base . '?page_id=8922'],
                            ['label' => 'Mais Educação', 'href' => $base . '?page_id=8913'],
                            ['label' => 'PDE', 'href' => $base . '?page_id=8915'],
                            ['label' => 'Projeto Escola ComVida', 'href' => $base . '?page_id=8917'],
                            ['label' => 'Projeto Escola Viva', 'href' => $base . '?page_id=8911'],
                        ],
                    ],
                    ['label' => 'Plano Municipal de Educação', 'href' => $base . '?page_id=13998'],
                    [
                        'label' => 'Rio Grande 280 anos', 'href' => $base . '?page_id=20528',
                        'children' => [
                            ['label' => 'Revista Digital "Escritas pelo Rio Grande: uma cidade para se amar"', 'href' => $base . '?page_id=24232'],
                        ],
                    ],
                    ['label' => 'Referências', 'href' => $base . '?page_id=286'],
                ],
            ],
            [
                'label' => 'Gestão da Educação', 'href' => $base . '?page_id=72',
                'children' => [
                    ['label' => 'Núcleo de Alimentação Escolar', 'href' => $base . '?page_id=9951'],
                    ['label' => 'Arquivo Geral', 'href' => $base . '?page_id=34333'],
                ],
            ],
            [
                'label' => 'Conselhos', 'href' => $base . '?page_id=2278',
                'children' => [
                    [
                        'label' => 'Fórum COMED', 'href' => $base . '?page_id=44429',
                        'children' => [
                            ['label' => '10º COMED: Caminhos da Educação para o próximo decênio, desafios e avanços das políticas públicas educacionais -2025', 'href' => $base . '?page_id=46841'],
                            [
                                'label' => '7º COMED: Avanços e Desafios do Sistema Municipal de Ensino', 'href' => $base . '?page_id=18584',
                                'children' => [
                                    ['label' => 'Inscrições para o 7º COMED: Avanços e Desafios do Sistema Municipal de Ensino', 'href' => $base . '?page_id=18606'],
                                ],
                            ],
                            ['label' => '6º COMED', 'href' => $base . '?page_id=10150'],
                            ['label' => '8º COMED', 'href' => $base . '?page_id=27230'],
                            ['label' => 'Conferência Municipal de Educação', 'href' => $base . '?page_id=12856'],
                        ],
                    ],
                    [
                        'label' => 'Conselho Municipal de Educação – CME', 'href' => $base . '?page_id=3571',
                        'children' => [
                            ['label' => 'CÂMARAS DO CME: 2022/2023', 'href' => $base . '?page_id=43324'],
                            ['label' => 'Regional AZONASUL de CMEs', 'href' => $base . '?page_id=17266'],
                            ['label' => 'Competências do CME', 'href' => $base . '?page_id=40047'],
                            ['label' => 'Composição do CME', 'href' => $base . '?page_id=40051'],
                            ['label' => 'Atas CME 2019 /2020/ 2021/ 2022/ 2023/ 2024/ 2025/ 2026', 'href' => $base . '?page_id=42079'],
                            ['label' => 'Atas CME 2021', 'href' => $base . '?page_id=40053'],
                            ['label' => 'Atas CME 2020', 'href' => $base . '?page_id=40056'],
                            ['label' => 'Atas CME 2019', 'href' => $base . '?page_id=40058'],
                            ['label' => 'Atas CME 2018', 'href' => $base . '?page_id=40061'],
                            ['label' => 'Atas CME 2017', 'href' => $base . '?page_id=40065'],
                            ['label' => 'Atas CME 2016', 'href' => $base . '?page_id=40067'],
                            ['label' => 'Atas CME 2015', 'href' => $base . '?page_id=40069'],
                            ['label' => 'Atas CME 2014', 'href' => $base . '?page_id=40071'],
                            ['label' => 'Notas e Informes', 'href' => $base . '?page_id=44491'],
                            ['label' => 'Pareceres 2011', 'href' => $base . '?page_id=40074'],
                            ['label' => 'Pareceres 2012', 'href' => $base . '?page_id=40076'],
                            ['label' => 'Pareceres 2013', 'href' => $base . '?page_id=41243'],
                            ['label' => 'Pareceres 2014', 'href' => $base . '?page_id=40078'],
                            ['label' => 'Pareceres 2015', 'href' => $base . '?page_id=40085'],
                            ['label' => 'Pareceres 2016', 'href' => $base . '?page_id=40087'],
                            ['label' => 'Pareceres 2017', 'href' => $base . '?page_id=40092'],
                            ['label' => 'Pareceres 2018', 'href' => $base . '?page_id=40094'],
                            ['label' => 'Pareceres 2019', 'href' => $base . '?page_id=40096'],
                            ['label' => 'Pareceres 2020', 'href' => $base . '?page_id=40099'],
                            ['label' => 'Pareceres 2021', 'href' => $base . '?page_id=40102'],
                            ['label' => 'Pareceres 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025 e 2026', 'href' => $base . '?page_id=42199'],
                            ['label' => 'Resoluções', 'href' => $base . '?page_id=40104'],
                            ['label' => 'Instruções Normativas', 'href' => $base . '?page_id=40106'],
                        ],
                    ],
                    ['label' => 'Conselho do FUNDEB', 'href' => $base . '?page_id=3766'],
                    ['label' => 'Conselho de Alimentação Escolar (CAE)', 'href' => $base . '?page_id=9695'],
                ],
            ],
            [
                'label' => 'SMEd', 'href' => $base . '?page_id=250',
                'children' => [
                    ['label' => 'Contatos das Escolas', 'href' => $base . '?page_id=301'],
                    [
                        'label' => 'Escola em Destaque', 'href' => $base . '?page_id=4295',
                        'children' => [
                            ['label' => 'EMEE Maria Lucia Luzzardi', 'href' => $base . '?page_id=4550'],
                            ['label' => 'EMEF Sant\'Ana', 'href' => $base . '?page_id=4298'],
                            ['label' => 'Prof.ª Marília Rodrigues Santos', 'href' => $base . '?page_id=4712'],
                        ],
                    ],
                    ['label' => 'Histórico', 'href' => $base . '?page_id=1352'],
                    [
                        'label' => 'Legislação', 'href' => $base . '?page_id=5943',
                        'children' => [
                            ['label' => 'Educação Infantil', 'href' => $base . '?page_id=328'],
                            ['label' => 'Ensino Fundamental de 9 anos', 'href' => $base . '?page_id=1106'],
                        ],
                    ],
                    [
                        'label' => 'Professor em Prosa & Verso', 'href' => $base . '?page_id=4014',
                        'children' => [
                            ['label' => 'Poesia de Rosângela da Silva Pereira', 'href' => $base . '?page_id=4042'],
                            ['label' => 'Poesias de Leandro Azevedo Vargas', 'href' => $base . '?page_id=4016'],
                            ['label' => 'Poemas de Lourdes Luciana M. Sampaio', 'href' => $base . '?page_id=12654'],
                        ],
                    ],
                    ['label' => 'Quem é quem na SMEd', 'href' => $base . '?page_id=5570'],
                    ['label' => 'Secretários(as) anteriores', 'href' => $base . '?page_id=2629'],
                    ['label' => 'Fale com a SMEd', 'href' => $base . '?page_id=38824'],
                    [
                        'label' => 'ARL', 'href' => $base . '?page_id=4057',
                        'children' => [
                            [
                                'label' => 'Acadêmicos', 'href' => $base . '?page_id=4256',
                                'children' => [
                                    ['label' => 'Dalva Leal Martins', 'href' => $base . '?page_id=4244'],
                                    ['label' => 'Iracema dos Santos Martins', 'href' => $base . '?page_id=4348'],
                                    ['label' => 'José Antonio Klaes Roig', 'href' => $base . '?page_id=4328'],
                                    ['label' => 'José Paulo Rodrigues Nobre', 'href' => $base . '?page_id=4353'],
                                    ['label' => 'Marcos Costa Filho', 'href' => $base . '?page_id=4273'],
                                    ['label' => 'Teodolinda Domingas Batezat de Souza', 'href' => $base . '?page_id=4359'],
                                ],
                            ],
                            [
                                'label' => 'Membros Correspondentes', 'href' => $base . '?page_id=4258',
                                'children' => [
                                    ['label' => 'António José Barradas Barroso', 'href' => $base . '?page_id=4468'],
                                    ['label' => 'Basilina Pereira', 'href' => $base . '?page_id=4384'],
                                    ['label' => 'Caroline Fontoura Danigno', 'href' => $base . '?page_id=4456'],
                                    ['label' => 'Elba Khadija', 'href' => $base . '?page_id=4387'],
                                    ['label' => 'José Moreira da Silva', 'href' => $base . '?page_id=4368'],
                                    ['label' => 'Mirême Miranda Pessôa de Mello Sartori', 'href' => $base . '?page_id=4372'],
                                    ['label' => 'Nadir Silveira Dias', 'href' => $base . '?page_id=4376'],
                                    ['label' => 'Ramão Maria Pires', 'href' => $base . '?page_id=4379'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            ['label' => 'Gabinete', 'href' => $base . '?page_id=6012'],
        ];
    }

    public function run(): void
    {
        MenuPrincipal::query()->delete();

        $this->inserir($this->arvore(), null);
    }

    private function inserir(array $itens, ?int $parentId): void
    {
        foreach ($itens as $ordem => $item) {
            $menu = MenuPrincipal::create([
                'label' => $item['label'],
                'href' => $item['href'] ?? null,
                'ordem' => $ordem,
                'parent_id' => $parentId,
            ]);

            if (!empty($item['children'])) {
                $this->inserir($item['children'], $menu->id);
            }
        }
    }
}
