<script setup>
    import { ref, onMounted, watch } from 'vue';

    // Define o v-model duplo para capturar os IDs de Estado e Cidade no formulário pai
    const estadoId = defineModel('estadoId');
    const cidadeId = defineModel('cidadeId');

    const estados = ref([]);
    const cidadesFiltradas = ref([]);

    // 1. Carrega todos os estados do Brasil assim que o componente entra na tela
    onMounted(async () => {
        try {
            const response = await fetch(route('admin.api.estados'));
            estados.value = await response.json();
            
            // Se já vier um estado selecionado (modo Edição), carrega as cidades dele imediatamente
            if (estadoId.value) {
                carregarCidades(estadoId.value);
            }
        } catch (error) {
            console.error('Erro ao carregar estados da API:', error);
        }
    });

    // 2. Função isolada para buscar as cidades no backend
    const carregarCidades = async (idDoEstado) => {
        try {
            const response = await fetch(route('admin.api.cidades', idDoEstado));
            cidadesFiltradas.value = await response.json();
        } catch (error) {
            console.error('Erro ao carregar cidades da API:', error);
        }
    };

    // 3. Monitora se o usuário trocar o estado para atualizar o combo de cidades
    watch(() => estadoId.value, (novoEstadoId) => {
        if (!novoEstadoId) {
            cidadesFiltradas.value = [];
            cidadeId.value = ''; // Limpa a cidade no formulário pai
            return;
        }
        
        cidadesFiltradas.value = [];
        cidadeId.value = ''; // Reseta a cidade antiga para o usuário escolher a nova
        carregarCidades(novoEstadoId);
    });
</script>

<template>
    <!-- O componente entrega os dois campos perfeitamente envelopados em Bootstrap/AdminLTE -->
    <div class="row w-100 m-0 p-0">
        <div class="col-md-6 form-group pl-0">
            <label class="font-weight-normal text-sm">UF / Estado</label>
            <select v-model="estadoId" class="form-control" required>
                <option value="">Selecione o Estado...</option>
                <option v-for="est in estados" :key="est.id" :value="est.id">
                    {{ est.uf }} - {{ est.nome }}
                </option>
            </select>
        </div>
        
        <div class="col-md-6 form-group pr-0">
            <label class="font-weight-normal text-sm">Cidade</label>
            <select v-model="cidadeId" class="form-control" :disabled="!estadoId" required>
                <option value="">{{ estadoId ? 'Selecione a Cidade...' : 'Escolha um Estado primeiro' }}</option>
                <option v-for="cid in cidadesFiltradas" :key="cid.id" :value="cid.id">
                    {{ cid.nome }}
                </option>
            </select>
        </div>
    </div>
</template>
