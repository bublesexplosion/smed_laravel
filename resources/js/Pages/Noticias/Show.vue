<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import WelcomeFooter from '@/Components/WelcomeFooter.vue';
import WelcomeHeader from '@/Components/WelcomeHeader.vue';

const props = defineProps({ noticia: { type: Object, required: true } });
const midiaAberta = ref(null);
const indiceMidia = ref(0);

const formatarData = (data) => data
    ? new Intl.DateTimeFormat('pt-BR', { dateStyle: 'long', timeStyle: 'short' }).format(new Date(data))
    : 'Data não informada';

const urlMidia = (midia) => {
    const url = midia.url || midia.caminho_relativo || '';
    const wpContentIndex = url.indexOf('/wp-content/');

    return wpContentIndex >= 0
        ? `http://localhost:8000${url.slice(wpContentIndex)}`
        : url;
};

const midias = computed(() => props.noticia.midias || []);
const fotos = computed(() => midias.value.filter((midia) => {
    const mime = (midia.mime_type || '').toLowerCase();
    return mime.startsWith('image/') || /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(urlMidia(midia));
}));
const pdfs = computed(() => midias.value.filter((midia) => {
    const mime = (midia.mime_type || '').toLowerCase();
    return mime === 'application/pdf' || /\.pdf$/i.test(urlMidia(midia));
}));
const midiaAtual = computed(() => fotos.value[indiceMidia.value] || midiaAberta.value);

const abrirMidia = (midia, indice) => {
    indiceMidia.value = indice;
    midiaAberta.value = midia;
};

const fecharMidia = () => {
    midiaAberta.value = null;
};

const moverFoto = (direcao) => {
    if (!fotos.value.length) return;
    indiceMidia.value = (indiceMidia.value + direcao + fotos.value.length) % fotos.value.length;
};

const navegarMidia = (direcao) => {
    moverFoto(direcao);
    midiaAberta.value = fotos.value[indiceMidia.value];
};
</script>

