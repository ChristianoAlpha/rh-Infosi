{{-- resources/views/frontend/directors.blade.php --}}
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="HTML5 Template" />
  <meta name="description" content="INFOSI Recursos Humanos" />
  <meta name="author" content="INFOSI" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title>Nossa Diretoria - INFOSI</title>
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

  <!-- Cabeçalho -->
  @include('layouts.site.header')

  {{-- Recupera os dados dos diretores --}}
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

  <!-- Conteúdo Principal -->
  <div class="page">
    <div class="container my-4">
      <div class="text-center">
        <h2 style="font-weight: bold;">Nossa Diretoria</h2>
      </div>
      <div class="row">
        @if($directorGeneral)
          <div class="col-md-4 text-center">
            <div class="director-box">
              <a href="#" class="director-modal-trigger"
                 data-bs-toggle="modal"
                 data-bs-target="#directorModal"
                 data-name="{{ $directorGeneral->directorName ?? ($directorGeneral->employee->fullName ?? 'Diretor Geral') }}"
                 data-bio="{{ $directorGeneral->biography ?? 'Biografia não disponível.' }}"
                 data-linkedin="{{ $directorGeneral->linkedin ?? '#' }}">
                <img src="{{ asset('frontend/images/directors/' . ($directorGeneral->directorPhoto ?? 'default.jpg')) }}"
                     alt="{{ $directorGeneral->directorName ?? ($directorGeneral->employee->fullName ?? 'Diretor Geral') }}"
                     class="img-fluid" style="max-width: 200px; border-radius: 5px; margin-bottom: 15px;">
                <h4 style="font-weight: bold; color: #E46705;">
                  {{ $directorGeneral->directorName ?? ($directorGeneral->employee->fullName ?? 'Diretor Geral') }}
                </h4>
              </a>
              <p>Diretor(a) Geral</p>
            </div>
          </div>
        @endif

        @if($directorTechnical)
          <div class="col-md-4 text-center">
            <div class="director-box">
              <a href="#" class="director-modal-trigger"
                 data-bs-toggle="modal"
                 data-bs-target="#directorModal"
                 data-name="{{ $directorTechnical->directorName ?? ($directorTechnical->employee->fullName ?? 'Diretor Técnico') }}"
                 data-bio="{{ $directorTechnical->biography ?? 'Biografia não disponível.' }}"
                 data-linkedin="{{ $directorTechnical->linkedin ?? '#' }}">
                <img src="{{ asset('frontend/images/directors/' . ($directorTechnical->directorPhoto ?? 'default.jpg')) }}"
                     alt="{{ $directorTechnical->directorName ?? ($directorTechnical->employee->fullName ?? 'Diretor Técnico') }}"
                     class="img-fluid" style="max-width: 200px; border-radius: 5px; margin-bottom: 15px;">
                <h4 style="font-weight: bold; color: #E46705;">
                  {{ $directorTechnical->directorName ?? ($directorTechnical->employee->fullName ?? 'Diretor Técnico') }}
                </h4>
              </a>
              <p>Diretor(a) Geral Adjunto para Área Técnica</p>
            </div>
          </div>
        @endif

        @if($directorAdministrative)
          <div class="col-md-4 text-center">
            <div class="director-box">
              <a href="#" class="director-modal-trigger"
                 data-bs-toggle="modal"
                 data-bs-target="#directorModal"
                 data-name="{{ $directorAdministrative->directorName ?? ($directorAdministrative->employee->fullName ?? 'Diretor Administrativo') }}"
                 data-bio="{{ $directorAdministrative->biography ?? 'Biografia não disponível.' }}"
                 data-linkedin="{{ $directorAdministrative->linkedin ?? '#' }}">
                <img src="{{ asset('frontend/images/directors/' . ($directorAdministrative->directorPhoto ?? 'default.jpg')) }}"
                     alt="{{ $directorAdministrative->directorName ?? ($directorAdministrative->employee->fullName ?? 'Diretor Administrativo') }}"
                     class="img-fluid" style="max-width: 200px; border-radius: 5px; margin-bottom: 15px;">
                <h4 style="font-weight: bold; color: #E46705;">
                  {{ $directorAdministrative->directorName ?? ($directorAdministrative->employee->fullName ?? 'Diretor Administrativo') }}
                </h4>
              </a>
              <p>Diretor(a) Geral Adjunta para Área Administrativa</p>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Modal para exibir detalhes do diretor -->
  <div class="modal fade" id="directorModal" tabindex="-1" aria-labelledby="directorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="directorModalLabel">Detalhes do Diretor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <h4 id="modalDirectorName"></h4>
          <p id="modalDirectorBio"></p>
        </div>
        <div class="modal-footer">
          <a id="modalLinkedinLink" href="#" target="_blank" class="btn btn-primary">LinkedIn</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Rodapé -->
  @include('layouts.site.footer')
  <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/js/main.js') }}"></script>
  @stack('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var directorModal = document.getElementById('directorModal');
      directorModal.addEventListener('show.bs.modal', function(event) {
        var trigger = event.relatedTarget;
        var name = trigger.getAttribute('data-name');
        var bio = trigger.getAttribute('data-bio');
        var linkedin = trigger.getAttribute('data-linkedin');
        document.getElementById('modalDirectorName').textContent = name;
        document.getElementById('modalDirectorBio').textContent = bio;
        document.getElementById('modalLinkedinLink').href = linkedin;
      });
    });
  </script>
</body>
</html>
