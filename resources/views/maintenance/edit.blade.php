@extends('layouts.admin.layout')
@section('title','Editar Manutenção')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-tools me-2"></i>Editar Manutenção Nº{{ $maintenance->id }}</span>
    <a href="{{ route('maintenance.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form action="{{ route('maintenance.update', $maintenance->id) }}" method="POST">
      @csrf @method('PUT')

      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating">
            <select name="vehicleId" id="vehicleId" class="form-select">
              @foreach($vehicles as $v)
                <option value="{{ $v->id }}"
                  @if(old('vehicleId',$maintenance->vehicleId)==$v->id) selected @endif>
                  {{ $v->plate }}
                </option>
              @endforeach
            </select>
            <label for="vehicleId">Viatura</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <select name="type" id="type" class="form-select">
              @foreach(['Preventive','Corrective'] as $t)
                <option value="{{ $t }}"
                  @if(old('type',$maintenance->type)==$t) selected @endif>
                  {{ $t=='Preventive'?'Preventiva':'Corretiva' }}
                </option>
              @endforeach
            </select>
            <label for="type">Tipo</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="date" name="maintenanceDate" id="maintenanceDate" class="form-control"
                   placeholder="Data" value="{{ old('maintenanceDate',$maintenance->maintenanceDate) }}">
            <label for="maintenanceDate">Data</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="number" step="0.01" name="cost" id="cost" class="form-control"
                   placeholder="Custo" value="{{ old('cost',$maintenance->cost) }}">
            <label for="cost">Custo(em Kwanza)</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-12">
          <div class="form-floating">
            <textarea name="description" id="description" class="form-control" placeholder="Descrição" style="height:80px">{{ old('description',$maintenance->description) }}</textarea>
            <label for="description">Descrição</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-md-4 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Atualizar Manutenção
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
