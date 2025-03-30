<header id="masthead" class="header ttm-header-style-classic">
    <!-- Barra Superior -->
    <div class="ttm-topbar-wrapper ttm-bgcolor-darkgrey ttm-textcolor-white clearfix">
      <div class="container">
        <div class="ttm-topbar-content">
          <ul class="top-contact ttm-highlight-left text-left">
            <li><i class="fa fa-duotone fa-solid fa-building"></i><strong>RH</strong> Recursos Humanos</li>
          </ul>
          <div class="topbar-right text-right">
            <ul class="top-contact">
              <li><i class="fa fa-envelope-o"></i><a href="mailto:info@example.com">info@example.com</a></li>
              <li><i class="fa fa-phone"></i>+ 18000-200-1234</li>
            </ul>
            <div class="ttm-social-links-wrapper list-inline">
              <ul class="social-icons">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-flickr"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fim da Barra Superior -->
  
    <!-- Cabeçalho Principal (Branding e Navbar) -->
    <div class="ttm-header-wrap">
      <div id="ttm-stickable-header-w" class="ttm-stickable-header-w clearfix">
        <div id="site-header-menu" class="site-header-menu">
          <div class="site-header-menu-inner ttm-stickable-header">
            <div class="container">
              <!-- Branding -->
              <div class="site-branding">
                <a class="home-link" href="{{ route('frontend.index') }}" title="Fondex" rel="home">
                  <img id="logo-img" class="img-center" src="{{ asset('auth/img/infosi2.png') }}" alt="logo-img">
                </a>
              </div>
              <!-- Inclui o Navbar -->
              @include('layouts.frontend.navbar')
            </div>
          </div>
        </div>
      </div><!-- ttm-stickable-header-w end-->
    </div><!-- ttm-header-wrap end -->
  </header>
  