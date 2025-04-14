<style>
  /* Estilos gerais para a navbar */
  .site-navigation nav.menu {
      display: flex;
      align-items: center;
  }
  
  /* Esconde a versão mobile do botão de área restrita por padrão */
  .restricted-mobile {
      display: none;
  }

  /* Exibe o botão de área restrita para desktop */
  .restricted-desktop {
      display: inline-block;
  }
  
  /* ====================== Estilos para telas menores ====================== */
  @media screen and (max-width: 768px) {

      /* 
         O menu ficará fixado à direita, com largura fixa (ex: 300px) e altura total.
         Ajuste "width" conforme desejado.
      */
      .site-navigation nav.menu {
         display: none;
         position: fixed;
         top: 0;
         right: -300px;       /* Começa fora da tela, à direita */
         width: 300px;        /* Ajuste conforme seu gosto */
         height: 100%;
         background: #fff;    /* Ajuste conforme a identidade visual */
         padding: 80px 20px 20px 20px;
         overflow-y: auto;
         z-index: 1000;
         transition: right 0.3s ease;  /* Adiciona transição suave ao aparecer */
      }

      /* Ao adicionar a classe "active", o menu mobile é exibido (encosta à direita) */
      .site-navigation nav.menu.active {
         display: block;
         right: 0; /* Move o menu para dentro da tela */
      }

      /* Botão hamburger posicionado no canto superior direito */
      .ttm-menu-toggle {
         position: fixed;
         top: 50px;
         right: 20px;
         z-index: 1100;
         cursor: pointer;
      }

      /* As barras do hamburger togle bar modificadas */
      .ttm-menu-toggle span {
         display: block;
         width: 30px;
         height: 4px;
         background: #8b3e03;
         margin: 5px 0;
         transition: all 0.3s ease;
      }

      /* Animação para transformar o botão em "X" quando aberto */
      .ttm-menu-toggle.open span.toggle-blocks-1 {
         transform: rotate(45deg) translate(5px, 5px);
      }
      .ttm-menu-toggle.open span.toggle-blocks-2 {
         opacity: 0;
      }
      .ttm-menu-toggle.open span.toggle-blocks-3 {
         transform: rotate(-45deg) translate(5px, -5px);
      }

      /* Exibe o botão de área restrita dentro do menu mobile */
      .restricted-mobile {
         display: block;
         text-align: center;
         margin-bottom: 20px;
      }

      /* Estilos para o texto 'Área Restrita' no mobile */
      .restricted-mobile span.restricted-label {
         display: block;
         margin-top: 5px;
         font-size: 14px;
         font-weight: bold;
         color: #f27602;
      }

      /* Oculta a versão desktop do botão de área restrita em telas menores */
      .restricted-desktop {
         display: none;
      }
  }
</style>

<div id="site-navigation" class="site-navigation">
  <!-- Botão da Área Restrita para desktop (permanece no cabeçalho) -->
  <div class="header-btn restricted-desktop">
    <div id="restricted-area-container" style="position: relative; display: inline-block;">
      <a id="restricted-area-link"
         class="ttm-btn ttm-btn-size-md ttm-btn-shape-square ttm-btn-style-border ttm-btn-color-black"
         href="{{ route('dashboard') }}"
         style="width: 50px; height: 50px; border-radius: 50% !important; display: inline-flex; align-items: center; justify-content: center; padding: 0 !important;">
        <i class="fa fa-user" style="color: #f27602; font-size: 20px; padding: 8px; border: 2px solid #f27602; border-radius: 50%;"></i>
      </a>
      <!-- Tooltip para a Área Restrita (desktop, baseado em hover) -->
      <div id="restricted-tooltip" style="
            display: none;
            position: absolute;
            top: calc(100% + 5px);
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            border: 1px solid #ccc;
            padding: 8px 12px;
            border-radius: 4px;
            white-space: nowrap;
            font-size: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 2000;">
        Área restrita (só para funcionários do INFOSI)
      </div>
    </div>
  </div>
  
  <!-- Botão Hamburger para telas pequenas -->
  <div class="ttm-menu-toggle" id="mobileMenuToggle">
    <span class="toggle-blocks-1"></span>
    <span class="toggle-blocks-2"></span>
    <span class="toggle-blocks-3"></span>
  </div>
  
  <!-- Menu de Navegação (mobile) -->
  <nav id="menu" class="menu">
    <!-- Versão mobile do botão de área restrita com legenda -->
    <div class="restricted-mobile">
      <a href="{{ route('dashboard') }}" 
         style="display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; border: 2px solid #f27602; border-radius: 50%; margin: 0 auto;">
        <i class="fa fa-user" style="color: #f27602; font-size: 20px; padding: 8px;"></i>
      </a>
      <span class="restricted-label">Área Restrita</span>
    </div>
    <ul class="dropdown">
      <li class="active"><a href="{{ route('frontend.index') }}">Início</a></li> 
      <li><a href="{{ route('frontend.about') }}">Sobre Nós</a></li>
      <li><a href="{{ route('frontend.index') }}#services">Nossos Serviços</a></li>
      <li><a href="#contact-anchor">Contato</a></li>
    </ul>
  </nav>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      var mobileMenuToggle = document.getElementById('mobileMenuToggle');
      var menu = document.getElementById('menu');
      
      // Ao clicar no hamburger, exibe ou oculta o menu mobile
      mobileMenuToggle.addEventListener('click', function() {
          menu.classList.toggle('active');
          mobileMenuToggle.classList.toggle('open');
      });
      
      // Opcional: fecha o menu ao clicar em algum item
      var menuLinks = menu.querySelectorAll('a');
      menuLinks.forEach(function(link) {
          link.addEventListener('click', function() {
              if (menu.classList.contains('active')) {
                  menu.classList.remove('active');
                  mobileMenuToggle.classList.remove('open');
              }
          });
      });
      
      // Tooltip para a área restrita (desktop)
      var restrictedContainer = document.getElementById('restricted-area-container');
      var restrictedTooltip = document.getElementById('restricted-tooltip');
      
      restrictedContainer.addEventListener('mouseenter', function() {
          restrictedTooltip.style.display = 'block';
      });
      restrictedContainer.addEventListener('mouseleave', function() {
          restrictedTooltip.style.display = 'none';
      });
  });
</script>
