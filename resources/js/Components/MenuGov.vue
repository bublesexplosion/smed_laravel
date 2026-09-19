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
          <!-- Item com sub-itens -->
          <div class="menu-folder">
            <a class="menu-item" href="javascript:void(0)">
              <span class="icon"><i class="fas fa-edit" aria-hidden="true"></i></span>
              <span class="content">Cadastros</span>
            </a>
            <ul>
              <li><a class="menu-item" href="#"><span class="content">Usuários</span></a></li>
              <li><a class="menu-item" href="#"><span class="content">Configurações</span></a></li>
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
import { onMounted } from 'vue';

onMounted(() => {
  // Inicializa o comportamento do Menu (JS do GOVBR)
  const menuList = [];
  for (const brMenu of window.document.querySelectorAll('.br-menu')) {
    menuList.push(new window.core.BRMenu('br-menu', brMenu));
  }
});
</script>
