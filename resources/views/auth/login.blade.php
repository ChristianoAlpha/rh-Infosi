@extends('layouts.layout')
@section('title', 'Login')
@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Área de Login</h4>
      </div>
      <div class="card-body">
        @if(session('msg'))
          <div class="alert alert-info">{{ session('msg') }}</div>
        @endif
        <form method="POST" action="{{ route('login.post') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="text" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}">
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror">
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-box-arrow-in-right"></i> Entrar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
