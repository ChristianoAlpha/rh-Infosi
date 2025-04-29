@extends('layouts.admin.layout')
@section('title', 'Editar Material')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="bi bi-pencil-square me-2"></i> Editar Material
  </div>
  <div class="card-body">
    <form action="{{ route('materials.update', $material->id) }}" method="POST">
      @csrf @method('PUT')

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="Name" class="form-control" 
               value="{{ $material->Name }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Serial Number</label>
        <input type="text" class="form-control"
               value="{{ $material->SerialNumber }}" disabled>
      </div>

      <div class="mb-3">
        <label class="form-label">Unit Of Measure</label>
        <input type="text" name="UnitOfMeasure" class="form-control" 
               value="{{ $material->UnitOfMeasure }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Initial Stock</label>
        <input type="number" name="CurrentStock" class="form-control"
               value="{{ $material->CurrentStock }}" min="0" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Notes</label>
        <textarea name="Notes" class="form-control" rows="3">{{ $material->Notes }}</textarea>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle me-1"></i> Atualizar
      </button>
      <a href="{{ route('materials.index',['category'=>$material->Category]) }}" 
         class="btn btn-secondary ms-2">Cancelar</a>
    </form>
  </div>
</div>

@endsection
