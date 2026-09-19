<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = defineProps({ 
    show: Boolean,
    projeto: Object // Recebe o projeto a ser editado (se houver)
});

const emit = defineEmits(['close']);

const form = useForm({
    nome: '',
    responsavel: '',
});

// "Observa" quando o projeto muda para preencher o formulário
watch(() => props.projeto, (novoProjeto) => {
    if (novoProjeto) {
        form.nome = novoProjeto.nome;
        form.responsavel = novoProjeto.responsavel;
    } else {
        form.reset();
    }
});

const submit = () => {
    if (props.projeto) {
        // Lógica de Edição
        form.patch(route('projetos.update', props.projeto.id), {
            onSuccess: () => emit('close'),
        });
    } else {
        // Lógica de Criação
        form.post(route('projetos.store'), {
            onSuccess: () => { form.reset(); emit('close'); },
        });
    }
};
</script>

<template>
  <div v-if="show" class="br-modal-overlay">
    <div class="br-modal-container">
      <div class="br-modal-header bg-primary text-white p-3 d-flex justify-content-between">
        <div class="br-h4 m-0">{{ projeto ? 'Editar Projeto' : 'Novo Projeto' }}</div>
        <button class="br-button circle inverted small" @click="$emit('close')"><i class="fas fa-times"></i></button>
      </div>
      <form @submit.prevent="submit">
        <div class="br-modal-body p-4">
          <div class="br-input mb-3">
            <label>Nome do Projeto</label>
            <input v-model="form.nome" type="text" required />
          </div>
          <div class="br-input mb-3">
            <label>Responsável</label>
            <input v-model="form.responsavel" type="text" required />
          </div>
        </div>
        <div class="br-modal-footer justify-content-end p-3 d-flex gap-2">
          <button class="br-button secondary small" type="button" @click="$emit('close')">Cancelar</button>
          <button class="br-button primary small" type="submit">{{ projeto ? 'Atualizar' : 'Salvar' }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
    .br-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.6); /* Fundo escurecido */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999; /* Garante que fique acima de tudo */
    }

    .br-modal-container {
    background: white;
    width: 100%;
    max-width: 500px;
    border-radius: 4px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
    }
</style>

