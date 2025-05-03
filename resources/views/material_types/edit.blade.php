@extends('layouts.admin.layout')
@section('title','Editar Tipo — '.$type->name)

@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="fas fa-edit me-2"></i> Editar Tipo — {{ $type->name }}
  </div>
  <div class="card-body">
    <form action="{{ route('material-types.update',$type->id) }}" method="POST">
      @csrf @method('PUT')
      <div class="mb-3">
        <label class="form-label">Nome do Tipo</label>
        <input type="text" name="name" class="form-control" value="{{ old('name',$type->name) }}" required>
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Descrição (opcional)</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description',$type->description) }}</textarea>
        @error('description')<small class="text-danger">{{ $message }}</small>@enderror
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-check me-1"></i> Atualizar
      </button>
      <a href="{{ route('material-types.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
  </div>
</div>
@endsection
