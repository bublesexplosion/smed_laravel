<script setup>
        import { ref } from 'vue';
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
</script>

<template>
    <div class="header-functions dropdown">
        <button class="br-button circle small" type="button" data-toggle="dropdown" aria-label="Abrir Funcionalidades do Sistema">
            <i class="fas fa-th" aria-hidden="true"></i>
        </button>
        <div class="br-list">
            <div class="header"><div class="title">Funcionalidades do Sistema</div></div>
            <div class="br-item">
                <button class="br-button circle small" type="button" @click="toggleContrast" aria-label="Alto Contraste">
                    <i class="fas fa-adjust" aria-hidden="true"></i>
                    <span class="text">Alto Contraste</span>
                </button>
            </div>
            <div class="br-item">
                <button class="br-button circle small" type="button" @click="changeFontSize(10)" aria-label="Aumentar Fonte">
                    <i class="fas fa-search-plus" aria-hidden="true"></i>
                    <span class="text">Aumentar Fonte</span>
                </button>
            </div>
            <div class="br-item">
                <button class="br-button circle small" type="button" @click="changeFontSize(-10)" aria-label="Diminuir Fonte">
                    <i class="fas fa-search-minus" aria-hidden="true"></i>
                    <span class="text">Diminuir Fonte</span>
                </button>
            </div>
        </div>
    </div>
</template>