<template>
    <Head :title="noticia.titulo || 'Notícia'" />

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
                    <li class="crumb">
                        <i class="icon fas fa-chevron-right" aria-hidden="true"></i>
                        <Link :href="route('noticias.index')">Notícias</Link>
                    </li>
                    <li class="crumb" data-active="active">
                        <i class="icon fas fa-chevron-right" aria-hidden="true"></i>
                        <span tabindex="0" aria-current="page">Notícia</span>
                    </li>
                </ol>
            </nav>

            <article class="br-card">
                <header class="br-card-header text-center">
                    <span class="br-tag">Notícia</span>
                    <h1 class="h2 mt-3 mb-2">{{ noticia.titulo || 'Sem título' }}</h1>
                    <p class="text-base mb-0">Informação da Secretaria Municipal de Educação</p>
                </header>

                <div class="br-card-content">
                    <span class="br-divider my-4"></span>

                    <div class="br-grid-row align-items-start">
                        <div v-if="fotos.length && urlMidia(fotos[0])" class="br-grid-col-12 br-grid-col-md-4 mb-4 mb-md-0">
                            <button class="br-card mb-0 p-0 border-0 bg-transparent text-left w-100" type="button" @click="abrirMidia(fotos[0], 0)">
                                <img
                                    :src="urlMidia(fotos[0])"
                                    :alt="fotos[0].titulo || 'Imagem da notícia'"
                                />
                                <div class="br-card-content text-base">
                                    {{ fotos[0].titulo || 'Imagem da notícia' }}
                                </div>
                            </button>
                        </div>

                        <div class="br-grid-col-12" :class="{ 'br-grid-col-md-8': fotos.length && urlMidia(fotos[0]) }">
                            <div class="d-flex align-items-center flex-wrap text-base mb-4">
                                <span>
                                    <i class="fas fa-calendar-alt mr-1" aria-hidden="true"></i>
                                    Publicado em {{ formatarData(noticia.data_publicacao) }}
                                </span>
                                <span class="br-divider vertical mx-3"></span>
                                <span>{{ noticia.tipo === 'page' ? 'Página institucional' : 'Comunicado' }}</span>
                            </div>

                            <div v-if="noticia.resumo" class="br-message info mb-4" role="note">
                                <div class="icon"><i class="fas fa-info-circle" aria-hidden="true"></i></div>
                                <div class="content">
                                    <span class="message-title">Resumo</span>
                                    <span>{{ noticia.resumo }}</span>
                                </div>
                            </div>

                            <div class="text-base" v-html="noticia.conteudo || '<p>Esta notícia não possui conteúdo.</p>'"></div>
                        </div>
                    </div>
                </div>

                <footer class="br-card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="text-base">SMED • Comunicação institucional</span>
                </footer>
            </article>

            <div class="d-flex justify-content-center mt-4 mb-5">
                <Link :href="route('noticias.index')" class="br-button secondary">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    <span>Voltar para notícias</span>
                </Link>
            </div>

            <section v-if="fotos.length > 1" class="mt-5">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-images mr-2" aria-hidden="true"></i>
                    <h2 class="h4 mb-0">Galeria de fotos</h2>
                </div>
                <div class="br-carousel" data-stage="in" aria-label="Galeria de fotos da notícia" aria-roledescription="carousel">
                    <div class="carousel-button">
                        <button class="br-button carousel-btn-prev tertiary circle" type="button" aria-label="Foto anterior" @click="moverFoto(-1)">
                            <i class="fas fa-chevron-left" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="carousel-stage">
                        <div
                            v-for="(midia, index) in fotos"
                            :key="midia.id"
                            class="carousel-page"
                            :active="indiceMidia === index ? 'active' : undefined"
                            role="group"
                            aria-roledescription="slide"
                            :aria-label="`Foto ${index + 1} de ${fotos.length}`"
                        >
                            <div class="carousel-content text-center p-2">
                                <button class="br-card p-0 border-0 bg-transparent text-left" type="button" @click="abrirMidia(midia, index)">
                                    <img v-if="urlMidia(midia)" class="img-fluid" :src="urlMidia(midia)" :alt="midia.titulo || `Foto ${index + 1}`" />
                                    <div class="br-card-content text-base">{{ midia.titulo || `Foto ${index + 1}` }}</div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-button">
                        <button class="br-button carousel-btn-next tertiary circle" type="button" aria-label="Próxima foto" @click="moverFoto(1)">
                            <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </section>

            <section v-if="pdfs.length" class="mt-5" aria-labelledby="documentos-noticia">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-file-pdf mr-2" aria-hidden="true"></i>
                    <h2 id="documentos-noticia" class="h4 mb-0">Documentos relacionados</h2>
                </div>
                <ol class="br-list">
                    <li v-for="(pdf, index) in pdfs" :key="pdf.id" class="br-item">
                        <a class="content" :href="urlMidia(pdf)" target="_blank" rel="noopener">
                            <span class="mr-2">{{ index + 1 }}.</span>
                            <span>{{ pdf.titulo || `Documento PDF ${index + 1}` }}</span>
                        </a>
                        <span class="support">
                            <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                        </span>
                    </li>
                </ol>
            </section>

            <div v-if="midiaAberta" class="br-scrim-util foco active" role="presentation">
                <div class="br-modal large" role="dialog" aria-modal="true" aria-labelledby="titulo-midia">
                    <div class="br-modal-header">
                        <div id="titulo-midia" class="modal-title">
                            {{ midiaAtual?.titulo || 'Mídia da notícia' }}
                        </div>
                        <button class="br-button close circle" type="button" aria-label="Fechar mídia" @click="fecharMidia">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="br-modal-body text-center">
                        <img
                            v-if="midiaAtual && urlMidia(midiaAtual)"
                            class="img-fluid"
                            :src="urlMidia(midiaAtual)"
                            :alt="midiaAtual.titulo || 'Imagem ampliada da notícia'"
                        />
                        <p class="text-base mt-3 mb-0">
                            Imagem {{ indiceMidia + 1 }} de {{ fotos.length }}
                        </p>
                    </div>
                    <div class="br-modal-footer justify-content-between">
                        <button class="br-button secondary" type="button" :disabled="fotos.length < 2" @click="navegarMidia(-1)">
                            <i class="fas fa-chevron-left" aria-hidden="true"></i>
                            Anterior
                        </button>
                        <button class="br-button primary" type="button" :disabled="fotos.length < 2" @click="navegarMidia(1)">
                            Próxima
                            <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
        <WelcomeFooter />
    </div>
</template>
