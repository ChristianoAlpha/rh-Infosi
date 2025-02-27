@extends('layouts.layout')
@section('title', 'Novo Tipo de Funcionário')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-plus-circle me-2"></i>Novo Tipo de Funcionário</span>
    <a href="{{ route('employeeType.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('employeeType.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Digite o nome do tipo de funcionário" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Digite uma descrição (opcional)">{{ old('description') }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle"></i> Salvar
      </button>
    </form>
  </div>
</div>

@endsection
