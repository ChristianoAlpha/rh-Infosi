@extends('layouts.admin.layout')
@section('title','Novo Motorista')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-person-plus me-2"></i>Novo Motorista</span>
    <a href="{{ route('drivers.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form action="{{ route('drivers.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating">
            <select name="employeeId" id="employeeId" class="form-select">
              <option value="" selected>Nenhum</option>
              @foreach($employees as $e)
                <option value="{{ $e->id }}">{{ $e->fullName }}</option>
              @endforeach
            </select>
            <label for="employeeId">Vincular Funcionário (opcional)</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="fullName" id="fullName" class="form-control"
                   placeholder="Nome Completo" value="{{ old('fullName') }}">
            <label for="fullName">Nome Completo</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="bi" id="bi" class="form-control"
                   placeholder="B.I. (16 caracteres)"
                   maxlength="16" pattern="[A-Za-z0-9]{16}"
                   value="{{ old('bi') }}">
            <label for="bi">B.I. (16 caracteres)</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="licenseNumber" id="licenseNumber" class="form-control"
                   placeholder="Nº da Carta de Condução" maxlength="50"
                   value="{{ old('licenseNumber') }}">
            <label for="licenseNumber">Nº da Carta de Condução</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="licenseCategory" id="licenseCategory" class="form-control"
                   placeholder="Categoria da Carta" maxlength="50"
                   value="{{ old('licenseCategory') }}">
            <label for="licenseCategory">Categoria da Carta</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="date" name="licenseExpiry" id="licenseExpiry" class="form-control"
                   placeholder="Validade da Carta" min="{{ date('Y-m-d') }}"
                   value="{{ old('licenseExpiry') }}">
            <label for="licenseExpiry">Validade da Carta</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6 offset-md-3">
          <div class="form-floating">
            <select name="status" id="status" class="form-select">
              <option value="Active" selected>Ativo</option>
              <option value="Inactive">Inativo</option>
            </select>
            <label for="status">Status</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Salvar Motorista
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
