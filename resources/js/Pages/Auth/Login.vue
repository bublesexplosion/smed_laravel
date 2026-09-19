<template>
    <div class="template-base">
        <GovBrHeader />

        <main class="d-flex flex-fill align-items-center justify-content-center" id="main">
            <div class="br-card w-100" style="max-width: 450px;">
                <div class="card-header py-3 text-center border-bottom-1">
                    <div class="br-h4">Identifique-se</div>
                </div>
                
                <div class="card-content p-4">
                    <form @submit.prevent="submit">
                        <!-- Campo E-mail -->
                        <div class="br-input mb-3">
                            <label for="email">E-mail</label>
                            <input 
                                id="email" 
                                type="email" 
                                v-model="form.email" 
                                placeholder="Digite seu e-mail"
                                required 
                                autofocus 
                            />
                            <div v-if="form.errors.email" class="text-danger mt-1">{{ form.errors.email }}</div>
                        </div>

                        <!-- Campo Senha -->
                        <div class="br-input mb-4">
                            <label for="password">Senha</label>
                            <input 
                                id="password" 
                                type="password" 
                                v-model="form.password" 
                                placeholder="Digite sua senha"
                                required 
                            />
                            <div v-if="form.errors.password" class="text-danger mt-1">{{ form.errors.password }}</div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex flex-column gap-3">
                            <button 
                                class="br-button primary block w-100" 
                                type="submit" 
                                :class="{ 'opacity-50': form.processing }" 
                                :disabled="form.processing"
                            >
                                Entrar
                            </button>
                            
                            <Link 
                                v-if="canResetPassword" 
                                :href="route('password.request')" 
                                class="text-center mt-2"
                            >
                                Esqueci minha senha
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
        import GovBrHeader from '@/Components/GovBrHeader.vue';
        import { Head, Link, useForm } from '@inertiajs/vue3';

        defineProps({
            canResetPassword: { type: Boolean },
            status: { type: String },
        });

        const form = useForm({
            email: '',
            password: '',
            remember: false,
        });

        const submit = () => {
            form.post(route('login'), {
                onFinish: () => form.reset('password'),
            });
        };
</script>

<style scoped>
    .template-base {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color: #f8f8f8;
    }

    .br-card {
        background: white;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        border-radius: 4px;
    }

    /* Estilo para simular o br-input do Governo */
    .br-input input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #888;
        border-radius: 4px;
    }
    /* Remove o contorno amarelo padrão e aplica o estilo GOVBR */
    .br-input input:focus {
        outline: none !important;
        border-color: #0047b0 !important; /* Azul oficial GOVBR */
        box-shadow: 0 0 0 1px #0047b0 !important;
    }
    /* Remove a margem esquerda que o AdminLTE aplica por padrão */
    :deep(.br-header) {
        margin-left: 0 !important;
        width: 100% !important;
    }

    /* Garante que o container interno do GOVBR use o espaço corretamente */
    :deep(.container-fluid) {
        padding-left: 2rem;
        padding-right: 2rem;
    }
</style>
