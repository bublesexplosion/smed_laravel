<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModalSection from './ModalSection.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({ sections: Array });
const showModal = ref(false);
const selectedSection = ref(null);

const openModal = (section = null) => {
    selectedSection.value = section;
    showModal.value = true;
};

const deleteSection = (id) => {
    if (confirm('Excluir esta seção? Isso não removerá os itens vinculados, mas eles podem perder a categoria.')) {
        router.delete(route('admin.menu-sections.destroy', id));
    }
};
</script>

<template>
    <AdminLayout title="Seções de Menu">
        <div class="br-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-blue-warm-50 text-white p-3">
                <h2 class="h5 m-0">Gerenciar Seções do Menu</h2>
                <button class="br-button secondary inverted small" @click="openModal()">
                    <i class="fas fa-plus mr-1"></i> Nova Seção
                </button>
            </div>
            <div class="card-content p-0">
                <table class="br-table w-100">
                    <thead>
                        <tr>
                            <th width="100">Ordem</th>
                            <th>Nome da Seção</th>
                            <th>Icone</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="section in sections" :key="section.id">
                            <td>{{ section.order }}</td>
                            <td>{{ section.name }}</td>
                            <td>{{ section.icon }}</td>
                            <td class="text-center">
                                <button class="br-button circle secondary small mr-1" @click="openModal(section)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="br-button circle danger small" @click="deleteSection(section.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <ModalSection 
            v-if="showModal" 
            :section="selectedSection" 
            @close="showModal = false" 
        />
    </AdminLayout>
</template>
