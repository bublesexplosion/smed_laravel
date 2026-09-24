<template>
  <Head title="Prefeitura Municipal do Rio Grande" />
  <div class="bg-white min-vh-100">
    <!-- O Header precisa estar aqui -->
    <WelcomeHeader />

    <!-- Banner de Título -->
    <div class=" text-white py-5 mb-4"  style="background-color: var(--blue-warm-vivid-80, #162d4e);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Exemplo de Banner na pagina</h1>
            <p class="lead text-white">Esta pagina fica em resources/js/pages/welcome.vue</p>
        </div>
    </div>

    <main class="container py-4 bg-white shadow-sm rounded">
        <div class="row">
            <div class="col-md-8">

                <Link href="/noticias" class="br-button primary mb-4 ms-2">
                    <i class="fas fa-newspaper me-2"></i> Ver notícias
                </Link>

                <!-- Conteúdo com espaçamento entre parágrafos -->
                <article class="text-secondary lh-lg" style="text-align: justify;">
                    <p class="mb-4">
                        Cidade mais antiga do estado, Rio Grande está localizada na margem Sul do estuário que conduz ao oceano as águas da imensa Laguna dos Patos e seus afluentes.Em 1680, Portugal funda a Colônia do Sacramento, na margem esquerda do estuário do Prata, defronte a Buenos Aires. Próximo à barra chamada do Rio Grande de São Pedro, único acesso oferecido à navegação na costa contínua deveria estabelecer-se o núcleo pioneiro, de onde Portugal faria irradiar o povoamento, consolidando a posse da terra. Favorecendo a infiltração de seus súditos, através de Laguna (Santa Catarina) implantada em 1684, Portugal assentara a base de ocupação do Continente de São Pedro, através de estabelecimentos de criação de gado a ocupar grandes extensões de terra. Essa ocupação fez sentir a necessidade de assistência religiosa e, antes de qualquer ação oficial, que estendesse a soberania lusitana ao Continente cobiçado, uma Provisão de 6 de agosto de 1736 criava a Freguesia de São Pedro,a abranger todo o seu território.
                    </p>

                    <div class="my-5 border-start border-4  ps-4 py-2 bg-light">
                        <h4 class=" text-center italic">"No dia 19 de fevereiro de 1737 </h4>
                        <h4 class="text-center">    a cidade foi fundada pelo Brigadeiro José da Silva Paes"</h4>
                    </div>


                </article>

            </div>
            <div class="col-md-4">
                <SidebarInstitucional />
            </div>
        </div>
    </main>
    <!-- O Footer entra aqui -->
    <WelcomeFooter />

   </div>
</template>

<script setup>
    import { Link, Head } from '@inertiajs/vue3';
    import WelcomeHeader from '@/Components/WelcomeHeader.vue';
    import { ref, onMounted, onUnmounted, computed } from 'vue';
    import WelcomeFooter from '@/Components/WelcomeFooter.vue';
    import SidebarInstitucional from '@/Components/SidebarInstitucional.vue';

   const props = defineProps({
    errors: Object,
    auth: Object,
    canLogin: Boolean
});

    // 3. Acessibilidade e Inicialização
    onMounted(() => {


        if (localStorage.getItem('contrast-mode') === 'true') {
            document.body.classList.add('br-high-contrast');
        }

        const savedFontSize = localStorage.getItem('font-size-pwa');
        if (savedFontSize) {
            document.documentElement.style.fontSize = `${savedFontSize}%`;
        }

        // ==========================================
        // INJEÇÃO AUTOMÁTICA E SEGURA DO VLIBRAS
        // ==========================================
        // 1. Cria a estrutura HTML obrigatória na raiz da página
        const vLibrasDiv = document.createElement('div');
        vLibrasDiv.setAttribute('vw', '');
        vLibrasDiv.className = 'enabled';
        vLibrasDiv.innerHTML = `
            <div vw-access-button class="active"></div>
            <div vw-plugin-wrapper>
                <div class="vw-plugin-top-wrapper"></div>
            </div>
        `;
        document.body.appendChild(vLibrasDiv);

        // 2. Cria a tag de script externo
        const script = document.createElement('script');
        script.src = "https://vlibras.gov.br/app/vlibras-plugin.js";
        script.async = true;

        // 3. Inicializa o bonequinho assim que o arquivo baixar por completo
        script.onload = () => {
            if (window.VLibras) {
                new window.VLibras.Widget('https://vlibras.gov.br/app');
            }
        };

        document.head.appendChild(script);
        // ==========================================
    });


</script>

<style scoped>
        /* 1. Força o fundo da seção e dos cards para branco */
        .br-card,
        .card-content,
        .br-list,
        .br-item {
            background-color: #ffffff !important; /* Branco absoluto no modo normal */
        }

        /* 2. Remove o cinza dos itens e define a borda fina */
        .br-item {
            border-bottom: 1px solid #f0f0f0 !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            min-height: 44px;
        }



        /* 4. Ícones em cinza escuro */
        .br-item i {
            color: #666666 !important;
            font-size: 14px !important;
        }

        /* 5. Ajuste para o modo ALTO CONTRASTE (quando o botão for clicado) */
        /* Isso garante que quando o contraste ligar, o branco vire preto */
        :global(body.br-high-contrast) .br-card,
        :global(body.br-high-contrast) .card-header,
        :global(body.br-high-contrast) .br-item {
            background-color: #000000 !important;
            border-color: #ffffff !important;
        }

        :global(body.br-high-contrast) .br-item span,
        :global(body.br-high-contrast) .br-item i,
        :global(body.br-high-contrast) .card-header .font-bold {
            color: #ffffff !important; /* Letras ficam brancas no fundo preto */
        }

        /* No seu <style scoped> */
        :global(body.br-high-contrast) .bg-blue-700 {
            background-color: #000 !important;
            border-right: 1px solid #fff;
        }

        :global(body.br-high-contrast) .text-blue-900,
        :global(body.br-high-contrast) .text-blue-700,
        :global(body.br-high-contrast) .text-blue-600 {
            color: #fff !important;
        }

        :global(body.br-high-contrast) .border-blue-800 {
            border-color: #fff !important;
        }

        /* Garante que o card de evento fique preto no contraste */
        :global(body.br-high-contrast) .flex.bg-white {
            background-color: #000 !important;
            border: 1px solid #fff !important;
        }
        /* para aparecer os botões em cima do banner*/
        /* Container dos controles - posiciona sobre o banner */
        .carousel-controls {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-between; /* Afasta as setas para as pontas */
            align-items: center; /* Centraliza verticalmente */
            pointer-events: none; /* Permite que cliques passem pelo container e atinjam os botões */
            z-index: 10; /* Garante que fique acima da imagem */
        }

        /* Estilo geral dos botões (setas) */
        .btn-circle {
            pointer-events: auto; /* Reativa o clique no botão */
            background: rgba(0, 0, 0, 0.3); /* Fundo semi-transparente */
            color: rgb(86, 89, 182);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            margin: 0 20px;
            transition: background 0.3s;
        }

        .btn-circle:hover {
            background: rgba(0, 0, 0, 0.6);
        }

        /* Container das bolinhas (dots) */
        .dots-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            pointer-events: auto;
        }

        /* Estilo das bolinhas */
        .dot {
            width: 12px;
            height: 12px;
            background: rgba(54, 97, 190, 0.784);
            border-radius: 50%;
            cursor: pointer;
        }

        .dot.active {
            background: white;
            transform: scale(1.2);
        }

</style>

