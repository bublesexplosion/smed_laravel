<script setup>
    import { useForm } from '@inertiajs/vue3';
    import { onMounted } from 'vue';

    const props = defineProps({
        show: Boolean,
        user: Object,
        groups: Array
    });

    const emit = defineEmits(['close']);

    const form = useForm({
        id: null,
        name: '',
        email: '',
        password: '',
        group_ids: [] // Array para múltipla seleção
    });

    onMounted(() => {
        if (props.user) {
            form.id = props.user.id;
            form.name = props.user.name;
            form.email = props.user.email;
            form.group_ids = props.user.groups.map(g => g.id);
        }
    });

    const submit = () => {
        if (form.id) {
            form.put(route('admin.users.update', form.id), {
                onSuccess: () => emit('close'),
            });
        } else {
            form.post(route('admin.users.store'), {
                onSuccess: () => emit('close'),
            });
        }
    };
</script>

<template>
    <Teleport to="body">
        <!-- Mudamos o nome da classe para fugir do CSS do GovBR que está travando a posição -->
        <div class="meu-modal-custom">
            <div class="modal-container-branco">
                <div class="br-modal-content p-0">
                    <div class="br-modal-header bg-blue-warm-50 text-white p-3 d-flex justify-content-between align-items-center">
                        <div class="br-modal-title h5 font-weight-bold m-0">
                            {{ form.id ? 'Editar Usuário' : 'Novo Usuário' }}
                        </div>
                        <button class="br-button circle inverted small" type="button" @click="emit('close')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="br-modal-body p-3">
                        <form @submit.prevent="submit">
                            <div class="br-input mb-3">
                                <label>Nome</label>
                                <input v-model="form.name" type="text" placeholder="Nome completo" />
                                <div v-if="form.errors.name" class="text-danger small">{{ form.errors.name }}</div>
                            </div>

                            <div class="br-input mb-3">
                                <label>E-mail</label>
                                <input v-model="form.email" type="email" placeholder="email@exemplo.com" />
                                <div v-if="form.errors.email" class="text-danger small">{{ form.errors.email }}</div>
                            </div>

                            <div class="br-input mb-3">
                                <label>Senha {{ form.id ? '(deixe em branco para manter)' : '' }}</label>
                                <input v-model="form.password" type="password" />
                                <div v-if="form.errors.password" class="text-danger small">{{ form.errors.password }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="d-block mb-2 font-weight-bold">Vincular Grupos</label>
                                <div class="p-2 border rounded" style="max-height: 150px; overflow-y: auto; background: #f8f8f8;">
                                    <div v-for="group in groups" :key="group.id" class="br-checkbox mb-1">
                                        <input 
                                            :id="'group_' + group.id" 
                                            v-model="form.group_ids" 
                                            type="checkbox" 
                                            :value="group.id" 
                                        />
                                        <label :for="'group_' + group.id">{{ group.name }}</label>
                                    </div>
                                </div>
                                <div v-if="form.errors.group_ids" class="text-danger small mt-1">
                                    {{ form.errors.group_ids }}
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button class="br-button secondary mr-2" type="button" @click="emit('close')">Cancelar</button>
                                <button class="br-button primary" type="submit" :disabled="form.processing">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
    /* ESTILO TOTALMENTE NOVO E INDEPENDENTE */
    .meu-modal-custom {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(0, 0, 0, 0.6) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 99999 !important;
        margin: 0 !important;
    }

    .modal-container-branco {
        background: white !important;
        width: 100% !important;
        max-width: 550px !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
        overflow: hidden !important;
        position: relative !important;
        /* Reset de margens para garantir centralização no flex */
        margin: 0 !important;
    }
</style>
