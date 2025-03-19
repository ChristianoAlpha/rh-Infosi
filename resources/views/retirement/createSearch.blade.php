@extends('layouts.layout')
@section('title', 'Adicionar Pedido de Reforma')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h4>Adicionar Pedido de Reforma</h4>
        <a href="{{ route('retirements.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
          <i class="bi bi-arrow-left"></i> Voltar
        </a>
      </div>
      <div class="card-body">
        <!-- Formulário de busca -->
        <form method="GET" action="{{ route('retirements.searchEmployee') }}" class="mb-4">
          <div class="row g-3">
            <div class="col-md-8">
              <div class="form-floating">
                <input type="text" name="employeeSearch" class="form-control" placeholder="Pesquisar por ID ou Nome do Funcionário" value="{{ old('employeeSearch') }}">
                <label for="employeeSearch">ID ou Nome do Funcionário</label>
              </div>
              @error('employeeSearch')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-primary w-100 mt-0">
                <i class="bi bi-search"></i> Buscar
              </button>
            </div>
          </div>
        </form>

        @if(isset($employee))
          <hr>
          <!-- Exibe os dados do funcionário encontrado -->
          <div class="mb-3">
            <h5>Dados do Funcionário</h5>
            <p><strong>Nome:</strong> {{ $employee->fullName }}</p>
            <p><strong>E-mail:</strong> {{ $employee->email }}</p>
            <p><strong>Departamento:</strong> {{ $employee->department->title ?? '-' }}</p>
          </div>
          <!-- Formulário de Pedido de Reforma -->
          <form method="POST" action="{{ route('retirements.store') }}">
            @csrf
            <input type="hidden" name="employeeId" value="{{ $employee->id }}">
            <div class="mb-3">
              <label for="retirementDate" class="form-label">Data de Reforma</label>
              <input type="date" name="retirementDate" id="retirementDate" class="form-control">
            </div>
            <div class="mb-3">
              <label for="observations" class="form-label">Observações</label>
              <textarea name="observations" id="observations" class="form-control"></textarea>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="Pendente" selected>Pendente</option>
                <option value="Aprovado">Aprovado</option>
                <option value="Rejeitado">Rejeitado</option>
              </select>
            </div>
            <button type="submit" class="btn btn-success w-100">
              <i class="bi bi-check-circle"></i> Enviar Pedido
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
