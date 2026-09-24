<template>
  <!-- O ID 'main-navigation' deve ser o mesmo do 'data-target' no botão do Header -->
  <div class="br-menu push" id="main-navigation">
    <div class="menu-container">
      <div class="menu-panel">
        <div class="menu-header">
          <div class="menu-title">
            <img src="https://serpro.gov.br" alt="Logo Governo" />
            <span>Nome do Sistema</span>
          </div>
          <div class="menu-close">
            <button class="br-button circle" type="button" aria-label="Fechar o menu" data-dismiss="menu">
              <i class="fas fa-times" aria-hidden="true"></i>
            </button>
          </div>
        </div>
        <nav class="menu-body">
          <!-- Item simples -->
          <a class="menu-item" href="#">
            <span class="icon"><i class="fas fa-home" aria-hidden="true"></i></span>
            <span class="content">Início</span>
          </a>
          <!-- Item com sub-itens (Gestão Pedagógica) -->
          <div class="menu-folder">
            <a class="menu-item" href="javascript:void(0)">
              <span class="icon"><i class="fas fa-graduation-cap" aria-hidden="true"></i></span>
              <span class="content">Gestão Pedagógica</span>
            </a>
            <ul class="menu-folder-list">
              <li><a class="menu-item" href="#"><span class="content">Atividades</span></a></li>
              <li><a class="menu-item" href="#"><span class="content">Núcleos Pedagógicos</span></a></li>
              <li><a class="menu-item" href="#"><span class="content">Programas</span></a></li>
              <li><a class="menu-item" href="#"><span class="content">Projetos</span></a></li>
            </ul>
          </div>
        </nav>
        <div class="menu-footer">
            <div class="menu-info">
                <div class="text-center">Software versão 1.0.0</div>
            </div>
        </div>
      </div>
      <div class="menu-scrim" data-dismiss="menu" tabindex="0"></div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, nextTick } from 'vue';

onMounted(async () => {
  await nextTick();

  const initMenu = () => {
    if (window.core && window.core.BRMenu) {
      const brMenus = window.document.querySelectorAll('.br-menu');
      brMenus.forEach(brMenu => {
        new window.core.BRMenu('br-menu', brMenu);
      });
    } else {
      console.warn('Gov.br core.js não encontrado. Os dropdowns do menu não funcionarão.');
    }
  };

  initMenu();
  setTimeout(initMenu, 100);
});
</script>

<style scoped>
/* Garante que os submenus do hamburger comecem FECHADOS */
/* Isso permite que o JS do Gov.br faça o toggle (collapse) corretamente */
.menu-folder ul {
    display: none;
}

/* Quando o JS do Gov.br adiciona a classe 'active', o menu abre */
.menu-folder.active ul {
    display: block;
}
</style>
