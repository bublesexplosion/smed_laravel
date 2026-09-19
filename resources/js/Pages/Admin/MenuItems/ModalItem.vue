<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import SeletorIcone from '@/Components/SeletorIcone.vue';

const props = defineProps({ 
    item: Object,
    sections: Array 
});
const emit = defineEmits(['close']);

const form = useForm({
    id: null,
    label: '',
    link: '',
    icon: 'fas fa-circle',
    order: 0,
    menu_section_id: ''
});

onMounted(() => {
    if (props.item) {
        form.id = props.item.id;
        form.label = props.item.label;
        form.link = props.item.link;
        form.icon = props.item.icon;
        form.order = props.item.order;
        form.menu_section_id = props.item.menu_section_id;
    }
});

const submit = () => {
    if (form.id) {
        form.put(route('admin.menu-items.update', form.id), { onSuccess: () => emit('close') });
    } else {
        form.post(route('admin.menu-items.store'), { onSuccess: () => emit('close') });
    }
};
</script>

<template>
    <Teleport to="body">
        <div class="meu-modal-custom">
            <div class="modal-container-branco">
                <div class="br-modal-header bg-blue-warm-50 text-white p-3 d-flex justify-content-between align-items-center">
                    <h1 class="h5 m-0">{{ form.id ? 'Editar Link' : 'Novo Link' }}</h1>
                    <button class="br-button circle inverted small" @click="emit('close')"><i class="fas fa-times"></i></button>
                </div>
                <div class="br-modal-body p-3">
                    <form @submit.prevent="submit">
                        <div class="row">
                            <div class="col-sm-8 br-input mb-3">
                                <label>Rótulo do Link</label>
                                <input v-model="form.label" type="text" placeholder="Ex: Usuários" />
                            </div>
                            <div class="col-sm-4 br-input mb-3">
                                <label>Ordem</label>
                                <input v-model="form.order" type="number" />
                            </div>
                        </div>

                        <div class="br-input mb-3">
                            <label>Nome da Rota (ex: admin.users.index)</label>
                            <input v-model="form.link" type="text" />
                        </div>

                        <div class="br-select mb-3">
                            <label>Seção do Menu</label>
                            <select v-model="form.menu_section_id" class="p-2 w-100">
                                <option value="" disabled>Selecione uma seção...</option>
                                <option v-for="sec in sections" :key="sec.id" :value="sec.id">
                                    {{ sec.name }}
                                </option>
                            </select>
                        </div>
                        <!-- Ícone (Nosso Componente Customizado) -->
                            <div class="br-modal-body p-3">
                                <SeletorIcone v-model="form.icon" />
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
    background: white; width: 100%; max-width: 550px; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}
</style>
