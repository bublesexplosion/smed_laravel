<script setup>
    import { router } from '@inertiajs/vue3'
    import { ref } from 'vue';
    import { Link } from '@inertiajs/vue3'; 
    import AdminLayout from '@/Layouts/AdminLayout.vue'; 
    import { useSearch } from '@/Composables/useSearch';
    import FormMenuPrincipal from './Partials/FormMenuPrincipal.vue';
  
    const props = defineProps({
        menus: Array,        
        opcoesMenu: Array,    
        filters: Object 
    });

    // Função para a busca estruturada
    const { search, searchInput, limparBusca } = useSearch('admin.menuPrincipal.index', props.filters);
    
    // Estados que controlam a abertura do componente filho
    const isModalOpen = ref(false);
    const itemSelecionado = ref(null);

    // Nova função simplificada para abrir o modal de cadastro (Novo Link)
    const abrirNovoCadastro = () => {
        itemSelecionado.value = null; // Garante que o formulário abra limpo
        isModalOpen.value = true;
    };

    // Nova função simplificada para abrir o modal de edição (Ícone de Lápis)
    const abrirEdicao = (menu) => {
        itemSelecionado.value = menu; // Passa o objeto do banco para o filho ler
        isModalOpen.value = true;
    };

    // Função de exclusão de item
    function deleteMenu(id) {
        if (confirm('Tem certeza que deseja excluir este item?')) {
            router.delete(`${window.location.origin}/admin/prefeitura/menuprincipal/${id}`, {
                preserveState: false
            });
        }
    }
</script>


<template>
    <AdminLayout title="Itens de Menu">
        <div class="br-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-blue-warm-50 text-white p-3">
                <h2 class="h5 m-0">Menu Principal</h2>

                <button class="br-button secondary inverted small" @click="abrirNovoCadastro">
                    <i class="fas fa-plus mr-1"></i> Novo Link
                </button>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <!-- NOVA: Barra de Pesquisa -->
                    <div class="card-header bg-white border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="card-title text-muted h6 mb-0">Listagem</h3>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                    </div>
                                    <input 
                                        ref="searchInput"
                                        v-model="search" 
                                        type="text" 
                                        class="form-control border-left-0" 
                                        placeholder="Pesquisar banners..."
                                    >
                                    <div class="input-group-append">
                                        <!-- Só mostra o botão se houver algo escrito no search -->
                                    <button v-if="search" @click="limparBusca" class="btn btn-sm btn-link text-primary">
                                            Limpar Pesquisa
                                        </button>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 80px">Ordem</th>
                                <th>Rótulo / Ícone</th>
                                <th>Hierarquia (Pai)</th>
                                <th>Link/Rota</th>
                                <th style="width: 150px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se não houver itens -->
                            <tr v-if="menus.length === 0">
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Nenhum item de menu cadastrado. Clique em "Novo Link" para começar.
                                </td>
                            </tr>
                            
                            <!-- Lista de itens -->
                            <tr v-for="menu in menus" :key="menu.id">
                                <td>{{ menu.ordem }}</td>
                                <td>
                                    <i :class="menu.icon" class="mr-2 text-primary"></i>
                                    <strong>{{ menu.label }}</strong>
                                </td>
                                <td>
                                    <span v-if="menu.pai" class="badge badge-info h2">
                                        Subitem de: {{ menu.pai.label }}
                                    </span>
                                    <span v-else class="badge badge-secondary h2">Principal (Nível 1)</span>
                                </td>
                                <td><code>{{ menu.href || '-' }}</code></td>
                                <td>
                                    <button class="btn btn-sm btn-info mr-1" @click="abrirEdicao(menu)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Botão de excluir com confirmação -->
                                    <button class="btn btn-sm btn-danger" @click="deleteMenu(menu.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- COLE O COMPONENTE EXATAMENTE AQUI -->
        <FormMenuPrincipal 
            v-if="isModalOpen" 
            :menu="itemSelecionado" 
            :opcoesMenu="opcoesMenu" 
            @close="isModalOpen = false" 
        />


    </AdminLayout>
</template>
