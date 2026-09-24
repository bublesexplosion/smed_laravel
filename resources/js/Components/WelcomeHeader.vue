<script setup>
    import { ref, onMounted } from 'vue';
    import { Link } from '@inertiajs/vue3';
    import HeaderDropdown from '@/Components/HeaderDropdown.vue';

  const appUrl = import.meta.env.APP_URL;

   const props = defineProps({
        menuData: {
            type: Array,
            default: () => []
        }
    });

    const isMenuOpen = ref(false);

    // Função para abrir/fechar submenus de forma independente (usando classes)
    const toggleSubmenu = (event) => {
        const folder = event.currentTarget.parentElement;
        folder.classList.toggle('active');
    };

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
    //---função que arruma o link-------
    const formatarLinkLocal = (href) => {
        if (!href) return '#';

        // Se for link externo completo, não mexe
        if (href.startsWith('http://') || href.startsWith('https://')) {
          return href;
        }

        // 1. Limpa o link de barras iniciais e de qualquer prefixo duplicado
        let pathLimpo = href.replace(/^\/+/, '').replace('smed_laravel/public/', '');

        // 2. Detecta dinamicamente se o navegador está rodando na sua subpasta local
        const éAmbienteLocalSubpasta = window.location.pathname.startsWith('');

        // 3. Retorna o caminho correto baseado no ambiente atual
        if (éAmbienteLocalSubpasta) {
          return '/' + pathLimpo;
        }

        // No servidor oficial (raiz do domínio), retorna apenas a rota padrão
        return '/' + pathLimpo;
    };


    //---função que decide se é interno ou externo o link
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
                    <a class="br-item"  href="#">Serviços</a>
                    <a class="br-item" target="_blank" href="https://grp.riogrande.rs.gov.br/transparencia/prefeitura/#/">Transparência</a>
                    <a class="br-item"  href="#">Turismo</a>
                    <a class="br-item"  href="https://docker.riogrande.rs.gov.br/investe/visaogeral">Indicadores</a>
                    <a class="br-item"  href="#">Oportunidades</a>
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
              <!-- Loop Nível 1 -->
              <template v-for="menu in $page.props.menuData" :key="menu.id">

                <!-- NÍVEL 1: COM FILHOS -->
                <div v-if="menu.subitems && menu.subitems.length > 0" class="menu-folder">
                  <a class="menu-item" href="javascript:void(0)" @click="toggleSubmenu">
                    <!--<span class="icon"><i :class="menu.icon || 'fas fa-circle'"></i></span>-->
                    <span class="content">{{ menu.label }}</span>
                    <span class="support"><i class="fas fa-angle-down"></i></span>
                  </a>

                  <ul>
                    <li v-for="subitem in menu.subitems" :key="subitem.id">

                      <!-- NÍVEL 2: COM FILHOS (PASTAS) -->
                      <div v-if="subitem.subitems && subitem.subitems.length > 0" class="menu-folder">
                        <a class="menu-item sub-item-level-2" href="javascript:void(0)" @click="toggleSubmenu">
                          <span class="content">{{ subitem.label }}</span>
                          <span class="support"><i class="fas fa-angle-down"></i></span>
                        </a>

                        <!-- NÍVEL 3: ITENS FINAIS -->
                        <ul>
                          <li v-for="neto in subitem.subitems" :key="neto.id">
                            <!-- Nível 3 Externo -->
                            <a v-if="eLinkExterno(neto.href)" class="menu-item sub-item-level-3" :href="formatarLinkLocal(neto.href)" target="_blank">
                              <span class="content">{{ neto.label }}</span>
                            </a>
                            <!-- Nível 3 Interno -->
                            <Link v-else class="menu-item sub-item-level-3" :href="formatarLinkLocal(neto.href)">
                              <span class="content">{{ neto.label }}</span>
                            </Link>
                          </li>
                        </ul>
                      </div>

                      <!-- NÍVEL 2: LINK SIMPLES -->
                      <template v-else>
                        <!-- Nível 2 Externo -->
                        <a v-if="eLinkExterno(subitem.href)" class="menu-item sub-item-level-2" :href="formatarLinkLocal(subitem.href)" target="_blank">
                          <span class="content">{{ subitem.label }}</span>
                        </a>
                        <!-- Nível 2 Interno -->
                        <Link v-else class="menu-item sub-item-level-2" :href="formatarLinkLocal(subitem.href)">
                          <span class="content">{{ subitem.label }}</span>
                        </Link>
                      </template>

                    </li>
                  </ul>
                </div>

                <!-- NÍVEL 1: LINK SIMPLES -->
                <template v-else>
                  <!-- Nível 1 Externo -->
                  <a v-if="eLinkExterno(menu.href)" class="menu-item" :href="formatarLinkLocal(menu.href)" target="_blank">
                  <!--- <span class="icon"><i :class="menu.icon || 'fas fa-circle'"></i></span>-->
                    <span class="content">{{ menu.label }}</span>
                  </a>
                  <!-- Nível 1 Interno -->
                  <Link v-else class="menu-item" :href="formatarLinkLocal(menu.href)">
                   <!--- <span class="icon"><i :class="menu.icon || 'fas fa-circle'"></i></span>-->
                    <span class="content">{{ menu.label }}</span>
                  </Link>
                </template>

              </template>
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

    /* 3. LÓGICA DE EXIBIÇÃO (Esconder/Mostrar) */
    /* Esconde qualquer lista dentro do menu por padrão */
    .menu-body ul {
      display: none;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    /* Mostra a lista apenas quando o pai (.menu-folder) estiver ativo */
    .menu-folder.active > ul {
      display: block;
    }

    /* Rotaciona a seta quando aberto */
    .menu-folder.active > .menu-item .support i {
      transform: rotate(180deg);
    }

    /* 4. ITENS DO MENU E HIERARQUIA (Nível 1, 2 e 3) */

    /* Estilo Base para todos os itens */
    .menu-item {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #1351b4; /* Azul GOV.BR */
      font-weight: 600;
      padding: 12px 15px;
      border-bottom: 1px solid #f0f0f0;
      transition: all 0.2s;
      cursor: pointer;
      line-height: 1.2; /* Melhora a leitura se o texto quebrar em duas linhas */
      word-wrap: break-word;
      overflow-wrap: break-word;
    }

    /* Nível 2 (Filhos) */
    .menu-folder ul .menu-item {
      padding-left: 40px;
      background-color: #fafafa;
      font-size: 0.95rem;
      font-weight: 500;
      border-left: 4px solid transparent;
    }

    /* Nível 3 (Netos) */
    .menu-folder ul ul .menu-item {
      padding-left: 60px;
      background-color: #ffffff;
      font-size: 0.9rem;
      font-weight: 400;
      color: #333; /* Texto mais suave para o último nível */
    }

    /* Efeito de Hover Geral */
    .menu-item:hover {
      background-color: #f2f5fd !important;
      border-left: 4px solid #1351b4;
      color: #1351b4;
    }

    /* 5. AUXILIARES */
    .support {
      margin-left: auto;
      transition: transform 0.2s;
    }

    .icon {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }
</style>




