<script setup>
import { Link } from '@inertiajs/vue3';

// Item de menu recursivo: renderiza qualquer profundidade de subitens (mesmo padrão
// visual menu-item/menu-folder já usado no cabeçalho, só que sem limite de 3 níveis)
defineProps({
    item: { type: Object, required: true },
    nivel: { type: Number, default: 1 },
});

const toggleSubmenu = (event) => {
    event.currentTarget.parentElement.classList.toggle('active');
};

const eLinkExterno = (href) => {
    if (!href) return false;
    return href.startsWith('http://') || href.startsWith('https://');
};

const formatarLinkLocal = (href) => {
    if (!href) return '#';
    if (href.startsWith('http://') || href.startsWith('https://')) return href;
    const pathLimpo = href.replace(/^\/+/, '').replace('smed_laravel/public/', '');
    return '/' + pathLimpo;
};
</script>

<template>
    <div v-if="item.subitems && item.subitems.length > 0" class="menu-folder">
        <a class="menu-item" :class="`sub-item-level-${nivel}`" href="javascript:void(0)" @click="toggleSubmenu">
            <span class="content">{{ item.label }}</span>
            <span class="support"><i class="fas fa-angle-down"></i></span>
        </a>
        <ul>
            <li v-for="subitem in item.subitems" :key="subitem.id">
                <MenuPrincipalItem :item="subitem" :nivel="nivel + 1" />
            </li>
        </ul>
    </div>
    <template v-else>
        <a v-if="eLinkExterno(item.href)" class="menu-item" :class="`sub-item-level-${nivel}`" :href="formatarLinkLocal(item.href)" target="_blank">
            <span class="content">{{ item.label }}</span>
        </a>
        <Link v-else class="menu-item" :class="`sub-item-level-${nivel}`" :href="formatarLinkLocal(item.href)">
            <span class="content">{{ item.label }}</span>
        </Link>
    </template>
</template>

<style scoped>
/* Esconde qualquer lista dentro do menu por padrão, mostra só quando a pasta está ativa */
.menu-body ul,
.menu-folder ul {
    display: none;
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-folder.active > ul {
    display: block;
}

/* Rotaciona a seta quando aberto */
.menu-folder.active > .menu-item .support i {
    transform: rotate(180deg);
}

/* Estilo base de todos os itens do menu */
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

/* Indentação crescente conforme a profundidade real do item */
.sub-item-level-2 { padding-left: 40px; background-color: #fafafa; font-size: 0.95rem; font-weight: 500; border-left: 4px solid transparent; }
.sub-item-level-3 { padding-left: 60px; background-color: #ffffff; font-size: 0.9rem; font-weight: 400; color: #333; }
.sub-item-level-4 { padding-left: 80px; background-color: #fafafa; font-size: 0.85rem; font-weight: 400; color: #333; }
.sub-item-level-5 { padding-left: 100px; background-color: #ffffff; font-size: 0.8rem; font-weight: 400; color: #333; }

.menu-item:hover {
    background-color: #f2f5fd !important;
    border-left: 4px solid #1351b4;
    color: #1351b4;
}

.support {
    margin-left: auto;
    transition: transform 0.2s;
}
</style>
