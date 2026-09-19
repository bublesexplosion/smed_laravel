<script setup>
import HeaderGov from '@/Components/HeaderGov.vue';
import MenuGov from '@/Components/MenuGov.vue';
</script>

<template>
    <div class="template-base">
        <!-- O MenuGov e HeaderGov cuidam de toda a navegação -->
        <HeaderGov />
        <MenuGov />

        <main class="d-flex flex-fill">
            <div class="container-lg">
                <div class="row">
                    <div class="col">
                        <!-- Título da Página (Opcional) -->
                        <header v-if="$slots.header" class="py-4">
                            <slot name="header" />
                        </header>

                        <!-- Conteúdo da Página (Vem do Dashboard.vue) -->
                        <div class="bg-pure-0 shadow-sm-light p-4 rounded">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Rodapé do Governo (Opcional) -->
        <footer class="br-footer mt-5">
            <!-- Conteúdo do footer aqui -->
        </footer>
    </div>
</template>

<style>
/* Ajuste para garantir que o conteúdo não fique "atrás" do header fixo se usar data-sticky */
.template-base {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
main {
    flex: 1;
}
</style>
