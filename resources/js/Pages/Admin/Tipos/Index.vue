<script setup>
    import { ref } from 'vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { useForm, router } from '@inertiajs/vue3';

    defineProps({
        tipos: Array
    });

    const showModal = ref(false);
    const modoEdicao = ref(false);
    const idTipoSelecionado = ref(null);

    const form = useForm({
        label: ''
    });

    const openModalCriar = () => {
        modoEdicao.value = false;
        idTipoSelecionado.value = null;
        form.reset();
        form.clearErrors();
        showModal.value = true;
    };

    const openModalEditar = (tipo) => {
        modoEdicao.value = true;
        idTipoSelecionado.value = tipo.id;
        form.label = tipo.label;
        form.clearErrors();
        showModal.value = true;
    };

    const closeModal = () => {
        showModal.value = false;
    };

    const submitForm = () => {
        if (modoEdicao.value) {
            form.put(route('admin.tipos.update', idTipoSelecionado.value), {
                onSuccess: () => closeModal(),
            });
        } else {
            form.post(route('admin.tipos.store'), {
                onSuccess: () => closeModal(),
            });
        }
    };

    const deleteTipo = (id) => {
        if (confirm('Atenção: Excluir esta tabela removerá permanentemente TODOS os registros vinculados a ela! Deseja continuar?')) {
            router.delete(route('admin.tipos.destroy', id));
        }
    };
</script>

<template>
    <AdminLayout title="Tabelas Base">
        <div class="br-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-blue-warm-50 text-white p-3">
                <h2 class="h5 m-0">TABELAS DE CADASTROS BASE</h2>
                
                <button class="br-button secondary inverted small" @click="openModalCriar">
                    <i class="fas fa-plus mr-1"></i> Nova Tabela
                </button>
            </div>
            
            <div class="card-content p-0">
                <table class="br-table w-100">
                    <thead>
                        <tr>
                            <th>Nome da Tabela (Plural)</th>
                            <th>Identificador Único</th>
                            <th class="text-center" style="width: 150px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="tipo in tipos" :key="tipo.id">
                            <td>
                                <i class="fas fa-table mr-2 text-primary"></i>
                                <strong>{{ tipo.label }}</strong>
                            </td>
                            <td><code>{{ tipo.nome_unico }}</code></td>
                            <td class="text-center">
                                <!-- Botão Editar Tipo -->
                                <button class="br-button circle secondary small mr-1" @click="openModalEditar(tipo)" title="Editar Tabela">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Botão Excluir Tipo -->
                                <button class="br-button circle danger small" @click="deleteTipo(tipo.id)" title="Excluir Tabela">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="tipos.length === 0">
                            <td colspan="3" class="text-center text-muted py-4">
                                Nenhuma tabela cadastrada no sistema ainda.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Unificado (Criar e Editar) -->
        <div v-if="showModal" class="modal-backdrop fade show"></div>
        <div v-if="showModal" class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow border-0" style="border-radius: 4px;">
                    <div class="modal-header bg-blue-warm-50 text-white py-3">
                        <h5 class="modal-title h6 m-0 font-weight-bold">
                            {{ modoEdicao ? 'EDITAR' : 'CRIAR' }} TABELA AUXILIAR
                        </h5>
                        <button type="button" class="close text-white" @click="closeModal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="submitForm">
                        <div class="modal-body py-4">
                            <div class="form-group">
                                <label class="font-weight-bold text-secondary mb-2">Nome da Tabela (Plural)</label>
                                <input 
                                    type="text" 
                                    v-model="form.label" 
                                    class="form-control" 
                                    :class="{'is-invalid': form.errors.label}"
                                    placeholder="Ex: Disjuntores, Buchas, Canaletas..."
                                    required
                                />
                                <div v-if="form.errors.label" class="invalid-feedback">
                                    {{ form.errors.label }}
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-end border-0 pb-3">
                            <button type="button" class="br-button secondary small mr-2" @click="closeModal">
                                Cancelar
                            </button>
                            <button type="submit" class="br-button primary small" :disabled="form.processing">
                                Confirmar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background-color: rgba(0, 0, 0, 0.4);
    z-index: 1040;
}
.modal { z-index: 1050; }
</style>
