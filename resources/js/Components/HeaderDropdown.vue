<script setup>
        import { ref, onMounted, onUnmounted } from 'vue';
        import { router } from '@inertiajs/vue3';

        const isOpen = ref(false);
        const dropdownRef = ref(null);
        //---botoes
        const isHighContrast = ref(false);

        // Dentro de HeaderDropdown.vue
        const toggleContrast = () => {
        const active = document.body.classList.toggle('br-high-contrast');
        localStorage.setItem('alto-contraste', active); // Importante para persistência
        };

        const fontSize = ref(100); // Representa 100% (geralmente 16px)

        const changeFontSize = (delta) => {
        fontSize.value += delta;
        // Aplica o tamanho no elemento HTML raiz
        document.documentElement.style.fontSize = `${fontSize.value}%`;
        };

        const resetFontSize = () => {
        fontSize.value = 100;
        document.documentElement.style.removeProperty('font-size');
        };


        // Abre/Fecha o menu
        const toggle = () => {
            isOpen.value = !isOpen.value;
        };

        // Fecha o menu se clicar em qualquer lugar fora dele
        const closeOnClickOutside = (e) => {
            if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
                isOpen.value = false;
            }
        };

        onMounted(() => {
            window.addEventListener('click', closeOnClickOutside);
            // IMPORTANTE PARA INERTIA: Fecha o menu ao mudar de página
            router.on('navigate', () => isOpen.value = false);
        });

        onUnmounted(() => {
            window.removeEventListener('click', closeOnClickOutside);
        });
</script>

<template>
    <div ref="dropdownRef" class="header-functions dropdown">
            <!-- Botões seguindo a anatomia do Header GovBR -->
            <div class="header-functions">
                <button class="br-button circle small" type="button" @click="toggleContrast" aria-label="Alto Contraste">
                    <i class="fas fa-adjust" aria-hidden="true"></i>
                </button>
                <button class="br-button circle small" type="button" @click="changeFontSize(10)" aria-label="Aumentar Fonte">
                    <i class="fas fa-search-plus" aria-hidden="true"></i>
                </button>
                <button class="br-button circle small" type="button" @click="changeFontSize(-10)" aria-label="Diminuir Fonte">
                    <i class="fas fa-search-minus" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Adicione os outros itens conforme seu HTML original -->
    </div>
</template>
