@extends('layouts.auth')

@section('title', 'Esqueci Minha Senha')

@section('content')
<div class="auth-container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card" style="width: 400px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Esqueci Minha Senha</h2>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('forgotPasswordEmail') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Enviar Link de Redefinição</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
