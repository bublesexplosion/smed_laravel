import { ref, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';

export function useSearch(routeName, initialFilters = {}) {
    const search = ref(initialFilters.search || '');

    const searchInput = ref(null);
    // Watch para disparar a busca com debounce
    watch(search, debounce((value) => {
        router.get(route(routeName), { search: value }, { 
           preserveState: true, 
            replace: true 
        });
    }, 300));

    const limparBusca = () => {
        search.value = '';
        if (searchInput.value) {
            searchInput.value.focus();
        }
    };

    return {
        search,
        searchInput,
        limparBusca
    };
}
