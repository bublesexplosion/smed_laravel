<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModalConcessionaria from './ModalConcessionaria.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    concessionarias: Array
});

const showModal = ref(false);
const selectedItem = ref(null);

const openModal = (item = null) => {
    selectedItem.value = item;
    showModal.value = true;
};

const deleteItem = (id) => {
    if (confirm('Deseja remover esta concessionária?')) {
        router.delete(route('admin.concessionarias.destroy', id));
    }
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const [year, month, day] = dateString.split('-');
    return `${day}/${month}/${year}`;
};
</script>

<template>
    <AdminLayout title="Concessionárias">
        <div class="br-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-blue-warm-50 text-white p-3">
                <h2 class="h5 m-0">Gerenciar Concessionárias</h2>
                
                <button class="br-button secondary inverted small" @click="openModal()">
                    <i class="fas fa-plus mr-1"></i> Nova Concessionária
                </button>
            </div>
            
            <div class="card-content p-0">
                <table class="br-table w-100">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Com Imposto</th>
                            <th>Sem Imposto</th>
                            <th>FIOB</th>
                            <th>Data Cad.</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in concessionarias" :key="item.id">
                            <td class="font-weight-bold">{{ item.descricao }}</td>
                            <td>{{ item.comimposto }}</td>
                            <td>{{ item.semimposto }}</td>
                            <td>{{ item.fiob }}</td>
                            <td>{{ formatDate(item.dtcad) }}</td>
                            <td class="text-center">
                                <button class="br-button circle secondary small mr-1" @click="openModal(item)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="br-button circle danger small" @click="deleteItem(item.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="concessionarias.length === 0">
                            <td colspan="6" class="text-center text-muted py-4">
                                Nenhuma concessionária cadastrada.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chamada externa do componente do Modal -->
        <ModalConcessionaria 
            v-if="showModal" 
            :item="selectedItem" 
            @close="showModal = false" 
        />
    </AdminLayout>
</template>
