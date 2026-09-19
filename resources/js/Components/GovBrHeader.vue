<template>
  <!-- Adicionei 'main-header' para alinhar com AdminLTE e 'bg-white' para visibilidade -->
  <header class="br-header main-header bg-white border-bottom-1">
      <div class="container-fluid">
          <div class="header-top">
                <div class="header-logo">
                    <!-- Logo oficial temporária para teste -->
                    <img src="/images/logo.png" alt="Logo">
                    <span class="br-divider vertical"></span>
                    <div class="header-sign">{{ orgao }}</div>
                </div>
                <div class="header-actions">
                  <!-- No GovBrHeader.vue -->
                    <div class="header-login">
                        <div v-if="$page.props.auth.user" class="header-user">
                              <span class="mr-2">Olá, <strong>{{ $page.props.auth.user.name }}</strong></span>
                              <!-- Link de Logout -->
                              <Link :href="route('logout')" method="post" as="button" class="br-button secondary small">
                                Sair
                              </Link>
                        </div>
                      <div v-else>
                          <Link :href="route('login')" class="br-button sign-in small">Entrar</Link>
                      </div>
                    </div>
                </div>
          </div>
          <div class="header-bottom">
              <div class="header-menu">
                  <div class="header-title">{{ titulo }}</div>
              </div>
          </div>
      </div>
  </header>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    defineProps({
    orgao: { type: String, default: 'SMED Laravel' },
    titulo: { type: String, default: 'SMED Laravel' }
});
</script>

<style scoped>
    /* Garante que o header do GOVBR não sobreponha a sidebar */
    .br-header.main-header {
        margin-left: 250px;
        width: auto;
        z-index: 1034; /* Ajuste para ficar abaixo de modais mas acima do conteúdo */
    }

    @media (max-width: 991.98px) {
        .br-header.main-header {
            margin-left: 0;
        }
    }
    .header-logo img {
      max-height: 48px; /* Altura padrão para headers do governo */
      width: auto;
      object-fit: contain;
      padding-top: 10px;
    }

    /* Garante que o header respeite o recuo da sidebar do AdminLTE */
    .br-header {
      padding-left: 1rem;
    }
</style>
