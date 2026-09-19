<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    item: Object
});

const emit = defineEmits(['close']);

const form = useForm({
    id: null,
    descricao: '',
    comimposto: '',
    semimposto: '',
    fiob: '',
    dtcad: ''
});

// Alimenta o formulário dinamicamente se for uma edição
watch(() => props.item, (newVal) => {
    if (newVal) {
        form.id = newVal.id;
        form.descricao = newVal.descricao;
        form.comimposto = newVal.comimposto;
        form.semimposto = newVal.semimposto;
        form.fiob = newVal.fiob;
        form.dtcad = newVal.dtcad;
    } else {
        form.reset();
        form.dtcad = new Date().toISOString().split('T')[0];
    }
}, { immediate: true });

const submitForm = () => {
    if (form.id) {
        form.put(route('admin.concessionarias.update', form.id), {
            onSuccess: () => emit('close')
        });
    } else {
        form.post(route('admin.concessionarias.store'), {
            onSuccess: () => emit('close')
        });
    }
};
</script>

<template>
    <div class="modal d-block" tabindex="-1" style="background: rgba(0,0,0,0.6); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050; display: flex; align-items: center; justify-content: center;">
        <div class="modal-dialog modal-dialog-centered w-100" style="max-width: 550px; margin: 30px auto;">
            <div class="modal-content br-card p-0 shadow-lg border-0 rounded" style="overflow: hidden;">
                
                <!-- Cabeçalho idêntico ao seu padrão GovBR -->
                <div class="d-flex justify-content-between align-items-center bg-blue-warm-50 text-white px-4 py-3">
                    <h3 class="h6 m-0 font-weight-bold text-uppercase text-white">
                        {{ form.id ? 'Editar Concessionária' : 'Nova Concessionária' }}
                    </h3>
                    <button type="button" class="close text-white border-0 bg-transparent" style="font-size: 1.5rem; line-height: 1;" @click="emit('close')">&times;</button>
                </div>
                
                <form @submit.prevent="submitForm" class="px-4 py-4 bg-white">
                    <div class="br-input mb-3">
                        <label class="font-weight-bold text-sm text-secondary mb-1">Nome da Concessionária</label>
                        <input v-model="form.descricao" type="text" class="form-control rounded" placeholder="Ex: CELESC" required />
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="br-input mb-3">
                                <label class="font-weight-bold text-sm text-secondary mb-1">Com Imposto</label>
                                <input v-model="form.comimposto" type="number" step="0.00001" class="form-control rounded" placeholder="0.00000" required />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="br-input mb-3">
                                <label class="font-weight-bold text-sm text-secondary mb-1">Sem Imposto</label>
                                <input v-model="form.semimposto" type="number" step="0.00001" class="form-control rounded" placeholder="0.00000" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="br-input mb-3">
                                <label class="font-weight-bold text-sm text-secondary mb-1">FIOB</label>
                                <input v-model="form.fiob" type="number" step="0.00001" class="form-control rounded" placeholder="0.00000" required />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="br-input mb-3">
                                <label class="font-weight-bold text-sm text-secondary mb-1">Data de Cadastro</label>
                                <input v-model="form.dtcad" type="date" class="form-control rounded" required />
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center mt-4" style="gap: 15px;">
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4 font-weight-bold" @click="emit('close')">Cancelar</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold" :disabled="form.processing">
                            Salvar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>
