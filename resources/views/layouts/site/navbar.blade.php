<style>
/* Oculta o input, pois ele serve apenas para controle */
#menu-toggle-form {
  display: none;
}

@media screen and (max-width: 768px) {
  /* Esconde o menu por padrão e posiciona-o de forma fixa */
  #menu {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #fff;  /* ajuste conforme a identidade visual */
    padding: 60px 20px;
    overflow-y: auto;
    z-index: 1000;
  }
  
  /* Quando o checkbox estiver marcado, exibe o menu */
  #menu-toggle-form:checked ~ nav#menu {
    display: block;
  }
  
  
  /* Posiciona o botão toggle (hamburger / X) no canto superior direito */
  .ttm-menu-toggle {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1100;
  }
  
  /* Estilos para as barras do ícone */
  .ttm-menu-toggle-block .toggle-block {
    display: block;
    width: 30px;
    height: 4px;
    background: #000;
    margin: 5px 0;
    transition: all 0.3s ease;
  }
  
  /* Transformação do ícone para "X" quando marcado */
  #menu-toggle-form:checked + .ttm-menu-toggle label .toggle-blocks-1 {
    transform: rotate(45deg) translate(5px, 5px);
  }
  #menu-toggle-form:checked + .ttm-menu-toggle label .toggle-blocks-2 {
    opacity: 0;
  }
  #menu-toggle-form:checked + .ttm-menu-toggle label .toggle-blocks-3 {
    transform: rotate(-45deg) translate(5px, -5px);
  }
}


</style>

<div id="site-navigation" class="site-navigation">
  <div class="header-btn">
    <a class="ttm-btn ttm-btn-size-md ttm-btn-shape-square ttm-btn-style-border ttm-btn-color-black" href="{{ route('dashboard') }}">Dashboard</a>
  </div>
  <div class="header-btn">
    <a class="ttm-btn ttm-btn-size-md ttm-btn-shape-square ttm-btn-style-border ttm-btn-color-black" href="#">Chat</a>
  </div>

  <!-- Coloque o input checkbox aqui (oculto) -->
  <input type="checkbox" id="menu-toggle-form" />

  <!-- Botão do menu -->
  <div class="ttm-menu-toggle">
    <label for="menu-toggle-form" class="ttm-menu-toggle-block">
      <span class="toggle-block toggle-blocks-1"></span>
      <span class="toggle-block toggle-blocks-2"></span>
      <span class="toggle-block toggle-blocks-3"></span>
    </label>
  </div>

  <!-- Menu de navegação -->
  <nav id="menu" class="menu">
    <ul class="dropdown">
      <li class="active"><a href="{{ route('frontend.index') }}">Início</a></li> 
      <li><a href="{{ route('frontend.about') }}">Sobre Nós</a></li>
      <li><a href="{{ route('frontend.index') }}#services">Nossos Serviços</a></li>
      <li><a href="#contact-anchor">Contato</a></li>
    </ul>
  </nav>
</div>

 {{--
    <div class="ttm-rt-contact">
      <div class="ttm-header-icons">
        <span class="ttm-header-icon ttm-header-cart-link">
          <a href="#"><i class="ti ti-shopping-cart"></i><span class="number-cart">0</span></a>
        </span>
        <div class="ttm-header-icon ttm-header-search-link">
          <a href="#"><i class="ti ti-search"></i></a>
          <div class="ttm-search-overlay">
            <form method="get" class="ttm-site-searchform" action="#">
              <div class="w-search-form-h">
                <div class="w-search-form-row">
                  <div class="w-search-input">
                    <input type="search" class="field searchform-s" name="s" placeholder="Digite algo e aperte Enter...">
                    <button type="submit"><i class="ti ti-search"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div> --}}

        {{-- <li><a href="#">Portfólio</a>
          <ul>
            <li><a href="#">Projeto 1</a></li>
            <li><a href="#">Projeto 2</a></li>
            <li><a href="#">Projeto 3</a></li>
          </ul>
        </li>
        <li><a href="#">Blog</a>
          <ul>
            <li><a href="#">Blog Clássico</a></li>
            <li><a href="#">Blog em Grade</a></li>
            <li><a href="#">Blog com Imagem à Esquerda</a></li>
            <li><a href="#">Visualizar Blog</a></li>
          </ul>
        </li> --}}
      

  
  