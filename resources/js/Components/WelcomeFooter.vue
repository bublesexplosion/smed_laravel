<template>
  <footer class="bg-[#001c3d] text-white py-10">
    <div class="container mx-auto px-4">

      <!-- Logo Superior -->
      <div class="mb-12">
        <img src="/images/logo.png" alt="SMED Laravel" class="h-14">
      </div>

      <!-- Grid de Links (Todos brancos agora) -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 border-b border-white/20 pb-12">

        <!-- Coluna 1 -->
        <div>
          <h4 class="font-bold uppercase text-xs tracking-widest mb-6 text-white">Prefeitura</h4>
          <ul class="space-y-3 text-sm">
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">A Cidade</a></li>
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">Administração Direta</a></li>
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">Administração Indireta</a></li>
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">Conselhos</a></li>

          </ul>
        </div>

        <!-- Coluna 2 -->
        <div>
          <h4 class="font-bold uppercase text-xs tracking-widest mb-6 text-white">
            secretarias
          </h4>
          <ul class="space-y-3 text-sm">
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">SMS Saude</a></li>
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">PGM Procuradoria Geral do Municipio</a></li>
          </ul>
        </div>

        <!-- Coluna 3 -->
        <div>
          <h4 class="font-bold uppercase text-xs tracking-widest mb-6 text-white">Imprensa</h4>
          <ul class="space-y-3 text-sm">
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">Notícias</a></li>
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">Galerias</a></li>
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">Agenda</a></li>
          </ul>
        </div>

        <!-- Coluna 4 -->
        <div>
          <h4 class="font-bold uppercase text-xs tracking-widest mb-6 text-white">Fale Conosco</h4>
          <ul class="space-y-3 text-sm">
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">Contato</a></li>
            <li><a href="#" class="text-white/80 hover:text-white transition-colors">Ouvidoria</a></li>
          </ul>
        </div>
      </div>

      <!-- Rodapé Inferior -->
      <div class="mt-8 flex flex-col md:flex-row justify-between items-center">
        <div>
          <h4 class="font-bold uppercase text-[10px] tracking-widest mb-4 text-white">Redes Sociais</h4>
          <div class="flex space-x-5 text-lg">
            <a href="https://www.facebook.com/PrefeituraMunicipaldoRG"                target="_blank"  class="text-white hover:text-blue-300" title="Facebook"> <i class="fab fa-facebook-f"></i></a>
            <a href="https://x.com/PMRGoficial"                                       target="_blank"  class="text-white hover:text-blue-300" title="Twitter">  <i class="fab fa-twitter" ></i></a>
            <a href="https://www.youtube.com/channel/UCeCOe03FRXNUGfOE1VO0lwQ/videos" target="_blank"  class="text-white hover:text-blue-300" title="Youtube">  <i class="fab fa-youtube"></i></a>
            <a href="https://www.instagram.com/prefeituradoriogrande/"                target="_blank"  class="text-white hover:text-blue-300" title="Instagram"><i class="fab fa-instagram" ></i></a>
          </div>
        </div>

        <!-- Selos/Imagens da Direita conforme o print -->
        <div class="flex flex-col sm:flex-row gap-3 mt-8 md:mt-0">

            <a href="https://www.gov.br/acessoainformacao/pt-br"  target="_blank" class="flex items-center space-x-3  px-4 py-2 hover:bg-white/5 transition-colors">
              <div class="w-8 h-8 flex items-center justify-center">
                <!-- Ícone Acesso à Informação (Lupa com cadeado) -->
                <i class="fas fa-unlock-alt text-xl text-white"></i>
              </div>
              <div class="text-[9px] uppercase font-bold text-white leading-tight">
                Acesso à <br> Informação
              </div>
            </a>

            <a href="https://www.gov.br/pt-br"  target="_blank" class="flex items-center space-x-3  rounded px-4 py-2 hover:bg-white/5 transition-colors">
              <div class="w-10 h-10 flex items-center justify-center">
                <!-- Ícone Brasão (Geralmente uma imagem, mas usamos ícone para teste) -->
                <i class="fas fa-landmark text-xl text-white"></i>
              </div>
              <div class="text-[9px] uppercase font-bold text-white leading-tight">
                Governo <br> Federal
              </div>
            </a>

        </div>
      </div>
    </div>
  </footer>
</template>
