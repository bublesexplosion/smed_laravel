<script setup>
    import { ref } from 'vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import ModalGroup from './ModalGroup.vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({ 
        groups: Array,
        menuItems: Array 
    });

    const showModal = ref(false);
    const selectedGroup = ref(null);

    const openModal = (group = null) => {
        selectedGroup.value = group;
        showModal.value = true;
    };

    const deleteGroup = (id) => {
        if (confirm('Tem certeza que deseja excluir este grupo? Usuários vinculados a ele podem perder acessos.')) {
            router.delete(route('admin.groups.destroy', id));
        }
    };
</script>

<template>
    <AdminLayout title="Grupos e Permissões">
        <div class="br-card">
            <!-- Cabeçalho padrão GovBR -->
            <div class="card-header d-flex justify-content-between align-items-center bg-blue-warm-50 text-white p-3">
                <h2 class="h5 m-0">Gerenciar Grupos de Acesso</h2>
                <button class="br-button secondary inverted small" @click="openModal()">
                    <i class="fas fa-plus mr-1"></i> Novo Grupo
                </button>
            </div>
            
            <div class="card-content p-0">
                <table class="br-table w-100">
                    <thead>
                        <tr>
                            <th width="250">Nome do Grupo</th>
                            <th>Permissões de Menu</th>
                            <th class="text-center" width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="group in groups" :key="group.id">
                            <td class="font-weight-bold">{{ group.name }}</td>
                            <td>
                                <!-- Lista as tags dos menus vinculados -->
                                <template v-if="group.menu_items && group.menu_items.length > 0">
                                    <span v-for="item in group.menu_items" :key="item.id" class="br-tag bg-blue-10 mr-1 mb-1">
                                        {{ item.label }}
                                    </span>
                                </template>
                                <span v-else class="text-muted small">Nenhum menu vinculado</span>
                            </td>
                            <td class="text-center">
                                <button class="br-button circle secondary small mr-1" 
                                        title="Editar Grupo"
                                        @click="openModal(group)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="br-button circle danger small" 
                                        title="Excluir Grupo"
                                        @click="deleteGroup(group.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Componente do Modal -->
        <ModalGroup 
            v-if="showModal" 
            :group="selectedGroup" 
            :menuItems="menuItems"
            @close="showModal = false" 
        />
    </AdminLayout>
</template>

<style scoped>
/* Ajuste para as tags não ficarem coladas no topo da célula */
.br-tag {
    display: inline-flex;
    margin-top: 2px;
    color: #17237c;
}
</style>
