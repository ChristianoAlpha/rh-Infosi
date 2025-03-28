@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<section class="fxt-template-animation fxt-template-layout31">
    <span class="fxt-shape fxt-animation-active"></span>
    <div class="fxt-content-wrap">
        <!-- Lado ESQUERDO (Azul) -->
        <div class="fxt-heading-content">
            <div class="fxt-inner-wrap">
                <div class="fxt-transformY-50 fxt-transition-delay-3">
                    <a href="{{ route('login') }}" class="fxt-logo">
                        <img src="{{ asset('auth/img/infosi3.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="fxt-transformY-50 fxt-transition-delay-4">
                    <h1 class="fxt-main-title">Seja bem-vindo ao RH do INFOSI!</h1>
                </div>
                <div class="fxt-login-option">
                    <ul>
                        <li class="fxt-transformY-50 fxt-transition-delay-6">
                            <a href="https://infosi.gov.ao" target="_blank" rel="noopener noreferrer">
                                Página oficial INFOSI
                            </a>
                        </li>
                        <li class="fxt-transformY-50 fxt-transition-delay-7">
                            <a href="https://webmail.infosi.gov.ao/" target="_blank" rel="noopener noreferrer">
                                Nosso Webmail
                            </a>
                        </li>
                        <li class="fxt-transformY-50 fxt-transition-delay-7">
                            <a href="https://www.facebook.com/TEC.DIGITAL.AO" target="_blank" rel="noopener noreferrer">
                                Nosso Facebook
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Lado DIREITO (Branco) -->
        <div class="fxt-form-content">
            <div class="fxt-page-switcher">
                <h2 class="fxt-page-title mr-3">Login</h2>
            </div>

            <div class="fxt-main-form">
                <div class="fxt-inner-wrap">
                    @if(session('msg'))
                        <div class="alert alert-info">{{ session('msg') }}</div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="email" id="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="Email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <input id="password" type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="********" required>
                                    <i data-toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <div class="fxt-checkbox-wrap">
                                        <div class="fxt-checkbox-box mr-3">
                                            <input id="checkbox1" type="checkbox">
                                            <label for="checkbox1" class="ps-4">Manter-me logado</label>
                                        </div>
                                        <a href="{{ route('forgotPassword') }}" class="fxt-switcher-text">Esqueceu a senha?</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <div class="form-group">
                                    <button type="submit" class="fxt-btn-fill">Entrar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- CSS adicional para ajustar a imagem de fundo e as bordas dos meus inputs --}}
<style>
    /* Defini o meu container principal com posição relativa */
    .fxt-template-layout31 .fxt-content-wrap {
        position: relative;
    }

    /* Remove o background dos inputs para deixar a área branca pura */
    .fxt-template-layout31 .fxt-form-content {
        background: none;
        position: relative;
        z-index: 1;
    }

    /* Pseudo-elemento para o fundo na parte direita (área branca) */
    .fxt-template-layout31::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 50%; /* Mantém a separação do lado esquerdo */
        background: linear-gradient(
                        rgba(255, 255, 255, 0.85),
                        rgba(255, 255, 255, 0.85)
                   ),
                   url('{{ asset("auth/img/fundoinfosi.png") }}') no-repeat center center;
        background-size: contain; 
        z-index: 0;
    }

    /* Borda preta e fundo claro para os inputs */
    .fxt-main-form .form-control {
        border: 1px solid #000 !important;
        background-color: rgba(255, 255, 255, 0.95);
        color: #000;
    }

    /* Label "Manter-me logado" em preto */
    .fxt-checkbox-wrap label {
        color: #000 !important;
    }

    /* Em telas pequenas, um zoom na imagem */
    @media (max-width: 910px) {
        .fxt-template-layout31::after {
            left: 0; /* Estende a imagem para todo o fundo */
            background-size: cover; /* Faz zoom para cobrir a área */
        }
    }
</style>

{{-- Script para toggle de senha --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleIcons = document.querySelectorAll('.toggle-password');
    toggleIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const inputId = this.getAttribute('data-toggle');
            const input = document.querySelector(inputId);
            if (input) {
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            }
        });
    });
});
</script>
@endsection
