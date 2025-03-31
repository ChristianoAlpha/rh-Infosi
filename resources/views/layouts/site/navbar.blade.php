<div id="site-navigation" class="site-navigation">
    <div class="header-btn">
      <a class="ttm-btn ttm-btn-size-md ttm-btn-shape-square ttm-btn-style-border ttm-btn-color-black" href="{{ route('dashboard') }}">Dashboard</a>
    </div>
    <div class="header-btn">
      <a class="ttm-btn ttm-btn-size-md ttm-btn-shape-square ttm-btn-style-border ttm-btn-color-black" href="#">Chat</a>
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

    <div class="ttm-menu-toggle">
      <input type="checkbox" id="menu-toggle-form" />
      <label for="menu-toggle-form" class="ttm-menu-toggle-block">
        <span class="toggle-block toggle-blocks-1"></span>
        <span class="toggle-block toggle-blocks-2"></span>
        <span class="toggle-block toggle-blocks-3"></span>
      </label>
    </div>
    <nav id="menu" class="menu">
      <ul class="dropdown">
        <li class="active"><a href="{{ route('frontend.index') }}">Início</a> </li> 
        <li><a href="{{ route('frontend.about') }}">Sobre Nós</a></li>
        <li><a href="{{ route('frontend.services') }}">Nossos Serviços</a></li>
        <li><a href="{{ route('frontend.contact') }}">Contato</a></li>

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
      </ul>
    </nav>
  </div>

  
  