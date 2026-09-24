<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import WelcomeFooter from '@/Components/WelcomeFooter.vue';
import WelcomeHeader from '@/Components/WelcomeHeader.vue';
import { resolveMidiaUrl, isImagemMidia, isPdfMidia } from '@/Composables/useNoticiaMidia';

const props = defineProps({ noticia: { type: Object, required: true } });
const midiaAberta = ref(null);
const indiceMidia = ref(0);

const formatarData = (data) => data
    ? new Intl.DateTimeFormat('pt-BR', { dateStyle: 'long', timeStyle: 'short' }).format(new Date(data))
    : 'Data não informada';

const urlMidia = resolveMidiaUrl;

const midias = computed(() => props.noticia.midias || []);
const fotos = computed(() => midias.value.filter(isImagemMidia));
const pdfs = computed(() => midias.value.filter(isPdfMidia));
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
                <div class="card-header text-center">
                    <span class="br-tag">Notícia</span>
                    <h1 class="h2 mt-3 mb-2">{{ noticia.titulo || 'Sem título' }}</h1>
                    <p class="mb-0">Informação da Secretaria Municipal de Educação</p>
                </div>

                <div class="card-content">
                    <span class="br-divider my-4"></span>

                    <div class="row align-items-start">
                        <div v-if="fotos.length && urlMidia(fotos[0])" class="col-12 col-md-4 mb-4 mb-md-0">
                            <button class="br-card mb-0" type="button" @click="abrirMidia(fotos[0], 0)">
                                <div class="card-content">
                                    <img
                                        :src="urlMidia(fotos[0])"
                                        :alt="fotos[0].titulo || 'Imagem da notícia'"
                                    />
                                    <p class="mb-0">{{ fotos[0].titulo || 'Imagem da notícia' }}</p>
                                </div>
                            </button>
                        </div>

                        <div class="col-12" :class="{ 'col-md-8': fotos.length && urlMidia(fotos[0]) }">
                            <div class="row align-items-center mb-4">
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt mr-1" aria-hidden="true"></i>
                                    Publicado em {{ formatarData(noticia.data_publicacao) }}
                                </div>
                                <span class="br-divider vertical mx-2"></span>
                                <div class="col-auto">{{ noticia.tipo === 'page' ? 'Página institucional' : 'Comunicado' }}</div>
                            </div>

                            <div v-if="noticia.resumo" class="br-message info mb-4" role="note">
                                <div class="icon"><i class="fas fa-info-circle" aria-hidden="true"></i></div>
                                <div class="content">
                                    <span class="message-title">Resumo</span>
                                    <span class="message-body">{{ noticia.resumo }}</span>
                                </div>
                            </div>

                            <div v-html="noticia.conteudo || '<p>Esta notícia não possui conteúdo.</p>'"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer row align-items-center">
                    <div class="col">SMED • Comunicação institucional</div>
                </div>
            </article>

            <div class="row justify-content-center mt-4 mb-5">
                <div class="col-auto">
                    <Link :href="route('noticias.index')" class="br-button secondary">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        <span>Voltar para notícias</span>
                    </Link>
                </div>
            </div>

            <section v-if="fotos.length > 1" class="mt-5">
                <div class="row align-items-center mb-3">
                    <div class="col-auto"><i class="fas fa-images" aria-hidden="true"></i></div>
                    <div class="col"><h2 class="h4 mb-0">Galeria de fotos</h2></div>
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
                            <div class="carousel-content text-center">
                                <button class="br-card" type="button" @click="abrirMidia(midia, index)">
                                    <div class="card-content">
                                        <img v-if="urlMidia(midia)" :src="urlMidia(midia)" :alt="midia.titulo || `Foto ${index + 1}`" />
                                        <p class="mb-0">{{ midia.titulo || `Foto ${index + 1}` }}</p>
                                    </div>
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
                <div class="row align-items-center mb-3">
                    <div class="col-auto"><i class="fas fa-file-pdf" aria-hidden="true"></i></div>
                    <div class="col"><h2 id="documentos-noticia" class="h4 mb-0">Documentos relacionados</h2></div>
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
                            :src="urlMidia(midiaAtual)"
                            :alt="midiaAtual.titulo || 'Imagem ampliada da notícia'"
                        />
                        <p class="mt-3 mb-0">
                            Imagem {{ indiceMidia + 1 }} de {{ fotos.length }}
                        </p>
                    </div>
                    <div class="br-modal-footer row justify-content-between">
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
