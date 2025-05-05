@extends('layouts.admin.layout')
@section('title','Editar Material')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="bi bi-pencil me-2"></i> Editar Material
  </div>
  <div class="card-body">
    <form action="{{ route('materials.update',$material->id) }}" method="POST">
      @csrf @method('PUT')

      <!-- Repete todos os campos como em create, mas preenchidos com $material->... -->
      <input type="hidden" name="Category" value="{{ $material->Category }}">

      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="Name" class="form-control" required value="{{ old('Name',$material->Name) }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Tipo de Material</label>
        <select name="Type" class="form-select" required>
          <option value="">-- selecione --</option>
          <option value="Switch"   {{ $material->Type=='Switch'?'selected':'' }}>Switch</option>
          <option value="Servidor" {{ $material->Type=='Servidor'?'selected':'' }}>Servidor</option>
          <option value="Roteador" {{ $material->Type=='Roteador'?'selected':'' }}>Roteador</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Modelo</label>
        <input type="text" name="Model" class="form-control" required value="{{ old('Model',$material->Model) }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Data de Fabrico</label>
        <input type="date" name="ManufactureDate" class="form-control" required value="{{ old('ManufactureDate',$material->ManufactureDate->toDateString()) }}">
      </div>
  
      
      <div class="mb-3">
        <label class="form-label">Observações</label>
        <textarea name="Notes" class="form-control" rows="3">{{ old('Notes',$material->Notes) }}</textarea>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle me-1"></i> Atualizar
      </button>
      <a href="{{ route('materials.index',['category'=>$material->Category]) }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
  </div>
</div>
@endsection
