<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import WelcomeFooter from '@/Components/WelcomeFooter.vue';
import WelcomeHeader from '@/Components/WelcomeHeader.vue';

const props = defineProps({
    noticias: { type: Object, required: true },
    filtros: { type: Object, default: () => ({ busca: '' }) },
});

const busca = ref(props.filtros.busca || '');

const pesquisar = () => {
    router.get(route('noticias.index'), { busca: busca.value || undefined }, {
        preserveState: true,
        replace: true,
    });
};

const formatarData = (data) => data
    ? new Intl.DateTimeFormat('pt-BR', { dateStyle: 'long' }).format(new Date(data))
    : 'Data não informada';
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

            <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
                <div>
                    <span class="br-tag">Informação</span>
                    <h1>Notícias</h1>
                    <p>Acompanhe as principais informações do município.</p>
                </div>
                <Link href="/" class="br-button secondary">Voltar ao início</Link>
            </div>

            <form class="br-card mb-4" @submit.prevent="pesquisar">
                <div class="br-card-content p-3">
                    <div class="br-input input-button">
                        <label for="busca">Buscar notícias</label>
                        <input id="busca" v-model="busca" type="search" placeholder="Digite título ou resumo" />
                        <button class="br-button" type="submit" aria-label="Pesquisar notícias">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div v-if="noticias.data.length" class="br-grid-row">
                <div v-for="noticia in noticias.data" :key="noticia.id" class="br-grid-col-12 br-grid-col-md-4 mb-4">
                    <article class="br-card h-100">
                        <div class="br-card-header p-3 d-flex justify-content-between align-items-start">
                            <span class="br-tag">Notícia</span>
                            <time class="text-base" :datetime="noticia.data_publicacao">
                                {{ formatarData(noticia.data_publicacao) }}
                            </time>
                        </div>
                        <div class="br-card-content p-3">
                            <h2 class="h5 mb-3">{{ noticia.titulo || 'Sem título' }}</h2>
                            <p class="text-sm mb-0">
                                {{ noticia.resumo || 'Confira os detalhes desta notícia.' }}
                            </p>
                        </div>
                        <div class="br-card-footer p-3 d-flex justify-content-between align-items-center">
                            <span class="text-sm">{{ noticia.midias_count }} mídia(s)</span>
                            <Link :href="route('noticias.show', noticia.slug)" class="br-button primary small">
                                Ler notícia
                            </Link>
                        </div>
                    </article>
                </div>
            </div>

            <div v-else class="br-message info" role="status">
                <div class="icon"><i class="fas fa-info-circle" aria-hidden="true"></i></div>
                <div class="content"><span class="message-title">Nenhuma notícia encontrada</span><span>Não há publicações para os filtros informados.</span></div>
            </div>

            <nav v-if="noticias.links?.length > 3" class="d-flex justify-content-center gap-2 mt-4" aria-label="Paginação das notícias">
                <Link v-for="link in noticias.links" :key="link.label" :href="link.url || '#'" class="br-button circle small" :class="{ 'disabled': !link.url, 'primary': link.active }" preserve-scroll>
                    <span v-html="link.label"></span>
                </Link>
            </nav>
        </main>

        <WelcomeFooter />
    </div>
</template>
