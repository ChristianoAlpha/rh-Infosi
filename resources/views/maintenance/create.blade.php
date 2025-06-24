@extends('layouts.admin.layout')
@section('title','Nova Manutenção')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-tools me-2"></i>Nova Manutenção</span>
    <a href="{{ route('maintenance.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form action="{{ route('maintenance.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating">
            <select name="vehicleId" id="vehicleId" class="form-select">
              <option value="" selected>Selecione a Viatura</option>
              @foreach($vehicles as $v)
                <option value="{{ $v->id }}">{{ $v->plate }}</option>
              @endforeach
            </select>
            <label for="vehicleId">Viatura</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <select name="type" id="type" class="form-select">
              <option value="Preventive">Preventiva</option>
              <option value="Corrective">Corretiva</option>
            </select>
            <label for="type">Tipo</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="date" name="maintenanceDate" id="maintenanceDate" class="form-control"
                   placeholder="Data" value="{{ old('maintenanceDate') }}">
            <label for="maintenanceDate">Data</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="number" step="0.01" name="cost" id="cost" class="form-control"
                   placeholder="Custo" value="{{ old('cost') }}">
            <label for="cost">Custo(em Kwanza)</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-12">
          <div class="form-floating">
            <textarea name="description" id="description" class="form-control" placeholder="Descrição" style="height: 80px">{{ old('description') }}</textarea>
            <label for="description">Descrição</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Salvar Manutenção
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
