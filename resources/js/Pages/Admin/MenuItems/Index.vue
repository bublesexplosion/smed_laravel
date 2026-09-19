<script setup>
    import { ref } from 'vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import ModalItem from './ModalItem.vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({ 
        items: Array,
        sections: Array 
    });

    const showModal = ref(false);
    const selectedItem = ref(null);

    const openModal = (item = null) => {
        selectedItem.value = item;
        showModal.value = true;
    };

    const deleteItem = (id) => {
        if (confirm('Deseja remover este link do menu?')) {
            router.delete(route('admin.menu-items.destroy', id));
        }
    };
</script>

<template>
    <AdminLayout title="Itens de Menu">
        <div class="br-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-blue-warm-50 text-white p-3">
                <h2 class="h5 m-0">Gerenciar Itens do Menu</h2>
                
                <button class="br-button secondary inverted small" @click="openModal()">
                    <i class="fas fa-plus mr-1"></i> Novo Item
                </button>
            </div>
            <div class="card-content p-0">
                <table class="br-table w-100">
                    <thead>
                        <tr>
                            <th>Rótulo (Label)</th>
                            <th>Ordem</th>
                            <th>Seção</th>
                            <th>Rota/Link</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items" :key="item.id">
                            <td>
                                <!-- Usando classe estática para o ícone do item e margem à direita -->
                                <i :class="[item.icon || 'fas fa-link', 'mr-2']"></i>
                                {{ item.label }}
                            </td>
                            <td>{{ item.order }}</td>
                            <td>{{ item.menu_section?.name }}</td>
                            <td><code>{{ item.link }}</code></td>
                            <td class="text-center">
                                <button class="br-button circle secondary small mr-1" @click="openModal(item)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="br-button circle danger small" @click="deleteItem(item.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <ModalItem 
            v-if="showModal" 
            :item="selectedItem" 
            :sections="sections"
            @close="showModal = false" 
        />
    </AdminLayout>
</template>
