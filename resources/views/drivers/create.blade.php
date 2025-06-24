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
          <label for="employeeId" class="form-label">Vincular Funcionário (opcional)</label>
          <select name="employeeId" id="employeeId" class="form-select">
            <option value="">Nenhum</option>
            @foreach($employees as $e)
              <option value="{{ $e->id }}">{{ $e->fullName }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <label for="fullName" class="form-label">Nome Completo (se não vinculado)</label>
          <input type="text" name="fullName" id="fullName" class="form-control" value="{{ old('fullName') }}">
        </div>
        <div class="col-md-6">
          <label for="bi" class="form-label">B.I. (Bilhete de Identidade)</label>
          <input
            type="text"
            name="bi"
            id="bi"
            class="form-control"
            placeholder="Ex.: ABC123456DEF7890"
            maxlength="16"
            pattern="[A-Za-z0-9]{16}"
            title="Precisamente 16 caracteres alfanuméricos"
            value="{{ old('bi') }}"
          >
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <label for="licenseNumber" class="form-label">Nº da Carta de Condução</label>
          <input type="text" name="licenseNumber" id="licenseNumber" class="form-control" maxlength="50" value="{{ old('licenseNumber') }}">
        </div>
        <div class="col-md-6">
          <label for="licenseCategory" class="form-label">Categoria da Carta</label>
          <input type="text" name="licenseCategory" id="licenseCategory" class="form-control" maxlength="50" value="{{ old('licenseCategory') }}">
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <label for="licenseExpiry" class="form-label">Validade da Carta</label>
          <input type="date" name="licenseExpiry" id="licenseExpiry" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('licenseExpiry') }}">
        </div>
        <div class="col-md-4">
          <label for="status" class="form-label">Status</label>
          <select name="status" id="status" class="form-select">
            <option value="Active">Ativo</option>
            <option value="Inactive">Inativo</option>
          </select>
        </div>
      </div>

      <div class="d-grid gap-2 col-6 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Salvar Motorista
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
