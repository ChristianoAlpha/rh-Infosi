{{-- resources/views/frontend/directors.blade.php --}}
@extends('layouts.site.frontend')

@push('styles')
  <style>
    .director-photo-wrapper {
      overflow: hidden;
      border-radius: 5px;
      display: inline-block;
    }
    .director-photo {
      transition: transform 0.3s ease;
      display: block;
    }
    .director-photo-wrapper:hover .director-photo {
      transform: scale(1.1);
    }
    .director-link {
      cursor: pointer;
      text-decoration: none;
      color: inherit;
    }
  </style>
@endpush

@section('content')
  <div class="page">
    <div class="container my-5">
      <h2 class="text-center fw-bold mb-4">Nossa Diretoria</h2>

      @php
        // Extrai cada diretor para posicionar manualmente
        $general        = $directors->firstWhere('directorType', 'directorGeneral');
        $technical      = $directors->firstWhere('directorType', 'directorTechnical');
        $administrative = $directors->firstWhere('directorType', 'directorAdministrative');
      @endphp

      <div class="row gx-4 gy-4 justify-content-center align-items-start">
        {{-- Esquerda: Adjunta Administrativa --}}
        @if($administrative)
          <div class="col-12 col-md-6 col-lg-4 order-md-1 text-center">
            <a href="{{ route('frontend.directors.show', $administrative->id) }}"
               class="director-link director-photo-wrapper">
              <img src="{{ asset('frontend/images/directors/' . ($administrative->directorPhoto ?? 'default.jpg')) }}"
                   alt="{{ $administrative->directorName }}"
                   class="director-photo img-fluid mb-3"
                   style="max-width:200px;">
            </a>
            <h5 class="fw-bold mb-1" style="color:#E46705;">
              {{ $administrative->directorName }}
            </h5>
            <p class="text-muted mb-0">Diretor(a) Geral Adjunta para Área Administrativa</p>
            <div class="mt-2">
              <a href="{{ route('frontend.directors.show', $administrative->id) }}"
                 class="btn btn-sm btn-primary">Perfil</a>
            </div>
          </div>
        @endif

        {{-- Centro: Diretor Geral --}}
        @if($general)
          <div class="col-12 col-md-6 col-lg-4 order-md-2 text-center">
            <a href="{{ route('frontend.directors.show', $general->id) }}"
               class="director-link director-photo-wrapper">
              <img src="{{ asset('frontend/images/directors/' . ($general->directorPhoto ?? 'default.jpg')) }}"
                   alt="{{ $general->directorName }}"
                   class="director-photo img-fluid mb-3"
                   style="max-width:200px;">
            </a>
            <h5 class="fw-bold mb-1" style="color:#E46705;">
              {{ $general->directorName }}
            </h5>
            <p class="text-muted mb-0">Diretor(a) Geral</p>
            <div class="mt-2">
              <a href="{{ route('frontend.directors.show', $general->id) }}"
                 class="btn btn-sm btn-primary">Perfil</a>
            </div>
          </div>
        @endif

        {{-- Direita: Adjunto Técnico --}}
        @if($technical)
          <div class="col-12 col-md-6 col-lg-4 order-md-3 text-center">
            <a href="{{ route('frontend.directors.show', $technical->id) }}"
               class="director-link director-photo-wrapper">
              <img src="{{ asset('frontend/images/directors/' . ($technical->directorPhoto ?? 'default.jpg')) }}"
                   alt="{{ $technical->directorName }}"
                   class="director-photo img-fluid mb-3"
                   style="max-width:200px;">
            </a>
            <h5 class="fw-bold mb-1" style="color:#E46705;">
              {{ $technical->directorName }}
            </h5>
            <p class="text-muted mb-0">Diretor(a) Geral Adjunto para Área Técnica</p>
            <div class="mt-2">
              <a href="{{ route('frontend.directors.show', $technical->id) }}"
                 class="btn btn-sm btn-primary">Perfil</a>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
