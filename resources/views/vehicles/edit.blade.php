@extends('layouts.admin.layout')
@section('title','Edit Vehicle')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">Editar Veículo Nº{{ $vehicle->id }}</div>
  <div class="card-body">
    <form action="{{ route('vehicles.update',$vehicle->id) }}" method="POST">
      @csrf @method('PUT')
      <div class="row g-3">
        <!-- campos iguais ao create, mas com value="{{ old(...,$vehicle->... ) }}" -->
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" name="plate" class="form-control" placeholder="Plate" 
                   value="{{ old('plate',$vehicle->plate) }}">
            <label>Matricula</label>
          </div>
        </div>
        <!-- repetir para model, brand, yearManufacture, color, loadCapacity -->Marca
        <!-- status, driverId, startDate, endDate, notes -->
      </div>
      <div class="d-grid gap-2 col-4 mx-auto mt-4">
        <button class="btn btn-primary btn-lg"><i class="bi bi-check-circle me-2"></i>Atualizar Veículo</button>
      </div>
    </form>
  </div>
</div>

@endsection
