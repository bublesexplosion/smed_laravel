<script setup>
    import { ref, onMounted } from 'vue';
    import { Link } from '@inertiajs/vue3';
    import HeaderDropdown from '@/Components/HeaderDropdown.vue';
    import MenuPrincipalItem from '@/Components/MenuPrincipalItem.vue';

  const appUrl = import.meta.env.APP_URL;

   const props = defineProps({
        menuData: {
            type: Array,
            default: () => []
        }
    });

    const isMenuOpen = ref(false);

    // Função para abrir o menu lateral principal
    const toggleMenu = () => {
        isMenuOpen.value = !isMenuOpen.value;
        if (isMenuOpen.value) {
            document.body.classList.add('scrolling-stop');
        } else {
            document.body.classList.remove('scrolling-stop');
            // Opcional: Fecha todos os submenus quando fechar o menu lateral
            document.querySelectorAll('.menu-folder').forEach(el => el.classList.remove('active'));
        }
    };

    onMounted(() => {
        if (localStorage.getItem('alto-contraste') === 'true') {
            document.body.classList.add('br-high-contrast');
        }
    });

    const eLinkExterno = (href) => {
        if (!href) return false;
        return href.startsWith('http://') || href.startsWith('https://');
    };

</script>


  <template>
    <header class="br-header">
      <div class="container-lg">
        <div class="header-top">
            <!-- Logo com estrutura corrigida -->
            <div class="header-logo">
                <Link href="/" >
                  <img src="/images/logo.png" alt="SMED Laravel" style="max-height: 48px;"/>
                  <span class="br-divider vertical"></span>
                  <div class="header-sign">Rio Grande</div>
              </Link>
            </div>

            <div class="header-actions">
                <!-- Acesso Rápido - Ajustado para não quebrar -->
                <div class="header-links dropdown">
                  <button class="br-button circle small" type="button" data-toggle="dropdown" aria-label="Abrir Acesso Rápido">
                    <i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                  </button>
                  <div class="br-list">
                    <div class="header"><div class="title">Acesso Rápido</div></div>
                    <a
                        v-for="item in $page.props.menuData"
                        :key="item.id"
                        class="br-item"
                        :href="item.href || '#'"
                        :target="eLinkExterno(item.href) ? '_blank' : undefined"
                        :rel="eLinkExterno(item.href) ? 'noopener' : undefined"
                    >
                        {{ item.label }}
                    </a>
                  </div>
                </div>

                <span class="br-divider vertical mx-half mx-sm-1"></span>

                <!-- Seu componente Dropdown -->
                <HeaderDropdown />

                <div class="header-search-trigger">
                  <button class="br-button circle" type="button" aria-label="Abrir Busca" data-toggle="search" data-target=".header-search"><i class="fas fa-search" aria-hidden="true"></i></button>
                </div>
                <!----entrar--------------->
                <div class="header-login">
                  <div class="header-sign-in">
                    <Link :href="route('login')" class="br-sign-in small">
                      <i class="fas fa-user" aria-hidden="true"></i>
                      <span class="d-sm-inline">Entrar</span>
                    </Link>
                  </div>
                </div>

            </div>
        </div>

        <!-- Parte de baixo onde está o MENU CIRCULADO -->
        <div class="header-bottom">
            <div class="header-menu">
              <div class="header-menu-trigger">
                <!-- ADICIONADO O @CLICK AQUI -->
                <button
                  class="br-button small circle"
                  type="button"
                  aria-label="Menu"
                  @click="toggleMenu"
                >
                  <i class="fas fa-bars" aria-hidden="true"></i>
                </button>

              </div>
              <div class="header-info">
                <div class="header-title">Portal Institucional</div>
              </div>
            </div>
            <div class="header-search">
              <div class="br-input has-icon">
                <label for="header-searchbox">Texto da pesquisa</label>
                <input id="header-searchbox" type="text" placeholder="O que você procura?" />
                <button class="br-button circle small" type="button" aria-label="Pesquisar">
                  <i class="fas fa-search" aria-hidden="true"></i>
                </button>
              </div>
              <button class="br-button circle search-close ml-1" type="button" aria-label="Fechar Busca" data-dismiss="search">
                <i class="fas fa-times" aria-hidden="true"></i>
              </button>
            </div>
        </div>

      </div>
    </header>

       <!-- MENU LATERAL REFATORADO -->
      <div class="br-menu" :class="{ active: isMenuOpen }" id="main-navigation">
        <div class="menu-container">
          <div class="menu-panel">
            <div class="menu-header">
              <div class="menu-title">
                <Link href="/">
                <img src="/images/logo.png" alt="SMED Laravel" style="width: 48px"/>
                </Link>
                <span>Menu Principal</span>
              </div>
              <div class="menu-close">
                <button class="br-button circle small" type="button" @click="toggleMenu" aria-label="Fechar">
                  <i class="fas fa-times" aria-hidden="true"></i>
                </button>
              </div>
            </div>
           <!------menu dinamico principal------------>
            <nav class="menu-body">
                <MenuPrincipalItem v-for="menu in $page.props.menuData" :key="menu.id" :item="menu" />
            </nav>



          </div>
          <div class="menu-scrim" @click="toggleMenu"></div>
        </div>
      </div>

</template>

<style scoped>
    /* Garante que os links do cabeçalho fiquem sem sublinhado, independente da ordem
       de carregamento entre o reset do Tailwind e o do AdminLTE/Bootstrap */
    .header-links .br-item,
    .header-top a,
    .menu-item {
      text-decoration: none;
    }

    /* 1. ESTRUTURA EXTERNA (Container e Scrim) */
    .br-menu {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: 9999;
    }

    .br-menu.active {
      display: block;
    }

    .br-menu .menu-panel {
      width: 300px;
      height: 100%;
      background-color: #ffffff;
      position: absolute;
      left: 0;
      top: 0;
      z-index: 2;
      box-shadow: 3px 0 6px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
    }

    .menu-scrim {
      background: rgba(0, 0, 0, 0.45);
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
      cursor: pointer;
    }

    /* 2. CABEÇALHO DO MENU */
    .menu-header {
      padding: 20px;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #f8f9fa;
    }
</style>



