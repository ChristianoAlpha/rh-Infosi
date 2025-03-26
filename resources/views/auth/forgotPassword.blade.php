@extends('layouts.auth')

@section('title', 'Esqueci Minha Senha')

@section('content')
<div class="container">
    <h2>Esqueci Minha Senha</h2>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <form action="{{ route('forgotPasswordEmail') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Link de Redefinição</button>
    </form>
</div>
@endsection
