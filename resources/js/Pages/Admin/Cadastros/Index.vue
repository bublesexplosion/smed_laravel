<script setup>
    import { ref, nextTick } from 'vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { useForm, Link, router } from '@inertiajs/vue3';

    const props = defineProps({
        tipo: Object,
        registros: Array
    });

    const showModal = ref(false);
    const modoEdicao = ref(false);
    const idRegistroSelecionado = ref(null);
    const inputDescricao = ref(null);

    // Adicionado 'valor' iniciando vazio no formulário do Inertia
    const form = useForm({
        descricao: '',
        valor: '' ,
        aux_id: '' ,
        
    });

    const openModalCriar = () => {
        modoEdicao.value = false;
        idRegistroSelecionado.value = null;
        form.reset();
        form.clearErrors();
        showModal.value = true;
        nextTick(() => inputDescricao.value?.focus());
    };

    const openModalEditar = (registro) => {
        modoEdicao.value = true;
        idRegistroSelecionado.value = registro.id;
        form.descricao = registro.descricao;
        form.valor = registro.valor ?? ''; // Garante string vazia se o valor for null
        form.aux_id = registro.aux_id ?? '';
        form.clearErrors();
        showModal.value = true;
        nextTick(() => inputDescricao.value?.focus());
    };

    const closeModal = () => {
        showModal.value = false;
    };

    const submitForm = () => {
        if (modoEdicao.value) {
            form.put(route('admin.tipos.update-item', { slug_tipo: props.tipo.nome_unico, id: idRegistroSelecionado.value }), {
                onSuccess: () => closeModal(),
            });
        } else {
            form.post(route('admin.tipos.store-item', { slug_tipo: props.tipo.nome_unico }), {
                onSuccess: () => closeModal(),
            });
        }
    };

    const deleteItem = (id) => {
        if (confirm('Deseja remover este registro permanentemente?')) {
            router.delete(route('admin.tipos.destroy-item', { slug_tipo: props.tipo.nome_unico, id: id }));
        }
    };

    // Função auxiliar para exibir o valor em formato de moeda local (R$) ou um traço se for nulo
    const formatarMoeda = (valor) => {
        if (!valor && valor !== 0) return '—';
        return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor);
    };
</script>

<template>
    <AdminLayout :title="'Gerenciar ' + tipo.label">
        <!----tabela------>
        <div class="br-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-blue-warm-50 text-white p-3">
                <div class="d-flex align-items-center">
                    <Link :href="route('admin.tipos.index')" class="br-button circle secondary inverted small mr-3" title="Voltar">
                        <i class="fas fa-arrow-left"></i>
                    </Link>
                    <h2 class="h5 m-0">Registros da Tabela  {{ tipo.label }}</h2>
                </div>
                
                <button class="br-button secondary inverted small" @click="openModalCriar">
                    <i class="fas fa-plus mr-1"></i> Novo Registro
                </button>
            </div>
            
            <div class="card-content p-0">
                <table class="br-table w-100">
                    <thead>
                        <tr>
                            <th style="width: 100px;">ID</th>
                            <th>Descrição</th>
                            <th>Aux_id</th>
                            
                            <th style="width: 180px;">Valor</th> <!-- Nova coluna -->
                            <th class="text-center" style="width: 150px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="registro in registros" :key="registro.id">
                            <td>{{ registro.id }}</td>
                            <td>{{ registro.descricao }}</td>
                            <td>{{ registro.aux_id }}</td>
                            
                            <td>{{ registro.valor }}</td> <!-- Exibição formatada   formatarMoeda(em R$) -->
                            <td class="text-center">
                                <button class="br-button circle secondary small mr-1" @click="openModalEditar(registro)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="br-button circle danger small" @click="deleteItem(registro.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="registros.length === 0">
                            <td colspan="4" class="text-center text-muted py-4"> <!-- Colspan atualizado para 4 -->
                                Nenhum registro encontrado para esta tabela.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Unificado -->
        <div v-if="showModal" class="modal-backdrop fade show"></div>
        <div v-if="showModal" class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow border-0" style="border-radius: 4px;">
                    <div class="modal-header bg-blue-warm-50 text-white py-3">
                        <h5 class="modal-title h6 m-0 font-weight-bold">
                            {{ modoEdicao ? 'EDITAR' : 'NOVO' }} REGISTRO
                        </h5>
                        <button type="button" class="close text-white" @click="closeModal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="submitForm">
                        <div class="modal-body py-4">
                            <!-- Input de Descrição -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-secondary mb-2">Descrição</label>
                                <input 
                                    type="text" 
                                    v-model="form.descricao" 
                                    class="form-control" 
                                    :class="{'is-invalid': form.errors.descricao}"
                                    placeholder="Ex: 10mm, Curva 90, Tipo B..."
                                    ref="inputDescricao"
                                    required
                                />
                                <div v-if="form.errors.descricao" class="invalid-feedback">
                                    {{ form.errors.descricao }}
                                </div>
                            </div>

                            <!-- Input de aux_id -->
                            <div class="form-group">
                                <label>Aux_id (Opcional)</label>
                                <div class="input-group">
                                    <input 
                                        type="number" 
                                        step="1" 
                                        min="0"
                                        v-model="form.aux_id" 
                                        class="form-control" 
                                        :class="{'is-invalid': form.errors.aux_id}"
                                        
                                    />
                                    <div v-if="form.errors.aux_id" class="invalid-feedback">
                                        {{ form.errors.aux_id }}
                                    </div>
                                </div>
                            </div>

                            <!-- Novo Input Opcional de Valor -->
                            <div class="form-group">
                                <label class="font-weight-bold text-secondary mb-2">Valor (Opcional)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"></span>
                                    </div>
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        min="0"
                                        v-model="form.valor" 
                                        class="form-control" 
                                        :class="{'is-invalid': form.errors.valor}"
                                        placeholder="0,00"
                                    />
                                    <div v-if="form.errors.valor" class="invalid-feedback">
                                        {{ form.errors.valor }}
                                    </div>
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