<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import SeletorIcone from '@/Components/SeletorIcone.vue';

const props = defineProps({ section: Object });
const emit = defineEmits(['close']);

const form = useForm({
    id: null,
    name: '',
    order: 0,
    icon :'fas fa-link',
});

onMounted(() => {
    if (props.section) {
        form.id = props.section.id;
        form.name = props.section.name;
        form.order = props.section.order;
        form.icon = props.section.icon;
        
    }
});

const submit = () => {
    if (form.id) {
        form.put(route('admin.menu-sections.update', form.id), { onSuccess: () => emit('close') });
    } else {
        form.post(route('admin.menu-sections.store'), { onSuccess: () => emit('close') });
    }
};
</script>

<template>
    <Teleport to="body">
        <div class="meu-modal-custom">
            <div class="modal-container-branco">
                <div class="br-modal-header bg-blue-warm-50 text-white p-3 d-flex justify-content-between align-items-center">
                    <h1 class="h5 m-0">{{ form.id ? 'Editar Seção' : 'Nova Seção' }}</h1>
                    <button class="br-button circle inverted small" @click="emit('close')"><i class="fas fa-times"></i></button>
                </div>
                <div class="br-modal-body p-3">
                    <form @submit.prevent="submit">
                        <div class="br-input mb-3">
                            <label>Nome da Seção</label>
                            <input v-model="form.name" type="text" placeholder="Ex: Gestão, Relatórios..." />
                        </div>
                         <!-- Ícone (Nosso Componente Customizado) -->
                            <div class="br-modal-body p-3">
                                <SeletorIcone v-model="form.icon" />
                            </div>
                        <div class="br-input mb-3">
                            <label>Ordem de exibição</label>
                            <input v-model="form.order" type="number" />
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button class="br-button secondary mr-2" type="button" @click="emit('close')">Cancelar</button>
                            <button class="br-button primary" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
.meu-modal-custom {
    position: fixed !important; top: 0; left: 0; width: 100vw; height: 100vh;
    background: rgba(0, 0, 0, 0.6); display: flex; align-items: center; justify-content: center; z-index: 9999;
}
.modal-container-branco {
    background: white; width: 100%; max-width: 450px; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}
</style>
