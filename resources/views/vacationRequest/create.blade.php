@extends('layouts.layout')
@section('title', 'Novo Pedido de Férias')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-umbrella-beach me-2"></i>Novo Pedido de Férias</span>
    <a href="{{ route('vacationRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    <!-- Formulário para buscar funcionário por ID ou Nome -->
    <form action="{{ route('vacationRequest.searchEmployee') }}" method="GET" class="mb-4">
      <div class="row g-3">
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text" name="employeeSearch" id="employeeSearch" class="form-control"
                   placeholder="ID ou Nome do Funcionário" value="{{ old('employeeSearch') }}">
            <label for="employeeSearch">ID ou Nome do Funcionário</label>
          </div>
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary w-100 mt-0">
            <i class="bi bi-search"></i> Buscar
          </button>
        </div>
      </div>
    </form>

    @isset($employee)
      <hr>
      <!-- Adicionar enctype para upload de arquivo -->
      <form action="{{ route('vacationRequest.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- ID do Funcionário (hidden) -->
        <input type="hidden" name="employeeId" value="{{ $employee->id }}">

        <!-- Linha: Nome do Funcionário e Departamento -->
        <div class="row g-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Nome do Funcionário</label>
              <input type="text" class="form-control" value="{{ $employee->fullName }}" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Departamento</label>
              <input type="text" class="form-control" value="{{ $employee->department->title ?? '-' }}" readonly>
            </div>
          </div>
        </div>

        <!-- Linha: Tipo de Férias e Documento de Suporte -->
        <div class="row g-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Tipo de Férias</label>
              <select name="vacationType" class="form-select" required>
                <option value="">-- Selecione o Tipo de Férias --</option>
                @foreach($vacationTypes as $vt)
                  <option value="{{ $vt }}" @if(old('vacationType') == $vt) selected @endif>{{ $vt }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Documento (opcional)</label>
              <input type="file" name="supportDocument" class="form-control" accept="application/pdf,image/*">
            </div>
          </div>
        </div>

        <!-- Linha: Datas de Início e Fim -->
        <div class="row g-3">
          <div class="col-md-6">
            <div class="form-floating">
              <input type="date" name="vacationStart" id="vacationStart" class="form-control"
                     value="{{ old('vacationStart') }}" required>
              <label for="vacationStart">Data de Início</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <input type="date" name="vacationEnd" id="vacationEnd" class="form-control"
                     value="{{ old('vacationEnd') }}" required>
              <label for="vacationEnd">Data de Fim</label>
            </div>
          </div>
        </div>

        <!-- Campo para Razão do Pedido -->
        <div class="mb-3 mt-3">
          <label class="form-label">Razão do Pedido</label>
          <textarea name="reason" rows="3" class="form-control">{{ old('reason') }}</textarea>
        </div>

        <div class="mt-3 text-center">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Salvar Pedido de Férias
          </button>
        </div>
      </form>
    @endisset
  </div>
</div>

@endsection
