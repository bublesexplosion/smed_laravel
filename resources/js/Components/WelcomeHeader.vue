<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import HeaderDropdown from '@/Components/HeaderDropdown.vue';

const appUrl = import.meta.env.APP_URL;
const page = usePage();

const props = defineProps({
    menuData: {
        type: Array,
        default: () => [],
    },
});

// =========================================================================
// OPÇÃO 2: ARRAY VUE ESTÁTICO (ATIVO POR PADRÃO PARA AMBOS OS MENUS)
// =========================================================================
const menuArrayVue = ref([
    { id: 1, label: 'Início', href: '/' },
    { id: 2, label: 'Recursos Educacionais', href: '/noticias?categoria=recursos' },
    {
        id: 3,
        label: 'Gestão Pedagógica',
        href: null,
        subitems: [
            { id: 31, label: 'Notícias 2023/2024', href: '/noticias' },
            { id: 32, label: 'Atividades 2021', href: '/noticias?busca=2021' },
            { id: 33, label: 'Núcleos Pedagógicos', href: '/noticias?categoria=nucleos' },
            { id: 34, label: 'Programas e Projetos', href: '/noticias?categoria=programas' },
        ],
    },
    {
        id: 4,
        label: 'Gestão da Educação',
        href: null,
        subitems: [
            { id: 41, label: 'Núcleo de Alimentação Escolar', href: '/noticias/conselho-de-alimentacao-escolar-cae' },
            { id: 42, label: 'Arquivo Geral', href: '/noticias/arquivo-geral' },
        ],
    },
    {
        id: 5,
        label: 'Conselhos',
        href: null,
        subitems: [
            { id: 51, label: 'Conselho Municipal de Educação – CME', href: '/noticias/conselho-municipal-de-educacao-cme' },
            { id: 52, label: 'Conselho do FUNDEB', href: '/noticias/conselho-do-fundeb' },
            { id: 53, label: 'Regional AZONASUL de CMEs', href: '/noticias/regional-azonasul-de-cmes' },
            { id: 54, label: 'Conselho da Alimentação Escolar – CAE', href: '/noticias/conselho-de-alimentacao-escolar-cae' },
        ],
    },
    {
        id: 6,
        label: 'SMEd',
        href: null,
        subitems: [
            { id: 61, label: 'Contatos das Escolas', href: '/noticias/contatos' },
            { id: 62, label: 'Histórico da SMEd', href: '/noticias/teste' },
            { id: 63, label: 'Secretários(as) Anteriores', href: '/noticias/secretariosas' },
            { id: 64, label: 'Legislação', href: '/noticias/legislacao-smed-5943' },
        ],
    },
    { id: 7, label: 'Gabinete', href: '/noticias?categoria=gabinete' },
]);

// -------------------------------------------------------------------------
// SELEÇÃO DO MENU COMPUTA:
// -------------------------------------------------------------------------
const menuExibido = computed(() => {
    // ---> OPÇÃO 1 (BANCO DE DADOS VIA INERTIA):
    // return (props.menuData && props.menuData.length > 0) ? props.menuData : page.props.menuData;

    // ---> OPÇÃO 2 (ARRAY VUE ESTÁTICO ATIVO):
    return menuArrayVue.value;
});

// Controle do Menu Lateral Hamburger
const isMenuOpen = ref(false);

const toggleSubmenu = (event) => {
    const folder = event.currentTarget.parentElement;
    folder.classList.toggle('active');
};

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
    if (isMenuOpen.value) {
        document.body.classList.add('scrolling-stop');
    } else {
        document.body.classList.remove('scrolling-stop');
        document.querySelectorAll('.menu-folder').forEach((el) => el.classList.remove('active'));
    }
};

// Controle do Menu Horizontal (Dropdowns do topo)
const activeHorizontalDropdown = ref(null);

const toggleHorizontalDropdown = (id) => {
    activeHorizontalDropdown.value = activeHorizontalDropdown.value === id ? null : id;
};

const openHorizontalDropdown = (id) => {
    activeHorizontalDropdown.value = id;
};

const closeHorizontalDropdown = () => {
    activeHorizontalDropdown.value = null;
};

onMounted(() => {
    if (localStorage.getItem('alto-contraste') === 'true') {
        document.body.classList.add('br-high-contrast');
    }
});

const formatarLinkLocal = (href) => {
    if (!href) return '#';
    if (href.startsWith('http://') || href.startsWith('https://')) return href;
    let pathLimpo = href.replace(/^\/+/, '').replace('Basico/public/', '').replace('smed_laravel/public/', '');
    return '/' + pathLimpo;
};

const eLinkExterno = (href) => {
    if (!href) return false;
    return href.startsWith('http://') || href.startsWith('https://');
};
</script>

