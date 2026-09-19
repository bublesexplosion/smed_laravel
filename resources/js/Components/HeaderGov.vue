<template>
  <header class="br-header" id="header" data-sticky>
    <div class="container-lg">
      <div class="header-top">
        <div class="header-logo">
          <!-- Corrigido para a URL da imagem da logo -->
          <img src="https://www.serpro.gov.br" alt="logo gov.br"/>
          <span class="br-divider vertical"></span>
          <div class="header-sign">Assinatura do Órgão</div>
        </div>
        <div class="header-actions">
          <div class="header-login">
            <!-- Se o usuário estiver logado, mostra o nome dele -->
            <div v-if="user" class="header-user">
              <button class="br-button small" type="button">
                <i class="fas fa-user" aria-hidden="true"></i>
                <span class="d-sm-inline ml-1">{{ user.name }}</span>
              </button>
            </div>
            <!-- Caso contrário, mostra o botão entrar -->
            <button v-else class="br-button sign-in small" type="button">
              <i class="fas fa-user" aria-hidden="true"></i>
              <span class="d-sm-inline">Entrar</span>
            </button>
          </div>
        </div>
      </div>
      <div class="header-bottom">
        <div class="header-menu">
          <div class="header-menu-trigger">
            <button class="br-button circle small" type="button" aria-label="Menu" data-toggle="menu" data-target="#main-navigation">
              <i class="fas fa-bars" aria-hidden="true"></i>
            </button>
          </div>
          <div class="header-info">
            <div class="header-title">SMED Laravel</div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
    import { onMounted } from 'vue';
    import { usePage } from '@inertiajs/vue3';

    const user = usePage().props.auth.user;

    onMounted(() => {
      if (window.core && window.core.BRHeader) {
        for (const brHeader of window.document.querySelectorAll('.br-header')) {
          new window.core.BRHeader('br-header', brHeader);
        }
      }
    });
</script>
