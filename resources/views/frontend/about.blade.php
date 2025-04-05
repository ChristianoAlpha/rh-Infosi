{{-- resources/views/frontend/about.blade.php --}}

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="HTML5 Template" />
  <meta name="description" content="INFOSI Recursos Humanos" />
  <meta name="author" content="INFOSI" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title>Sobre Nós - INFOSI</title>

  <link rel="shortcut icon" href="{{ asset('auth/img/infosi3.png') }}" />

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/animate.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/owl.carousel.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/font-awesome.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/themify-icons.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/flaticon.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/revolution/css/layers.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/revolution/css/settings.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/prettyPhoto.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/shortcodes.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/main.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/responsive.css') }}"/>
  
  @stack('styles')
</head>
<body>
  <!-- Preloader -->
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>

  <!-- Cabeçalho (Topbar, Branding, Navbar) -->
  @include('layouts.site.header')

  <!-- Conteúdo Principal -->
  <div class="page">

    @php
    $directorGeneral = \App\Models\Admin::where('role', 'director')
                                         ->where('directorType', 'directorGeneral')
                                         ->first();
    $directorTechnical = \App\Models\Admin::where('role', 'director')
                                           ->where('directorType', 'directorTechnical')
                                           ->first();
    $directorAdministrative = \App\Models\Admin::where('role', 'director')
                                                ->where('directorType', 'directorAdministrative')
                                                ->first();
  @endphp
  
  <!-- Seção dos Diretores (Layout Triangular) -->
  <section class="ttm-row directors-section clearfix" style="padding: 50px 0; background-color: #f9f9f9;">
    <div class="container">
      <div class="section-title text-center">
        <h2 style="font-weight: bold;">Nossa Diretoria</h2>
        <p style="max-width: 800px; margin: 0 auto;">Conheça a equipe de liderança que guia o INFOSI rumo à inovação e inclusão digital.</p>
      </div>
      <!-- Diretor Geral (Centralizado) -->
      @if($directorGeneral)
        <div class="row justify-content-center" style="margin-top: 40px;">
          <div class="col-md-4 text-center">
            <div class="director-box">
              <img 
                src="{{ asset('frontend/images/directors/' . ($directorGeneral->directorPhoto ?? 'default.jpg')) }}" 
                alt="{{ $directorGeneral->directorName ?? ($directorGeneral->employee->fullName ?? 'Diretor Geral') }}" 
                class="img-fluid" 
                style="max-width: 200px; border-radius: 5px; margin-bottom: 15px;"
              >
              <h4 style="font-weight: bold; margin-bottom: 5px; color: #E46705;">
                {{ $directorGeneral->directorName ?? ($directorGeneral->employee->fullName ?? 'Diretor Geral') }}
              </h4>
              <p>Diretor(a) Geral</p>
            </div>
          </div>
        </div>
      @endif
      <!-- Diretor Técnico e Diretor Administrativo -->
      <div class="row justify-content-center" style="margin-top: 40px;">
        @if($directorTechnical)
          <div class="col-md-5 text-center">
            <div class="director-box">
              <img 
                src="{{ asset('frontend/images/directors/' . ($directorTechnical->directorPhoto ?? 'default.jpg')) }}" 
                alt="{{ $directorTechnical->directorName ?? ($directorTechnical->employee->fullName ?? 'Diretor Técnico') }}" 
                class="img-fluid" 
                style="max-width: 200px; border-radius: 5px; margin-bottom: 15px;"
              >
              <h4 style="font-weight: bold; margin-bottom: 5px; color: #E46705;">
                {{ $directorTechnical->directorName ?? ($directorTechnical->employee->fullName ?? 'Diretor Técnico') }}
              </h4>
              <p>Diretor(a) da Área Técnica</p>
            </div>
          </div>
        @endif
  
        @if($directorAdministrative)
          <div class="col-md-5 text-center">
            <div class="director-box">
              <img 
                src="{{ asset('frontend/images/directors/' . ($directorAdministrative->directorPhoto ?? 'default.jpg')) }}" 
                alt="{{ $directorAdministrative->directorName ?? ($directorAdministrative->employee->fullName ?? 'Diretor Administrativo') }}" 
                class="img-fluid" 
                style="max-width: 200px; border-radius: 5px; margin-bottom: 15px;"
              >
              <h4 style="font-weight: bold; margin-bottom: 5px; color: #E46705;">
                {{ $directorAdministrative->directorName ?? ($directorAdministrative->employee->fullName ?? 'Diretor Administrativo') }}
              </h4>
              <p>Diretor(a) Geral Adjunta para Área Administrativa</p>
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>
  

    <!-- Seção Institucional -->
    <section class="ttm-row about-section clearfix" style="padding: 50px 0;">
      <div class="container">
        <!-- Introdução -->
        <div class="row">
          <div class="col-12">
            <div class="section-title text-center">
              <h2 style="font-weight: bold;">Sobre o INFOSI</h2>
              <p style="max-width: 800px; margin: 0 auto;">
                O <strong>Instituto Nacional de Fomento da Sociedade da Informação (INFOSI)</strong> impulsiona a inovação e a inclusão digital em Angola, atuando como agente transformador nos serviços públicos de TI e telecomunicações.
              </p>
            </div>
          </div>
        </div>

        <!-- Seção Missão -->
        <div class="row" style="margin-top: 40px;">
          <div class="col-md-12">
            <h3 style="font-weight: bold; text-align: center;">Missão</h3>
            <p style="text-align: justify; margin-top: 20px;">
              O INFOSI tem por missão a execução e distribuição dos serviços públicos de tecnologias de informação e de telecomunicações administrativas, conforme as diretrizes do Executivo. Essa missão abrange a implementação de políticas que promovam o desenvolvimento, o conhecimento e a inclusão digital em todo o país. Para isso, investimos em inovações tecnológicas, na capacitação dos nossos recursos humanos e na implementação de soluções que assegurem o acesso à informação a todos os cidadãos.
            </p>
          </div>
        </div>

        <!-- Seção Histórico -->
        <div class="row" style="margin-top: 40px;">
          <div class="col-md-12">
            <h3 style="font-weight: bold; text-align: center;">Histórico</h3>
            <p style="text-align: justify; margin-top: 20px;">
              O INFOSI foi criado a 20 de Abril de 2016, através do Decreto Presidencial nº 86/16, como resultado da fusão do Centro Nacional das Tecnologias de Informação (CNTI) e do Instituto de Telecomunicações Administrativas (INATEL). Essa integração foi motivada pela necessidade de racionalizar os recursos humanos e materiais anteriormente distribuídos entre essas instituições, permitindo uma atuação mais eficiente e centralizada. 
              <br><br>
              Com sede em Luanda e atuação em todo o território nacional, o INFOSI tem se consolidado como um pilar estratégico para a modernização das infraestruturas de TI e telecomunicações, contribuindo para o desenvolvimento tecnológico e a transformação digital de Angola.
            </p>
          </div>
        </div>
      </div>
    </section>

    <div id="contact-anchor"></div>
  </div>
  <!-- Fim do Conteúdo Principal -->

  <!-- Rodapé -->
  @include('layouts.site.footer')

  <!-- Scripts -->
  <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/js/tether.min.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.easing.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery-waypoints.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery-validate.js') }}"></script>
  <script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
  <script src="{{ asset('frontend/js/numinate.min6959.js?ver=4.9.3') }}"></script>
  <script src="{{ asset('frontend/js/main.js') }}"></script>
  <script src="{{ asset('frontend/js/chart.js') }}"></script>
  <script src="{{ asset('frontend/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
  <script src="{{ asset('frontend/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
  <script src="{{ asset('frontend/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
  <script src="{{ asset('frontend/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
  <script src="{{ asset('frontend/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
  <script src="{{ asset('frontend/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
  <script src="{{ asset('frontend/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
  <script src="{{ asset('frontend/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
  @stack('scripts')

</body>
</html>
