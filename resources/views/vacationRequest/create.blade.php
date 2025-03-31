@extends('layouts.admin.layout')
@section('title', 'Novo Pedido de Férias')
@section('content')
<div class="row justify-content-center">
  <div class="{{ isset($employee) ? 'col-md-6' : 'col-md-8' }}">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-umbrella-beach me-2"></i>Novo Pedido de Férias</span>
        <a href="{{ route('vacationRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
          <i class="bi bi-arrow-left"></i> Voltar
        </a>
      </div>
      <div class="card-body">
        @if(!isset($employee))
          <!-- Formulário de busca -->
          <form action="{{ route('vacationRequest.searchEmployee') }}" method="GET" class="mb-3">
            <div class="row g-2">
              <div class="col-8">
                <div class="form-floating">
                  <input type="text" name="employeeSearch" id="employeeSearch" class="form-control"
                         placeholder="ID ou Nome do Funcionário" value="{{ old('employeeSearch') }}">
                  <label for="employeeSearch">ID ou Nome do Funcionário</label>
                </div>
                @error('employeeSearch')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
              </div>
            </div>
          </form>
        @else
          <hr>

          <div class="mb-3">
            <h5>Dados do Funcionário</h5>
            <p><strong>Nome:</strong> {{ $employee->fullName }}</p>
            <p><strong>Departamento:</strong> {{ $employee->department->title ?? '-' }}</p>
          </div>
          
          <!-- Formulário de Pedido de Férias -->
          <form action="{{ route('vacationRequest.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employeeId" value="{{ $employee->id }}">
            <div class="mb-3">
              <label for="vacationType" class="form-label">Tipo de Férias</label>
              <select name="vacationType" id="vacationType" class="form-select" required>
                <option value="">-- Selecione o Tipo --</option>
                @foreach($vacationTypes as $vt)
                  <option value="{{ $vt }}" {{ old('vacationType') == $vt ? 'selected' : '' }}>{{ $vt }}</option>
                @endforeach
              </select>
            </div>
            <div class="row g-2">
              <div class="col-6">
                <div class="form-floating">
                  <input type="date" name="vacationStart" id="vacationStart" class="form-control" value="{{ old('vacationStart') }}" required>
                  <label for="vacationStart">Data de Início</label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-floating">
                  <input type="date" name="vacationEnd" id="vacationEnd" class="form-control" value="{{ old('vacationEnd') }}" required>
                  <label for="vacationEnd">Data de Fim</label>
                </div>
              </div>
            </div>
            <div class="mb-3 mt-2">
              <label for="reason" class="form-label">Razão do Pedido</label>
              <textarea name="reason" id="reason" rows="3" class="form-control">{{ old('reason') }}</textarea>
            </div>
            <div class="mb-3">
              <label for="supportDocument" class="form-label">Documento de Suporte (opcional)</label>
              <input type="file" name="supportDocument" id="supportDocument" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Enviar Pedido
              </button>
            </div>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