<template>
    <header class="br-header">
        <div class="container-lg">
            <div class="header-top">
                <!-- Logo com estrutura corrigida -->
                <div class="header-logo">
                    <Link href="/">
                        <img src="/images/logo.png" alt="Basico" style="max-height: 48px" />
                        <span class="br-divider vertical"></span>
                        <div class="header-sign">Rio Grande</div>
                    </Link>
                </div>

                <div class="header-actions">
                    <!-- Acesso Rápido -->
                    <div class="header-links dropdown">
                        <button
                            class="br-button circle small"
                            type="button"
                            data-toggle="dropdown"
                            aria-label="Abrir Acesso Rápido"
                        >
                            <i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <div class="br-list">
                            <div class="header"><div class="title">Acesso Rápido</div></div>
                            <a class="br-item" href="#">Serviços</a>
                            <a
                                class="br-item"
                                target="_blank"
                                href="https://grp.riogrande.rs.gov.br/transparencia/prefeitura/#/"
                                >Transparência</a
                            >
                            <a class="br-item" href="#">Turismo</a>
                            <a class="br-item" href="https://docker.riogrande.rs.gov.br/investe/visaogeral"
                                >Indicadores</a
                            >
                            <a class="br-item" href="#">Oportunidades</a>
                        </div>
                    </div>

                    <span class="br-divider vertical mx-half mx-sm-1"></span>

                    <!-- Componente Dropdown -->
                    <HeaderDropdown />

                    <div class="header-search-trigger">
                        <button class="br-button circle" type="button" aria-label="Abrir Busca">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="header-login">
                        <div class="header-sign-in">
                            <Link :href="route('login')" class="br-button secondary small rounded-pill"> ENTRAR </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PARTE INFERIOR: MENU HAMBURGER + MENU HORIZONTAL NO TOPO -->
            <div class="header-bottom">
                <div class="header-menu">
                    <div class="header-menu-trigger">
                        <button class="br-button small circle" type="button" aria-label="Menu" @click="toggleMenu">
                            <i class="fas fa-bars" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="header-info">
                        <div class="header-title">Portal Institucional</div>
                    </div>
                </div>

                <!-- MENU HORIZONTAL COM DROPDOWNS NO TOPO -->
                <nav class="header-nav-horizontal">
                    <ul class="horizontal-menu-list">
                        <li
                            v-for="menu in menuExibido"
                            :key="menu.id"
                            class="horizontal-menu-item"
                            @mouseenter="menu.subitems?.length ? openHorizontalDropdown(menu.id) : null"
                            @mouseleave="closeHorizontalDropdown"
                        >
                            <!-- Se possuir subitens (Dropdown) -->
                            <template v-if="menu.subitems && menu.subitems.length > 0">
                                <button
                                    type="button"
                                    class="horizontal-menu-link dropdown-toggle"
                                    @click="toggleHorizontalDropdown(menu.id)"
                                >
                                    <span>{{ menu.label }}</span>
                                    <i class="fas fa-angle-down ms-1 icon-arrow"></i>
                                </button>

                                <!-- Submenu Dropdown Flutuante -->
                                <div v-show="activeHorizontalDropdown === menu.id" class="horizontal-dropdown-menu">
                                    <ul>
                                        <li v-for="subitem in menu.subitems" :key="subitem.id">
                                            <a
                                                v-if="eLinkExterno(subitem.href)"
                                                :href="formatarLinkLocal(subitem.href)"
                                                target="_blank"
                                                class="dropdown-item-link"
                                            >
                                                {{ subitem.label }}
                                            </a>
                                            <Link
                                                v-else
                                                :href="formatarLinkLocal(subitem.href)"
                                                class="dropdown-item-link"
                                            >
                                                {{ subitem.label }}
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </template>

                            <!-- Link simples de 1º nível -->
                            <template v-else>
                                <a
                                    v-if="eLinkExterno(menu.href)"
                                    :href="formatarLinkLocal(menu.href)"
                                    target="_blank"
                                    class="horizontal-menu-link"
                                >
                                    {{ menu.label }}
                                </a>
                                <Link v-else :href="formatarLinkLocal(menu.href)" class="horizontal-menu-link">
                                    {{ menu.label }}
                                </Link>
                            </template>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- MENU LATERAL (HAMBURGER) -->
    <div class="br-menu" :class="{ active: isMenuOpen }" id="main-navigation">
        <div class="menu-container">
            <div class="menu-panel">
                <div class="menu-header">
                    <div class="menu-title">
                        <Link href="/">
                            <img src="/images/logo.png" alt="Basico" style="width: 48px" />
                        </Link>
                        <span>Menu Principal</span>
                    </div>
                    <div class="menu-close">
                        <button class="br-button circle small" type="button" @click="toggleMenu" aria-label="Fechar">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <nav class="menu-body">
                    <template v-for="menu in menuExibido" :key="menu.id">
                        <div v-if="menu.subitems && menu.subitems.length > 0" class="menu-folder">
                            <a class="menu-item" href="javascript:void(0)" @click="toggleSubmenu">
                                <span class="content">{{ menu.label }}</span>
                                <span class="support"><i class="fas fa-angle-down"></i></span>
                            </a>

                            <ul>
                                <li v-for="subitem in menu.subitems" :key="subitem.id">
                                    <div v-if="subitem.subitems && subitem.subitems.length > 0" class="menu-folder">
                                        <a
                                            class="menu-item sub-item-level-2"
                                            href="javascript:void(0)"
                                            @click="toggleSubmenu"
                                        >
                                            <span class="content">{{ subitem.label }}</span>
                                            <span class="support"><i class="fas fa-angle-down"></i></span>
                                        </a>

                                        <ul>
                                            <li v-for="neto in subitem.subitems" :key="neto.id">
                                                <a
                                                    v-if="eLinkExterno(neto.href)"
                                                    class="menu-item sub-item-level-3"
                                                    :href="formatarLinkLocal(neto.href)"
                                                    target="_blank"
                                                >
                                                    <span class="content">{{ neto.label }}</span>
                                                </a>
                                                <Link
                                                    v-else
                                                    class="menu-item sub-item-level-3"
                                                    :href="formatarLinkLocal(neto.href)"
                                                >
                                                    <span class="content">{{ neto.label }}</span>
                                                </Link>
                                            </li>
                                        </ul>
                                    </div>

                                    <template v-else>
                                        <a
                                            v-if="eLinkExterno(subitem.href)"
                                            class="menu-item sub-item-level-2"
                                            :href="formatarLinkLocal(subitem.href)"
                                            target="_blank"
                                        >
                                            <span class="content">{{ subitem.label }}</span>
                                        </a>
                                        <Link
                                            v-else
                                            class="menu-item sub-item-level-2"
                                            :href="formatarLinkLocal(subitem.href)"
                                        >
                                            <span class="content">{{ subitem.label }}</span>
                                        </Link>
                                    </template>
                                </li>
                            </ul>
                        </div>

                        <template v-else>
                            <a
                                v-if="eLinkExterno(menu.href)"
                                class="menu-item"
                                :href="formatarLinkLocal(menu.href)"
                                target="_blank"
                            >
                                <span class="content">{{ menu.label }}</span>
                            </a>
                            <Link v-else class="menu-item" :href="formatarLinkLocal(menu.href)">
                                <span class="content">{{ menu.label }}</span>
                            </Link>
                        </template>
                    </template>
                </nav>
            </div>
            <div class="menu-scrim" @click="toggleMenu"></div>
        </div>
    </div>
