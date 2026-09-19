<script setup>
    import { useForm } from '@inertiajs/vue3';
    import { watch } from 'vue';
    import SeletorIcone from '@/Components/SeletorIcone.vue';
    
    const props = defineProps({
        menu: Object,      // Para edição (null se for novo, preenchido se for editar)
        opcoesMenu: Array  // Todos os menus cadastrados para o select de "Pai"
    });

    const emit = defineEmits(['close']);

    // Iniciamos o formulário com os valores padrões
    const form = useForm({
        label: '',
        href: '',
        icon: 'fas fa-link',
        ordem: 0,
        parent_id: null,
        descricao: '',
    });

    // CRUCIAL: Este watch monitora o objeto "menu". 
    // Sempre que o pai mudar o "menu", o formulário se atualiza dinamicamente.
    watch(() => props.menu, (novoMenu) => {
        if (novoMenu) {
            // Modo Edição: Preenche com os dados do item selecionado
            form.label = novoMenu.label ?? '';
            form.href = novoMenu.href ?? '';
            form.icon = novoMenu.icon ?? 'fas fa-link';
            form.ordem = novoMenu.ordem ?? 0;
            form.parent_id = novoMenu.parent_id ?? null;
            form.descricao = novoMenu.descricao;
        } else {
            // Modo Cadastro: Reseta o formulário para os valores limpos
            form.reset();
        }
    }, { immediate: true }); // Executa também logo na primeira montagem do componente

    const submit = () => {
        if (props.menu) {
            // Rota de atualização (Edição)
            form.put(route('admin.menuPrincipal.update', props.menu.id), {
                onSuccess: () => emit('close'),
            });
        } else {
            // Rota de criação (Novo)
            form.post(route('admin.menuPrincipal.store'), {
                onSuccess: () => {
                    form.reset();
                    emit('close');
                },
            });
        }
    };
</script>

<template>
    <!-- Estrutura principal do modal (Fundo escuro) -->
    <div class="modal d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                
                <!-- O formulário envolve todo o conteúdo interno do modal -->
                <form @submit.prevent="submit">
                    
                    <!-- Cabeçalho do Modal -->
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold">
                            {{ menu ? 'EDITAR LINK' : 'NOVO LINK' }}
                        </h5>
                        <button type="button" class="close" @click="$emit('close')">&times;</button>
                    </div>
                    
                   <!-- Corpo do Formulário -->
                    <div class="modal-body">
                        <div class="row">
                            <!-- Rótulo -->
                            <div class="col-md-6 form-group">
                                <label>Rótulo do Menu</label>
                                <input v-model="form.label" type="text" class="form-control" required>
                            </div>

                            <!-- Ordem -->
                            <div class="col-md-6 form-group">
                                <label>Ordem</label>
                                <input v-model="form.ordem" type="number" class="form-control" required>
                            </div>

                            <!-- Ícone (Nosso Componente Customizado) -->
                            <div class="col-md-6">
                                <SeletorIcone v-model="form.icon" />
                            </div>

                            <!-- URL / Rota -->
                            <div class="col-md-6 form-group">
                                <label>URL ou Rota ex: http: ou noticias</label>
                                <input v-model="form.href" type="text" class="form-control">
                            </div>

                            <!-- Novo campo de Descrição por Extenso (Corrigido: sem a tag row extra) -->
                            <div class="col-md-12 form-group">
                                <label for="descricao" class="form-label text-bold">Descrição por Extenso</label>
                                <input 
                                    type="text" 
                                    id="descricao" 
                                    v-model="form.descricao" 
                                    class="form-control" 
                                    placeholder="Ex: Secretaria Municipal de Saúde (Aparece ao passar o mouse)" 
                                />
                                <div v-if="form.errors.descricao" class="text-danger small mt-1">
                                    {{ form.errors.descricao }}
                                </div>
                            </div>

                            <!-- Vinculação Hierárquica -->
                            <div class="col-md-12 form-group">
                                <label>Vincular a qual Item? (Seção)</label>
                                <select v-model="form.parent_id" class="form-control">
                                    <option :value="null">Nenhum (Item Principal - Nível 1)</option>
                                    <option v-for="opcao in opcoesMenu" :key="opcao.id" :value="opcao.id">
                                        {{ opcao.label }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Rodapé do Modal com os Botões de Ação -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="$emit('close')">Cancelar</button>
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">
                            <i class="fas fa-save mr-1"></i> Salvar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
