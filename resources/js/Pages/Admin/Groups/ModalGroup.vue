<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({ 
    group: Object,
    menuItems: Array 
});
const emit = defineEmits(['close']);

const form = useForm({
    id: null,
    name: '',
    description: '',
    menu_item_ids: []
});

onMounted(() => {
    if (props.group) {
        form.id = props.group.id;
        form.name = props.group.name;
        form.description = props.group.description;
        form.menu_item_ids = props.group.menu_items.map(i => i.id);
    }
});

const submit = () => {
    if (form.id) {
        form.put(route('admin.groups.update', form.id), { onSuccess: () => emit('close') });
    } else {
        form.post(route('admin.groups.store'), { onSuccess: () => emit('close') });
    }
};
</script>

<template>
    <Teleport to="body">
        <div class="meu-modal-custom">
            <div class="modal-container-branco">
                <div class="br-modal-header bg-blue-warm-50 text-white p-3 d-flex justify-content-between align-items-center">
                    <h1 class="h5 m-0">{{ form.id ? 'Editar Grupo' : 'Novo Grupo' }}</h1>
                    <button class="br-button circle inverted small" @click="emit('close')"><i class="fas fa-times"></i></button>
                </div>
                <div class="br-modal-body p-3">
                    <form @submit.prevent="submit">
                        <div class="br-input mb-4">
                            <label>Nome do Grupo</label>
                            <input v-model="form.name" type="text" placeholder="Ex: Administrador, Operador..." />
                        </div>
                        <div class="br-input mb-4">
                            <label>Descrição</label>
                            <input v-model="form.description" type="text" placeholder="Ex: o que faz esse grupo..." />
                        </div>
                        <label class="font-weight-bold mb-2 d-block">Permissões de Menu</label>
                        <div class="p-3 border rounded bg-light" style="max-height: 200px; overflow-y: auto;">
                            <div v-for="item in menuItems" :key="item.id" class="br-checkbox mb-2">
                                <input :id="'item_' + item.id" v-model="form.menu_item_ids" type="checkbox" :value="item.id" />
                                <label :for="'item_' + item.id">{{ item.label }}</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button class="br-button secondary mr-2" type="button" @click="emit('close')">Cancelar</button>
                            <button class="br-button primary" type="submit">Salvar Grupo</button>
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
    background: white; width: 100%; max-width: 500px; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}
</style>
