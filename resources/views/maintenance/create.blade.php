@extends('layouts.admin.layout')
@section('title','New Maintenance')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi bi-tools"></i> Nova Manutenção</span>
    <a href="{{ route('maintenance.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form action="{{ route('maintenance.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-4">
          <div class="form-floating">
            <select name="vehicleId" class="form-select">
              <option value="">Selecione o veículo</option>
              @foreach($vehicles as $v)
                <option value="{{ $v->id }}">{{ $v->plate }}</option>
              @endforeach
            </select>
            <label>Veículo</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <select name="type" class="form-select">
              <option value="Preventive">Preventiva</option>
              <option value="Corrective">Correctiva</option>
            </select>
            <label>Tipo</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input type="date" name="maintenanceDate" class="form-control" placeholder="Date" value="{{ old('maintenanceDate') }}">
            <label>Data</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <div class="form-floating">
            <input type="number" step="0.01" name="cost" class="form-control" placeholder="Cost" value="{{ old('cost') }}">
            <label>Custo</label>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-floating">
            <textarea name="description" class="form-control" placeholder="Description" style="height: 58px">{{ old('description') }}</textarea>
            <label>Descrição</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-4 mx-auto mt-4">
        <button class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Criar Manutenção
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
