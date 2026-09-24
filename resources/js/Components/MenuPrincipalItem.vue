<script setup>
import { Link } from '@inertiajs/vue3';

// Item de menu recursivo: suporta múltiplos níveis de profundidade conforme Gov.br DS
defineProps({
    item: { type: Object, required: true },
    nivel: { type: Number, default: 1 },
});

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
    <!-- NÍVEL COM FILHOS: Renderiza como 'menu-folder' para permitir aninhamento infinito -->
    <div v-if="item.subitems && item.subitems.length > 0" class="menu-folder">
        <a class="menu-item" href="javascript:void(0)">
            <span class="content">{{ item.label }}</span>
            <span class="support"><i class="fas fa-angle-down"></i></span>
        </a>
        <ul>
            <li v-for="subitem in item.subitems" :key="subitem.id">
                <!-- Chamada recursiva: se o subitem tiver filhos, ele criará outra .menu-folder aqui dentro -->
                <MenuPrincipalItem :item="subitem" :nivel="nivel + 1" />
            </li>
        </ul>
    </div>
    
    <!-- NÍVEL FINAL: Renderiza como link simples -->
    <template v-else>
        <a v-if="eLinkExterno(item.href)" class="menu-item" :href="formatarLinkLocal(item.href)" target="_blank">
            <span class="content">{{ item.label }}</span>
        </a>
        <Link v-else class="menu-item" :href="formatarLinkLocal(item.href)">
            <span class="content">{{ item.label }}</span>
        </Link>
    </template>
</template>
