@extends('layouts.layout')
@section('title', 'Novo Pedido de Licença')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-file-alt me-2"></i>Novo Pedido de Licença</span>
    <a href="{{ route('leaveRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">

    <!-- Se o funcionário ainda não foi buscado, exibe o formulário de busca -->
    @if(!isset($employee))
      <form action="{{ route('leaveRequest.searchEmployee') }}" method="GET" class="mb-4">
        <div class="row g-3">
          <div class="col-md-4">
            <div class="form-floating">
              <input type="number" name="employeeId" id="employeeId" class="form-control" placeholder="ID do Funcionário" value="{{ old('employeeId') }}">
              <label for="employeeId">ID do Funcionário</label>
            </div>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100 mt-0">
              <i class="bi bi-search"></i> Buscar
            </button>
          </div>
        </div>
      </form>

    @else
      <!-- Caso o funcionário tenha sido encontrado, exibe os dados e o formulário -->
      <h5>Seus Dados:</h5>
      <p><strong>Nome:</strong> {{ $employee->fullName }}</p>
      <p><strong>Departamento:</strong> {{ $currentDepartment->title ?? '-' }}</p>

      <form action="{{ route('leaveRequest.store') }}" method="POST">
        @csrf
        <input type="hidden" name="employeeId" value="{{ $employee->id }}">
        @isset($currentDepartment)
          <input type="hidden" name="departmentId" value="{{ $currentDepartment->id }}">
        @endisset

        <!-- Linha: Tipo de Licença (à esquerda) e Tipo de Funcionário (à direita) -->
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="leaveTypeId" class="form-label">Tipo de Licença</label>
            <select name="leaveTypeId" id="leaveTypeId" class="form-select" required>
              <option value="">-- Selecione o tipo de licença --</option>
              @foreach($leaveTypes as $lt)
                <option value="{{ $lt->id }}" @if(old('leaveTypeId') == $lt->id) selected @endif>
                  {{ $lt->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Tipo de Funcionário</label>
            <input type="text" class="form-control" value="{{ $employee->employeeType->name ?? 'Não definido' }}" readonly>
          </div>
        </div>

        <!-- Linha: Razão do Pedido -->
        <div class="row mt-3">
          <div class="col-md-8 offset-md-2">
            <div class="mb-3">
              <label for="reason" class="form-label">Razão do Pedido</label>
              <textarea name="reason" id="reason" rows="4" class="form-control">{{ old('reason') }}</textarea>
            </div>
          </div>
        </div>

        <!-- Botão de envio -->
        <div class="row">
          <div class="col text-center">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-check-circle"></i> Salvar Pedido de Licença
            </button>
          </div>
        </div>
      </form>
    @endif

  </div>
</div>

@endsection
