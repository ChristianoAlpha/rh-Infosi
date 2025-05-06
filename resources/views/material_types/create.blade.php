@extends('layouts.admin.layout')
@section('title','Novo Tipo de Material')

@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="fas fa-tags me-2"></i> Novo Tipo de Material
  </div>
  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <form action="{{ route('material-types.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nome do Tipo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Descrição (opcional)</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            @error('description')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Salvar
            </button>
            <a href="{{ route('material-types.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
