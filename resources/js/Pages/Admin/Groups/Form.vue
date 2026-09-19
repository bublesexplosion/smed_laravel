<template>
  <AdminLayout>
    <div class="br-card shadow-sm mt-3">
      <div class="card-header p-3 border-bottom">
        <div class="br-h5 m-0 text-primary">{{ group.id ? 'Editar' : 'Novo' }} Grupo</div>
      </div>
      
      <form @submit.prevent="submit">
        <div class="card-body p-4">
          <div class="form-group mb-4">
            <label class="font-weight-bold">Nome do Grupo</label>
            <input v-model="form.name" type="text" class="form-control" placeholder="Ex: Financeiro" required>
            <div v-if="form.errors.name" class="text-danger small">{{ form.errors.name }}</div>
          </div>

          <div class="form-group mb-4">
            <label class="font-weight-bold">Descrição</label>
            <textarea v-model="form.description" class="form-control" rows="2"></textarea>
          </div>

          <div class="form-group">
            <label class="font-weight-bold d-block mb-3">Permissões de Menu</label>
            <div class="row">
              <div v-for="item in menuItems" :key="item.id" class="col-md-4 mb-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" :id="'menu-'+item.id" :value="item.id" 
                         v-model="form.menu_item_ids" class="custom-control-input">
                  <label class="custom-control-label" :for="'menu-'+item.id">{{ item.label }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer bg-light p-3 text-right">
          <Link :href="route('admin.groups.index')" class="br-button secondary mr-2">Cancelar</Link>
          <button type="submit" class="br-button primary" :disabled="form.processing">
            <i class="fas fa-save mr-1"></i> Salvar Grupo
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  group: { type: Object, default: () => ({ id: null, name: '', description: '', menu_items: [] }) },
  menuItems: Array
});

const form = useForm({
  name: props.group.name,
  description: props.group.description,
  // Extrai apenas os IDs dos itens de menu que o grupo já possui
  menu_item_ids: props.group.menu_items.map(item => item.id)
});

const submit = () => {
  console.log("Enviando para:", props.group.id ? 'UPDATE' : 'STORE');
  if (props.group.id) {
    form.put(route('admin.groups.update', props.group.id));
  } else {
    form.post(route('admin.groups.store'));
  }
};
</script>
