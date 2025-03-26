@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<section class="fxt-template-animation fxt-template-layout31">
    <span class="fxt-shape fxt-animation-active"></span>
    <div class="fxt-content-wrap">
        <div class="fxt-heading-content">
            <div class="fxt-inner-wrap">
                <div class="fxt-transformY-50 fxt-transition-delay-3">
                
                    <a href="{{ route('login') }}" class="fxt-logo" >
                        <img src="{{ asset('auth/img/infosi3.png') }} " alt="Logo">
                    </a>
                </div>
                <div class="fxt-transformY-50 fxt-transition-delay-4">
                    <h1 class="fxt-main-title">Seja bem-vindo!</h1>
                </div>
                <div class="fxt-login-option">
                    <ul>
                        <li class="fxt-transformY-50 fxt-transition-delay-6">
                            <a href="https://infosi.gov.ao">Página oficial INFOSI</a>
                        </li>
                        <li class="fxt-transformY-50 fxt-transition-delay-7">
                            <a href="https://webmail.infosi.gov.ao/">Nosso Webmail</a>
                        </li>
                        <li class="fxt-transformY-50 fxt-transition-delay-7">
                          <a href="https://www.facebook.com/TEC.DIGITAL.AO">Nosso Facebook</a>
                      </li>
                      
                        
                    </ul>
                </div>
            </div>
        </div>

        <div class="fxt-form-content">
            <div class="fxt-page-switcher">
                <h2 class="fxt-page-title mr-3" >Login</h2>
            </div>

            <div class="fxt-main-form">
                <div class="fxt-inner-wrap">
                    @if(session('msg'))
                        <div class="alert alert-info">{{ session('msg') }}</div>
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
                                    <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
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

                            <div class="col-12">
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
@endsection
