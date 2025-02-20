@extends('layout')
@section('title', 'Novo Cargo')
@section('content')

<div class="card mb-4 mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-plus-circle me-2"></i>Adicionar Cargo</span>
    <a href="{{ route('positions.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>  
  <div class="card-body">
    {{-- Exibição de erros 
    
    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif--}}
    

    

    <form method="POST" action="{{ route('positions.store') }}">
      @csrf
      
      <!-- Linha: Nome do Cargo -->
      <div class="mb-3">
        <div class="form-floating">
          <input type="text" name="name" class="form-control" id="name" placeholder="Nome do Cargo">
          <label for="name">Nome do Cargo</label>
        </div>
      </div>
      
      <!-- Linha: Descrição (Opcional) -->
      <div class="mb-3">
        <div class="form-floating">
          <textarea name="description" class="form-control" id="description" placeholder="Descrição" style="height: 100px;"></textarea>
          <label for="description">Descrição (Opcional)</label>
        </div>
      </div>
      
      <!-- Botão de envio -->
      <div class="d-grid gap-2 col-6 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Criar Cargo
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
