@extends('layouts.layout')
@section('title', 'Registro de Presença')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-calendar-check me-2"></i>Registrar Presença</span>
        <a href="{{ route('attendance.index') }}" class="btn btn-outline-light btn-sm" title="Ver Registros">
          <i class="bi bi-list"></i> Registros
        </a>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('attendance.store') }}">
          @csrf
          <div class="mb-3">
            <label for="employeeId" class="form-label">Funcionário</label>
            <select name="employeeId" id="employeeId" class="form-select" required>
              <option value="">-- Selecione o Funcionário --</option>
              @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="recordDate" class="form-label">Data do Registro</label>
            <input type="date" name="recordDate" id="recordDate" class="form-control" value="{{ date('Y-m-d') }}" required readonly>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
              <option value="">-- Selecione o Status --</option>
              <option value="Presente">Presente</option>
              <option value="Ausente">Ausente</option>
              <option value="Férias">Férias</option>
              <option value="Licença">Licença</option>
              <option value="Doença">Doença</option>
              <option value="Teletrabalho">Teletrabalho</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="observations" class="form-label">Observações</label>
            <textarea name="observations" id="observations" rows="2" class="form-control"></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success" style="width: auto;">
              <i class="bi bi-check-circle"></i> Registrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
