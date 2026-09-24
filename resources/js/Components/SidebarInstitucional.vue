<script setup>
// Sidebar com links institucionais agrupados, no padrão br-list do gov.br-ds
// Reproduz os grupos/links reais extraídos de https://www.riogrande.rs.gov.br/smed/
// (mesmos nomes e URLs do site em WordPress), só nas páginas Home e Notícias
defineProps({
    grupos: {
        type: Array,
        default: () => ([
            {
                titulo: 'Matrículas',
                links: [
                    { label: 'Aguardando Vaga Educação Infantil – Março 2026', href: 'https://www.riogrande.rs.gov.br/smed/wp-content/uploads/2026/03/AGUARDANDO-VAGA-EDUCACAO-INFANTIL-ATE-11.03.2026-PDF.pdf', externo: true },
                ],
            },
            {
                titulo: 'SMED',
                links: [
                    { label: 'Fale com a SMEd', href: 'https://docs.google.com/forms/d/e/1FAIpQLSd5vWbO56yzH-aPOYwoC5o3kw1SG3cRr1ru0jS-j10eHfzWOw/viewform', externo: true },
                    { label: 'Contatos das Escolas', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=301', externo: true },
                    { label: 'Histórico da SMEd', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=1352', externo: true },
                    { label: 'Secretários(as) Anteriores', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=2629', externo: true },
                ],
            },
            {
                titulo: 'Documentos Pedagógicos',
                links: [
                    { label: 'Portal da Educação', href: 'http://www.riogrande.rs.gov.br/portal-educacao/', externo: true },
                    { label: 'Jornadas Formativas', href: 'http://www.riogrande.rs.gov.br/portal-educacao/jornadas-formativas/', externo: true },
                    { label: 'Plano Municipal de Educação', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=13998', externo: true },
                    { label: 'Base Nacional Comum Curricular', href: 'http://basenacionalcomum.mec.gov.br/#/site/inicio', externo: true },
                    {
                        label: 'Documento Orientador Curricular do Território Rio-grandino',
                        href: 'https://www.riogrande.rs.gov.br/smed/?page_id=38648',
                        externo: true,
                        // Exemplo de link aninhado (submenu), como no widget original do WordPress
                        sublinks: [
                            { label: 'Competências' },
                            { label: 'Cultura Digital' },
                        ],
                    },
                    { label: 'Currículo da Língua Brasileira de Sinais – Libras', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=38258', externo: true },
                    { label: 'Projeto Político Pedagógico e Regimento Escolar das Escolas da Rede Municipal', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=34162', externo: true },
                ],
            },
            {
                titulo: 'Informações',
                links: [
                    { label: 'Arquivo Geral', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=34333', externo: true },
                    { label: 'Ficha de Solicitação de Vale-transporte', href: 'https://www.riogrande.rs.gov.br/smed/wp-content/uploads/2022/11/Ficha-de-Solicitacao-de-Vale-Transporte-1.pdf', externo: true },
                    { label: 'Ficha de Cancelamento de Vale-transporte', href: 'https://www.riogrande.rs.gov.br/smed/wp-content/uploads/2020/12/20201230-ficha_cancelamento_do_vale-tranporte_2021.pdf', externo: true },
                    { label: 'Ficha de Declaração de Residência', href: 'https://www.riogrande.rs.gov.br/smed/wp-content/uploads/2017/05/20170526-declaracao_de_residencia.pdf', externo: true },
                    { label: 'Atestado de Frequência do(a) Professor(a)', href: 'https://www.riogrande.rs.gov.br/smed/wp-content/uploads/2022/11/Atestado-de-Frequencia-doa-Professora-1.pdf', externo: true },
                ],
            },
            {
                titulo: 'Conselhos e Legislação',
                links: [
                    { label: 'Conselho Municipal de Educação – CME', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=3571', externo: true },
                    { label: 'Conselho do FUNDEB', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=3766', externo: true },
                    { label: 'Regional AZONASUL de CMEs', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=17266', externo: true },
                    { label: 'Conselho da Alimentação Escolar – CAE', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=9695', externo: true },
                    { label: 'Legislação', href: 'https://www.riogrande.rs.gov.br/smed/?page_id=5943', externo: true },
                ],
            },
        ]),
    },
});
</script>

<template>
    <aside aria-label="Links institucionais">
        <div v-for="grupo in grupos" :key="grupo.titulo" class="br-list mb-3">
            <div class="header"><div class="title">{{ grupo.titulo }}</div></div>
            <template v-for="link in grupo.links" :key="link.label">
                <a
                    v-if="link.href"
                    class="br-item"
                    :href="link.href"
                    :target="link.externo ? '_blank' : undefined"
                    :rel="link.externo ? 'noopener' : undefined"
                >
                    {{ link.label }}
                </a>
                <span v-else class="br-item">{{ link.label }}</span>

                <!-- Link aninhado (submenu) -->
                <div v-if="link.sublinks?.length" class="sidebar-sublinks">
                    <template v-for="sublink in link.sublinks" :key="sublink.label">
                        <a v-if="sublink.href" class="br-item" :href="sublink.href">{{ sublink.label }}</a>
                        <span v-else class="br-item">{{ sublink.label }}</span>
                    </template>
                </div>
            </template>
        </div>
    </aside>
</template>

<style scoped>
/* Indenta os itens de submenu para diferenciá-los do nível principal */
.sidebar-sublinks .br-item {
    padding-left: calc(var(--spacing-scale-2x, 1rem) * 2);
    font-size: 0.9em;
}
</style>