</template>

<style scoped>
/* ESTILOS DO MENU HORIZONTAL (TOPO) */
.header-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-nav-horizontal {
    display: flex;
    align-items: center;
}

.horizontal-menu-list {
    display: flex;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 0.25rem;
}

.horizontal-menu-item {
    position: relative;
    list-style: none;
}

.horizontal-menu-link {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.85rem;
    color: #1351b4; /* Azul Gov.br */
    font-weight: 600;
    font-size: 0.92rem;
    text-decoration: none;
    background: transparent;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    transition: background 0.2s, color 0.2s;
}

.horizontal-menu-link:hover,
.horizontal-menu-link:focus {
    background-color: #f2f5fd;
    color: #0c326f;
}

.horizontal-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1050;
    min-width: 230px;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-radius: 0 0 4px 4px;
    border: 1px solid #e0e0e0;
    padding: 0.4rem 0;
}

.horizontal-dropdown-menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: block !important;
}

.dropdown-item-link {
    display: block;
    padding: 0.5rem 1rem;
    color: #333333;
    font-size: 0.88rem;
    font-weight: 500;
    text-decoration: none;
    transition: background 0.15s, color 0.15s;
}

.dropdown-item-link:hover {
    background-color: #f2f5fd;
    color: #1351b4;
}

@media (max-width: 991.98px) {
    .header-nav-horizontal {
        display: none; /* Esconde em telas pequenas para usar o menu hamburger */
    }
}

/* ESTILOS DO MENU LATERAL (HAMBURGER) */
.br-menu {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
}

.br-menu.active {
    display: block;
}

.br-menu .menu-panel {
    width: 300px;
    height: 100%;
    background-color: #ffffff;
    position: absolute;
    left: 0;
    top: 0;
    z-index: 2;
    box-shadow: 3px 0 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.menu-scrim {
    background: rgba(0, 0, 0, 0.45);
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    cursor: pointer;
}

.menu-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
}

.menu-body ul {
    display: none;
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-folder.active > ul {
    display: block;
}

.menu-folder.active > .menu-item .support i {
    transform: rotate(180deg);
}

.menu-item {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #1351b4;
    font-weight: 600;
    padding: 12px 15px;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.2s;
    cursor: pointer;
    line-height: 1.2;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.menu-folder ul .menu-item {
    padding-left: 40px;
    background-color: #fafafa;
    font-size: 0.95rem;
    font-weight: 500;
    border-left: 4px solid transparent;
}

.menu-folder ul ul .menu-item {
    padding-left: 60px;
    background-color: #ffffff;
    font-size: 0.9rem;
    font-weight: 400;
    color: #333;
}

.menu-item:hover {
    background-color: #f2f5fd !important;
    border-left: 4px solid #1351b4;
    color: #1351b4;
}

.support {
    margin-left: auto;
    transition: transform 0.2s;
}

.icon {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}
</style>
