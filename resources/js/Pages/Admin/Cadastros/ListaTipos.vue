<template>
  <div>
    <!-- Cabeçalho da Página -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-primary font-weight-bold">Tabelas de Cadastros Base</h2>
      <button class="btn btn-primary rounded-pill px-4" @click="modalAberto = true">
        <i class="fas fa-plus mr-2"></i> Nova Tabela
      </button>
    </div>

    <!-- Grade de Cards das Tabelas Cadastradas -->
    <div class="row">
      <div v-for="tipo in tipos" :key="tipo.id" class="col-md-4 col-sm-6 mb-4">
        <div class="card h-100 shadow-sm border-0 bg-white">
          <div class="card-body d-flex flex-column justify-content-between p-4">
            <div>
              <div class="d-flex align-items-center mb-3">
                <div class="bg-light text-primary rounded-circle p-3 mr-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                  <i class="fas fa-table fa-lg"></i>
                </div>
                <h5 class="card-title font-weight-bold mb-0 text-dark">{{ tipo.label }}</h5>
              </div>
              <p class="card-text text-muted small">
                Gerencie todos os registros e opções vinculadas a tabela de {{ tipo.label.toLowerCase() }}.
              </p>
            </div>
            
            <div class="mt-4">
              <!-- Link que leva para o CRUD interno usando o ID do tipo -->
              <Link :href="route('admin.tipos.gerenciar', { tipo: tipo.id })" class="btn btn-outline-primary btn-block rounded-pill font-weight-bold">
                <i class="fas fa-cog mr-2"></i> Gerenciar Dados
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Estado Vazio -->
      <div v-if="tipos.length === 0" class="col-12 text-center py-5">
        <p class="text-muted">Nenhuma tabela cadastrada no sistema ainda.</p>
      </div>
    </div>

    <!-- Modal para Criar Novo Tipo (Ex: Criar a tabela 'Conectores') -->
    <div v-if="modalAberto" class="modal-backdrop fade show"></div>
    <div v-if="modalAberto" class="modal fade show d-block" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 8px;">
          <div class="modal-header bg-primary text-white py-3">
            <h5 class="modal-title font-weight-bold">CRIAR NOVA TABELA AUXILIAR</h5>
            <button type="button" class="close text-white" @click="fecharModal">
              <span>&times;</span>
            </button>
          </div>

          <form @submit.prevent="submeterFormulario">
            <div class="modal-body py-4">
              <div class="form-group">
                <label class="font-weight-bold text-secondary">Nome da Tabela (Plural)</label>
                <input 
                  type="text" 
                  v-model="form.label" 
                  class="form-control form-control-lg" 
                  :class="{'is-invalid': form.errors.label}"
                  placeholder="Ex: Disjuntores, Buchas, Canaletas..."
                />
                <div v-if="form.errors.label" class="invalid-feedback">
                  {{ form.errors.label }}
                </div>
              </div>
            </div>

            <div class="modal-footer justify-content-center border-0 pb-4">
              <button type="button" class="btn btn-outline-secondary rounded-pill px-4 mr-2" @click="fecharModal">
                Cancelar
              </button>
              <button type="submit" class="btn btn-primary rounded-pill px-4" :disabled="form.processing">
                {{ form.processing ? 'Criando...' : 'Criar Tabela' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';

defineProps({
  tipos: Array
});

const modalAberto = ref(false);

const form = useForm({
  label: ''
});

const fecharModal = () => {
  modalAberto.value = false;
  form.reset();
  form.clearErrors();
};

const submeterFormulario = () => {
  form.post(route('admin.tipos.store'), {
    onSuccess: () => fecharModal(),
  });
};
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1040;
}
.modal {
  z-index: 1050;
}
</style>
