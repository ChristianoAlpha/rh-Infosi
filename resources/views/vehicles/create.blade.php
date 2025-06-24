@extends('layouts.admin.layout')
@section('title','New Vehicle')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="fas fa-truck me-2"></i>Novo Veículo
  </div>
  <div class="card-body">
    <form action="{{ route('vehicles.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" name="plate" class="form-control" placeholder="Plate" value="{{ old('plate') }}">
            <label>Matricula</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" name="model" class="form-control" placeholder="Model" value="{{ old('model') }}">
            <label>Modelo</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" name="brand" class="form-control" placeholder="Brand" value="{{ old('brand') }}">
            <label>Marca</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="number" name="yearManufacture" class="form-control" placeholder="Year" value="{{ old('yearManufacture') }}">
            <label>Ano de Fabricação</label>
          </div>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" name="color" class="form-control" placeholder="Color" value="{{ old('color') }}">
            <label>Cor</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <input type="number" step="0.01" name="loadCapacity" class="form-control" placeholder="Load Capacity" value="{{ old('loadCapacity') }}">
            <label>Total dos lugares</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="status" class="form-select">
              <option value="Available" selected>Disponível</option>
              <option value="UnderMaintenance">Em manutenção</option>
              <option value="Unavailable">Indisponível</option>
            </select>
            <label>Status</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="driverId" class="form-select">
              <option value="">Sem Motorista</option>
              @foreach($drivers as $d)
                <option value="{{ $d->id }}">{{ $d->fullName }}</option>
              @endforeach
            </select>
            <label>Atribuir motorista</label>
          </div>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-md-3">
          <div class="form-floating">
            <input type="date" name="startDate" class="form-control" placeholder="Start Date" value="{{ old('startDate') }}">
            <label>Data de início</label>
          </div>
        </div>
        <div class="col-md-9">
          <div class="form-floating">
            <textarea name="notes" class="form-control" placeholder="Notes" style="height: 58px">{{ old('notes') }}</textarea>
            <label>Observações</label>
          </div>
        </div>
      </div>
      <div class="d-grid gap-2 col-4 mx-auto mt-4">
        <button class="btn btn-primary btn-lg"><i class="bi bi-check-circle me-2"></i>Create</button>
      </div>
    </form>
  </div>
</div>

@endsection
