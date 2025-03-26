@extends('layouts.auth')

@section('title', 'Redefinir Senha')

@section('content')
<div class="container">
    <h2>Redefinir Senha</h2>
    <form action="{{ route('resetPasswordUpdate') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Nova Senha:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Redefinir Senha</button>
    </form>
</div>
@endsection
