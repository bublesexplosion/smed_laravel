<template>
  <div class="wrapper">
    <GovBrHeader class="main-header" />

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
      <Link :href="route('dashboard')" class="brand-link border-bottom border-secondary">
        <span class="brand-text font-weight-light ml-3">Painel Administrativo</span>
     
      </Link>

      <div class="sidebar">
        <nav class="mt-2">
          
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            
            <!-- Link Fixo: Dashboard (Sempre visível) -->
            <li class="nav-item">
              <Link :href="route('dashboard')" 
                    class="nav-link" 
                    :class="{ 'active': $page.component === 'Dashboard' }">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Dashboard</p>
              </Link>
            </li>
      
          <!-- LOOP DINÂMICO: SEÇÕES -->
        <template v-for="section in menuLocal" :key="'sec-' + section.id">
          
          <!-- Mantemos 'nav-item' para o CSS, mas o AdminLTE não vai interceptar devido ao .stop no link -->
          <li v-if="(section.menuItems?.length > 0) || (section.menu_items?.length > 0)" 
              class="nav-item" 
              :class="{ 'menu-open': section.isOpen }">
            
            <!-- O .stop impede que o evento suba e seja pego pelo jQuery do AdminLTE -->
            <a href="#" class="nav-link" @click.stop.prevent="section.isOpen = !section.isOpen">
              <i :class="[section.icon || 'fas fa-folder', 'nav-icon']"></i>
              <p>
                {{ section.name }}
                <i class="right fas fa-angle-left" :style="section.isOpen ? 'transform: rotate(-90deg); transition: transform 0.3s;' : 'transition: transform 0.3s;'"></i>
              </p>
            </a>

            <!-- SUBMENU COM TRANSIÇÃO SUAVE -->
            <transition 
              name="menu-slide"
              @before-enter="beforeEnter"
              @enter="enter"
              @after-enter="afterEnter"
              @before-leave="beforeLeave"
              @leave="leave"
              @after-leave="afterLeave"
            >
              <!-- Mantemos a classe original para alinhar verticalmente como lista -->
              <ul v-show="section.isOpen" class="nav nav-treeview">
                <li v-for="item in (section.menuItems || section.menu_items)" :key="'item-' + item.id" class="nav-item">
                 <!-- Altere a linha 57 do seu AdminLayout.vue para esta estrutura -->
                  <Link 
                    :href="item.link.startsWith('/') ? item.link : route(item.link)" 
                    class="nav-link" 
                    :class="{ 'active': $page.url === item.link || $page.url.startsWith(item.link) }"
                  >
                    <i :class="[item.icon || 'fas fa-circle', 'nav-icon']"></i>
                    <p>{{ item.label }}</p>
                  </Link>
                </li>
              </ul>
            </transition>

          </li>
        </template>


          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <section class="content pt-4">
        <div class="container-fluid">
          <slot />
        </div>
      </section>
    </div>

    <footer class="main-footer">
       <span>Desenvolvido com GOVBR-DS</span>
    </footer>
  </div>
</template>

<script setup>
    import GovBrHeader from '@/Components/GovBrHeader.vue';
    import { Link, usePage, router } from '@inertiajs/vue3';
    import { ref, computed, watch, onMounted, onUnmounted } from 'vue'; // Adicionado watch

    const isValidRoute = (routeName) => {
        try {
            return route().check(routeName);
        } catch (e) {
            return false;
        }
    };

    const props = defineProps({
        menu: Array,
        title: String,
        text: {
          type: [String, Object],
          default: ''
        },
        center: {
          type: [String, Object],
          default: ''
        }
      });

    
    const page = usePage();
    
    // Referência reativa local para controlar o menu e o estado aberto/fechado
    const menuLocal = ref([]);

    // Função que monta o menu local adicionando a propriedade isOpen
    const inicializarMenu = (menuData) => {
        if (!menuData) return [];
        return menuData.map(section => {
            const items = section.menuItems || section.menu_items || [];
            
            // Verifica se alguma rota filha está ativa no momento para começar aberta
            const temItemAtivo = items.some(item => page.url.startsWith(item.link));

            return {
                ...section,
                isOpen: temItemAtivo // Começa true se houver filho ativo, se não false
            };
        });
    };

    // Fica de olho nas mudanças do menu global (Inertia) e atualiza o local
    watch(() => page.props.auth.menu, (novoMenu) => {
        menuLocal.value = inicializarMenu(novoMenu);
    }, { immediate: true });

    // --- MONITOR DE INATIVIDADE PARA O ADMINLTE ---
    const TEMPO_INATIVO = 15 * 60 * 1000; 
    let temporizador = null;

    const deslogarPorInatividade = () => {
        router.post(route('logout'), {}, {
            onSuccess: () => { window.location.href = route('login'); },
            onError: () => { window.location.href = route('login'); }
        });
    };

    const resetarTemporizador = () => {
        if (temporizador) clearTimeout(temporizador);
        temporizador = setTimeout(deslogarPorInatividade, TEMPO_INATIVO);
    };

    onMounted(() => {
        const eventos = ['mousemove', 'keydown', 'scroll', 'click'];
        eventos.forEach(evento => window.addEventListener(evento, resetarTemporizador));
        resetarTemporizador();
    });

    onUnmounted(() => {
        const eventos = ['mousemove', 'keydown', 'scroll', 'click'];
        eventos.forEach(evento => window.removeEventListener(evento, resetarTemporizador));
        if (temporizador) clearTimeout(temporizador);
    });

    //para menu abrir suave
    const beforeEnter = (el) => {
      el.style.height = '0';
      el.style.opacity = '0';
      el.style.overflow = 'hidden';
    };

    const enter = (el) => {
      el.style.transition = 'height 0.3s ease-in-out, opacity 0.3s ease-in-out';
      el.style.height = el.scrollHeight + 'px';
      el.style.opacity = '1';
    };

    const afterEnter = (el) => {
      el.style.height = 'auto';
      el.style.overflow = '';
    };

    const beforeLeave = (el) => {
      el.style.height = el.scrollHeight + 'px';
      el.style.overflow = 'hidden';
    };

    const leave = (el) => {
      // Força o navegador a processar a altura atual antes de mudar para zero
      el.offsetHeight; 
      el.style.transition = 'height 0.3s ease-in-out, opacity 0.3s ease-in-out';
      el.style.height = '0';
      el.style.opacity = '0';
    };

    const afterLeave = (el) => {
      el.style.height = '';
      el.style.overflow = '';
    };


</script>


<style scoped>
    /* Seus estilos permanecem os mesmos... */
    .main-header {
      border-bottom: 1px solid #dee2e6 !important;
      margin-left: 250px;
    }
    .sidebar-collapse .main-header {
      margin-left: 4.6rem !important;
    }
    .nav-sidebar .nav-link p {
        margin-left: 10px;
    }
    .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
        background-color: #1351b4 !important; /* Azul GovBR */
        color: #fff !important;
    }
    .content-wrapper {
        padding-top: 20px;
        background-color: #f4f6f9;
    }
    .nav-item-custom {
  position: relative;
  display: block;
  width: 100%;
}
.nav-treeview-custom {
  list-style: none;
  padding: 0;
  margin: 0;
  padding-left: 1rem; /* Mantém o recuo dos subitens */
}
</style>
