@extends('layouts.admin.layout')
@section('title','Editar Motorista')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-pencil me-2"></i>Editar Motorista Nº{{ $driver->id }}</span>
    <a href="{{ route('drivers.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form action="{{ route('drivers.update', $driver->id) }}" method="POST">
      @csrf @method('PUT')

      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating">
            <select name="employeeId" id="employeeId" class="form-select">
              <option value="">Nenhum</option>
              @foreach($employees as $e)
                <option value="{{ $e->id }}" @if($driver->employeeId==$e->id) selected @endif>
                  {{ $e->fullName }}
                </option>
              @endforeach
            </select>
            <label for="employeeId">Vincular Funcionário (opcional)</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="fullName" id="fullName" class="form-control"
                   placeholder="Nome Completo"
                   value="{{ old('fullName', $driver->fullName) }}">
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
                   value="{{ old('bi', $driver->bi) }}">
            <label for="bi">B.I. (16 caracteres)</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="licenseNumber" id="licenseNumber" class="form-control"
                   placeholder="Nº da Carta de Condução" maxlength="50"
                   value="{{ old('licenseNumber', $driver->licenseNumber) }}">
            <label for="licenseNumber">Nº da Carta de Condução</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="licenseCategory" id="licenseCategory" class="form-control"
                   placeholder="Categoria da Carta" maxlength="50"
                   value="{{ old('licenseCategory', $driver->licenseCategory) }}">
            <label for="licenseCategory">Categoria da Carta</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="date" name="licenseExpiry" id="licenseExpiry" class="form-control"
                   placeholder="Validade da Carta" min="{{ date('Y-m-d') }}"
                   value="{{ old('licenseExpiry', \Carbon\Carbon::parse($driver->licenseExpiry)->format('Y-m-d')) }}">
            <label for="licenseExpiry">Validade da Carta</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6 offset-md-3">
          <div class="form-floating">
            <select name="status" id="status" class="form-select">
              <option value="Active" @if($driver->status=='Active') selected @endif>Ativo</option>
              <option value="Inactive" @if($driver->status=='Inactive') selected @endif>Inativo</option>
            </select>
            <label for="status">Status</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Atualizar Motorista
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
