@extends('layouts.admin.auth')

@section('title', 'Redefinir Senha')

@section('content')
<div class="auth-container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card" style="width: 400px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Redefinir Senha</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('resetPasswordUpdate') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nova Senha:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Redefinir Senha</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
