<script setup>
// Isso resolve o erro "Property 'crumbs' does not exist"
defineProps({
    crumbs: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
  <nav class="flex py-2 mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
      <!-- Ícone Home -->
      <li class="inline-flex items-center">
        <!-- Remova as aspas extras de :href="route(...)" -->
        <a :href="route('dashboard')" class="text-xs uppercase tracking-wider font-semibold text-blue-700 hover:text-blue-900 transition-colors">
          Início
        </a>
      </li>
      
      <!-- Itens Dinâmicos -->
      <li v-for="(crumb, index) in crumbs" :key="index" class="flex items-center">
        <span class="text-gray-400 mx-1">/</span>
        <a v-if="crumb.url" :href="crumb.url" class="text-xs uppercase tracking-wider font-semibold text-blue-700 hover:text-blue-900 transition-colors">
          {{ crumb.label }}
        </a>
        <span v-else class="text-xs uppercase tracking-wider font-semibold text-gray-500">
          {{ crumb.label }}
        </span>
      </li>
    </ol>
  </nav>
</template>
