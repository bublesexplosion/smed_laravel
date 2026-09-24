<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import WelcomeFooter from '@/Components/WelcomeFooter.vue';
import WelcomeHeader from '@/Components/WelcomeHeader.vue';

const props = defineProps({
    noticias: { type: Object, required: true },
    filtros: {
        type: Object,
        default: () => ({ busca: '', data_inicio: '', data_fim: '', ordenacao: 'recentes' }),
    },
});

const busca = ref(props.filtros.busca || '');
const dataInicio = ref(props.filtros.data_inicio || '');
const dataFim = ref(props.filtros.data_fim || '');
const ordenacao = ref(props.filtros.ordenacao || 'recentes');
const ultimosSeteDias = ref(false);
const filtroAberto = ref(false);

const aplicarUltimosSeteDias = () => {
    if (!ultimosSeteDias.value) {
        return;
    }

    const hoje = new Date();
    const seteDiasAtras = new Date();
    seteDiasAtras.setDate(hoje.getDate() - 7);

    const paraISO = (data) => data.toISOString().slice(0, 10);
    dataInicio.value = paraISO(seteDiasAtras);
    dataFim.value = paraISO(hoje);
};

const pesquisar = () => {
    router.get(route('noticias.index'), {
        busca: busca.value || undefined,
        data_inicio: dataInicio.value || undefined,
        data_fim: dataFim.value || undefined,
        ordenacao: ordenacao.value !== 'recentes' ? ordenacao.value : undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};

const limparFiltros = () => {
    dataInicio.value = '';
    dataFim.value = '';
    ordenacao.value = 'recentes';
    ultimosSeteDias.value = false;
    pesquisar();
};

const removerFiltro = (chave) => {
    if (chave === 'busca') busca.value = '';
    if (chave === 'periodo') { dataInicio.value = ''; dataFim.value = ''; ultimosSeteDias.value = false; }
    if (chave === 'ordenacao') ordenacao.value = 'recentes';
    pesquisar();
};

const formatarData = (data) => data
    ? new Intl.DateTimeFormat('pt-BR', { dateStyle: 'long' }).format(new Date(data))
    : 'Data não informada';

const formatarDataCurta = (data) => data
    ? new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short' }).format(new Date(`${data}T00:00:00`))
    : '';

const rotuloOrdenacao = { antigos: 'Mais antigas', relevancia: 'Relevância' };

// Chips dos filtros ativos, no padrão de tag interativa (dispensável) do gov.br-ds
const filtrosAtivos = computed(() => {
    const chips = [];
    if (busca.value) chips.push({ chave: 'busca', label: `Busca: "${busca.value}"` });
    if (dataInicio.value || dataFim.value) {
        chips.push({ chave: 'periodo', label: `Período: ${formatarDataCurta(dataInicio.value) || '...'} a ${formatarDataCurta(dataFim.value) || '...'}` });
    }
    if (ordenacao.value !== 'recentes') chips.push({ chave: 'ordenacao', label: `Ordenação: ${rotuloOrdenacao[ordenacao.value]}` });
    return chips;
});

const categoriaDaNoticia = (noticia) => (noticia.tipo === 'page' ? 'Página institucional' : 'Comunicado');

// Páginas numéricas do paginator, sem os links textuais de "Anterior"/"Próximo"
const paginasNumericas = computed(() => props.noticias.links.slice(1, -1));
const linkAnterior = computed(() => props.noticias.links[0]);
const linkProximo = computed(() => props.noticias.links[props.noticias.links.length - 1]);
</script>

<template>
    <Head title="Notícias" />

    <div>
        <WelcomeHeader />

        <main class="container-lg py-4">
            <nav class="br-breadcrumb mb-4" aria-label="Breadcrumb">
                <ol class="crumb-list" role="list">
                    <li class="crumb home">
                        <Link href="/" class="br-button circle" aria-label="Página inicial">
                            <span class="sr-only">Página inicial</span>
                            <i class="fas fa-home" aria-hidden="true"></i>
                        </Link>
                    </li>
                    <li class="crumb" data-active="active">
                        <i class="icon fas fa-chevron-right" aria-hidden="true"></i>
                        <span tabindex="0" aria-current="page">Notícias</span>
                    </li>
                </ol>
            </nav>

            <div class="row mb-4">
                <div class="col">
                    <h1>Últimas Notícias</h1>
                    <p>Acompanhe as principais informações da Secretaria Municipal de Educação.</p>
                </div>
            </div>

            <form class="br-card mb-2" @submit.prevent="pesquisar">
                <div class="card-content">
                    <div class="row align-items-end">
                        <div class="col-sm-8 col-lg-5">
                            <div class="br-input input-button">
                                <label for="busca">Buscar notícias</label>
                                <input id="busca" v-model="busca" type="search" placeholder="Digite título ou resumo" />
                                <button class="br-button" type="submit" aria-label="Pesquisar notícias">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="br-button tertiary" type="button" @click="filtroAberto = !filtroAberto" :aria-expanded="filtroAberto" aria-controls="painel-filtro">
                                Filtrar
                                <i class="fas" :class="filtroAberto ? 'fa-chevron-up' : 'fa-chevron-down'" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div v-if="filtroAberto" id="painel-filtro" class="row mt-4">
                        <div class="col-12 col-md-6">
                            <p class="label mb-1">Período</p>
                            <div class="br-checkbox mb-2">
                                <input id="filtro-7-dias" type="checkbox" v-model="ultimosSeteDias" @change="aplicarUltimosSeteDias" />
                                <label for="filtro-7-dias">Últimos 7 dias</label>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="br-input">
                                        <label for="filtro-data-inicio">De:</label>
                                        <input id="filtro-data-inicio" type="date" v-model="dataInicio" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="br-input">
                                        <label for="filtro-data-fim">Até:</label>
                                        <input id="filtro-data-fim" type="date" v-model="dataFim" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <p class="label mb-1">Ordenação</p>
                            <div class="br-radio">
                                <input id="ordenacao-recentes" type="radio" name="ordenacao" value="recentes" v-model="ordenacao" />
                                <label for="ordenacao-recentes">Data (mais novos primeiro)</label>
                            </div>
                            <div class="br-radio">
                                <input id="ordenacao-antigos" type="radio" name="ordenacao" value="antigos" v-model="ordenacao" />
                                <label for="ordenacao-antigos">Data (mais antigos primeiro)</label>
                            </div>
                            <div class="br-radio">
                                <input id="ordenacao-relevancia" type="radio" name="ordenacao" value="relevancia" v-model="ordenacao" />
                                <label for="ordenacao-relevancia">Relevância</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row justify-content-end align-items-center mt-3">
                                <div class="col-auto">
                                    <button class="br-button" type="button" @click="limparFiltros">Limpar</button>
                                </div>
                                <div class="col-auto">
                                    <button class="br-button primary" type="submit">Aplicar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div v-if="filtrosAtivos.length" class="row mb-2">
                <div class="col">
                    <span v-for="chip in filtrosAtivos" :key="chip.chave" class="br-tag interaction mr-2 mb-2">
                        <span>{{ chip.label }}</span>
                        <button class="br-button" type="button" :aria-label="`Remover filtro: ${chip.label}`" @click="removerFiltro(chip.chave)">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>
                    </span>
                </div>
            </div>

            <p class="text-down-01 mb-3">{{ noticias.total }} notícia(s) encontrada(s)</p>

            <div v-if="noticias.data.length" class="br-list" role="list">
                <template v-for="(noticia, index) in noticias.data" :key="noticia.id">
                    <Link :href="route('noticias.show', noticia.slug)" class="br-item" role="listitem">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-8">
                                <div class="text-weight-semi-bold text-up-01">
                                    {{ noticia.titulo || 'Sem título' }}
                                </div>
                                <p class="text-down-01 mb-0">
                                    {{ noticia.resumo || 'Confira os detalhes desta notícia.' }}
                                </p>
                            </div>
                            <div class="col-12 col-md-4 noticia-meta">
                                <span class="br-tag support noticia-meta-tag">{{ categoriaDaNoticia(noticia) }}</span>
                                <span class="text-down-01 d-block mt-1">
                                    <i class="fas fa-calendar-alt mr-1" aria-hidden="true"></i>
                                    {{ formatarData(noticia.data_publicacao) }}
                                </span>
                            </div>
                        </div>
                    </Link>
                    <span v-if="index < noticias.data.length - 1" class="br-divider"></span>
                </template>
            </div>

            <div v-else class="br-message info" role="status">
                <div class="icon"><i class="fas fa-info-circle" aria-hidden="true"></i></div>
                <div class="content">
                    <span class="message-title">Nenhuma notícia encontrada</span>
                    <span class="message-body">Não há publicações para os filtros informados.</span>
                </div>
            </div>

            <div class="row justify-content-center mt-4 mb-4">
                <div class="col-auto">
                    <Link href="/" class="br-button secondary">Voltar ao início</Link>
                </div>
            </div>

            <nav v-if="paginasNumericas.length > 1" class="br-pagination" aria-label="Paginação das notícias" :data-total="paginasNumericas.length" :data-current="noticias.current_page">
                <ul>
                    <li>
                        <Link
                            class="br-button circle"
                            :class="{ disabled: !linkAnterior.url }"
                            :href="linkAnterior.url || '#'"
                            aria-label="Página anterior"
                            preserve-scroll
                        >
                            <i class="fas fa-angle-left" aria-hidden="true"></i>
                        </Link>
                    </li>
                    <li v-for="link in paginasNumericas" :key="link.label">
                        <Link
                            class="page"
                            :class="{ active: link.active }"
                            :href="link.url || '#'"
                            :aria-label="`Página ${link.label}`"
                            preserve-scroll
                        >
                            <span v-html="link.label"></span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            class="br-button circle"
                            :class="{ disabled: !linkProximo.url }"
                            :href="linkProximo.url || '#'"
                            aria-label="Próxima página"
                            preserve-scroll
                        >
                            <i class="fas fa-angle-right" aria-hidden="true"></i>
                        </Link>
                    </li>
                </ul>
            </nav>
        </main>

        <WelcomeFooter />
    </div>
</template>

<style scoped>
/* Mantém a largura da tag/data fixa para não "pular" entre itens da lista */
.noticia-meta-tag {
    display: inline-block;
    min-width: 170px;
    text-align: center;
}

@media (min-width: 768px) {
    .noticia-meta {
        text-align: right;
    }
}
</style>
