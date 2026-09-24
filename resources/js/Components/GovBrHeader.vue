<template>
  <!-- Header Principal com layout adaptado para AdminLTE e Gov.br DS -->
  <header class="br-header main-header bg-white border-bottom-1">
      <div class="container-fluid">
          <div class="header-top">
                <div class="header-logo">
                    <img src="/images/logo.png" alt="Logo">
                    <span class="br-divider vertical"></span>
                    <div class="header-sign">{{ orgao }}</div>
                </div>
                <div class="header-actions">
                    <div class="header-login">
                        <div v-if="$page.props.auth.user" class="header-user">
                              <span class="mr-2">Olá, <strong>{{ $page.props.auth.user.name }}</strong></span>
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
          
          <!-- BARRA DE NAVEGAÇÃO HORIZONTAL (Sequência solicitada) -->
          <div class="header-bottom">
              <nav class="br-menu">
                  <ul class="menu-list">
                      <!-- Início -->
                      <li>
                          <a class="menu-item" href="/">Início</a>
                      </li>
                      
                      <!-- Recursos Educacionais -->
                      <li>
                          <a class="menu-item" href="#">Recursos Educacionais</a>
                      </li>

                      <!-- Gestão Pedagógica (Dropdown) -->
                      <li class="menu-folder">
                          <a class="menu-item" href="javascript:void(0)">
                              Gestão Pedagógica <i class="fas fa-angle-down ml-1"></i>
                          </a>
                          <ul class="menu-folder-list">
                              <li class="menu-folder">
                                  <a class="menu-item" href="javascript:void(0)">
                                      Atividades <i class="fas fa-angle-down ml-1"></i>
                                  </a>
                                  <ul class="menu-folder-list">
                                      <li><a class="menu-item" href="#">Notícias 2023/2024</a></li>
                                      <li><a class="menu-item" href="#">Atividades 2021</a></li>
                                  </ul>
                              </li>
                              <li><a class="menu-item" href="#">Núcleos Pedagógicos</a></li>
                              <li><a class="menu-item" href="#">Programas e Projetos</a></li>
                          </ul>
                      </li>

                      <!-- Gestão da Educação (Dropdown) -->
                      <li class="menu-folder">
                          <a class="menu-item" href="javascript:void(0)">
                              Gestão da Educação <i class="fas fa-angle-down ml-1"></i>
                          </a>
                          <ul class="menu-folder-list">
                              <li><a class="menu-item" href="#">Núcleo de Alimentação Escolar</a></li>
                              <li><a class="menu-item" href="#">Arquivo Geral</a></li>
                          </ul>
                      </li>

                      <!-- Conselhos (Dropdown) -->
                      <li class="menu-folder">
                          <a class="menu-item" href="javascript:void(0)">
                              Conselhos <i class="fas fa-angle-down ml-1"></i>
                          </a>
                          <ul class="menu-folder-list">
                              <li><a class="menu-item" href="#">Fórum COMED</a></li>
                              <li><a class="menu-item" href="#">Conselho Municipal de Educação</a></li>
                              <li><a class="menu-item" href="#">Conselho do FUNDEB</a></li>
                              <li><a class="menu-item" href="#">Conselho de Alimentação Escolar</a></li>
                          </ul>
                      </li>

                      <!-- SMEd (Dropdown) -->
                      <li class="menu-folder">
                          <a class="menu-item" href="javascript:void(0)">
                              SMEd <i class="fas fa-angle-down ml-1"></i>
                          </a>
                          <ul class="menu-folder-list">
                              <li><a class="menu-item" href="#">Contatos das Escolas</a></li>
                              <li><a class="menu-item" href="#">Histórico</a></li>
                              <li><a class="menu-item" href="#">Legislação</a></li>
                              <li><a class="menu-item" href="#">Quem é quem na SMEd</a></li>
                          </ul>
                      </li>

                      <!-- Gabinete -->
                      <li>
                          <a class="menu-item" href="#">Gabinete</a>
                      </li>
                  </ul>
              </nav>
          </div>
      </div>
  </header>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { onMounted, nextTick } from 'vue';

    defineProps({
    orgao: { type: String, default: 'SMED Laravel' },
    titulo: { type: String, default: 'SMED Laravel' }
});

    onMounted(async () => {
        await nextTick();
        // Inicializa o Menu do GOVBR para que os dropdowns da barra horizontal funcionem
        if (window.core && window.core.BRMenu) {
            const menus = window.document.querySelectorAll('.br-menu');
            menus.forEach(m => new window.core.BRMenu('br-menu', m));
        }
    });
</script>

<style scoped>
    .br-header.main-header {
        margin-left: 250px;
        width: auto;
        z-index: 1034;
    }

    @media (max-width: 991.98px) {
        .br-header.main-header {
            margin-left: 0;
        }
    }
    .header-logo img {
      max-height: 48px;
      width: auto;
      object-fit: contain;
      padding-top: 10px;
    }

    .br-header {
      padding-left: 1rem;
    }

    /* Estilos para forçar a navegação horizontal do Gov.br DS */
    .header-bottom .br-menu {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .header-bottom .menu-list {
        display: flex;
        flex-direction: row;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .header-bottom .menu-item {
        padding: 10px 15px;
        color: #1351b4;
        text-decoration: none;
        font-weight: 600;
        display: block;
    }
    .header-bottom .menu-item:hover {
        background-color: #f2f5fd;
    }
</style>
