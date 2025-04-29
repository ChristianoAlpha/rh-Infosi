@extends('layouts.admin.layout')
@section('title', 'Novo Material')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="bi bi-plus-circle me-2"></i> Cadastrar Material
  </div>
  <div class="card-body">
    <form action="{{ route('materials.store') }}" method="POST">
      @csrf
      <input type="hidden" name="Category" value="{{ $category }}">

      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="Name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Numero de Serie</label>
        <input type="text" name="SerialNumber" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Unidade de medida do material</label>
        <input type="text" name="UnitOfMeasure" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Nome do Fornecedor</label>
        <input type="text" name="SupplierName" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label"> Identificação do Fornecedor (B.I/NIF)</label>
        <input type="text" name="SupplierIdentifier" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Data de entrada</label>
        <input type="date" name="EntryDate" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Entrada Inicial do Stock</label>
        <input type="number" name="CurrentStock" class="form-control" min="0" value="0" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Observações</label>
        <textarea name="Notes" class="form-control" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle me-1"></i> Salvar
      </button>
      <a href="{{ route('materials.index',['category'=>$category]) }}" 
         class="btn btn-secondary ms-2">Cancelar</a>
    </form>
  </div>
</div>

@endsection
