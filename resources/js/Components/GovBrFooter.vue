<template>
  <footer class="br-footer">
    <div class="container-lg py-5">
      <div class="row align-items-center">
        
        <!-- Coluna 1: Endereço -->
        <div class="col-md-4 text-white small mb-4 mb-md-0">
          <p class="font-weight-bold mb-1">Luciano Correa marco</p>
          <p class="mb-0 text-muted-footer">Primeiro de maio, 705 - Hidraulica - Rio Grande/RS</p>
        </div>

        <!-- Coluna 2: Redes Sociais -->
        <div class="col-md-4 text-center text-white">
          <p class="small mb-3">Acompanhe nossas redes sociais:</p>
          <div class="social-icons-footer h4 d-flex justify-content-center gap-3">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-x-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <!-- Coluna 3: Contato -->
        <div class="col-md-4 text-md-right text-white small">
          <p class="mb-1">(53) 3233-8400</p>
          <p class="mb-0">contato@riogrande.rs.gov.br</p>
        </div>

      </div>
    </div>
    
    <!-- Barra Inferior (Créditos/GovBR) -->
    <div class="footer-bottom py-3">
      <div class="container-lg text-center">
        <span class="text-white-50 x-small">© 2026 - Desenvolvido com base no Padrão Digital de Governo</span>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.br-footer {
  background-color: #333333; /* Cinza escuro conforme a imagem */
  color: white;
  margin-top: auto;
}

.footer-bottom {
  background-color: #222222;
  font-size: 0.75rem;
}

.text-muted-footer {
  color: #bbbbbb;
}

.social-icons-footer a {
  color: white;
  transition: opacity 0.2s;
}

.social-icons-footer a:hover {
  opacity: 0.7;
}

.gap-3 { gap: 1rem; }

.x-small { font-size: 0.7rem; }
</style>
