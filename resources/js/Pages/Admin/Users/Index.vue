<script setup>
    import { ref } from 'vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import ModalUser from './ModalUser.vue';
    import { router } from '@inertiajs/vue3';
    import Breadcrumbs from '@/Components/Breadcrumbs.vue';


    const props = defineProps({
        users: Array,
        groups: Array,
        breadcrumbs: Array // Adicione esta linha
    });

    const showModal = ref(false);
    const selectedUser = ref(null);

    const openModal = (user = null) => {
        selectedUser.value = user;
        showModal.value = true;
    };

    const deleteUser = (id) => {
        if (confirm('Tem certeza que deseja excluir este usuário?')) {
            router.delete(route('users.destroy', id));
        }
    };
</script>

<template>
    <ModalUser 
            v-if="showModal" 
            :show="showModal" 
            :user="selectedUser" 
            :groups="groups"
            @close="showModal = false" 
        />
    <AdminLayout title="Usuários">
         <!--- <Breadcrumbs :crumbs="$page.props.breadcrumbs" />---->
        <div class="br-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-blue-warm-50 text-white p-3">
                <h2 class="h5 m-0">Gerenciar Usuários</h2>
                <button class="br-button secondary inverted small" @click="openModal()">
                    <i class="fas fa-plus mr-1"></i> Novo Usuário
                </button>
            </div>
            <div class="card-content p-0">
                <table class="br-table w-100">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Grupos</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <span v-for="group in user.groups" :key="group.id" class="br-tag bg-blue-10 mr-1">
                                    {{ group.name }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="br-button circle secondary small mr-1" @click="openModal(user)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="br-button circle danger small" @click="deleteUser(user.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        
    </AdminLayout>
</template>

<style>
.br-tag {
    display: inline-flex;
    margin-top: 2px;
    color: #17237c;
}
</style>
