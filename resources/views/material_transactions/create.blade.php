@extends('layouts.admin.layout')
@section('title', $type=='in' ? 'Registrar Entrada' : 'Registrar Saída')
@section('content')
<div class="card mb-4">
  <div class="card-header">
    {{ $type=='in' ? 'Entrada' : 'Saída' }} — {{ ucfirst($category) }}
  </div>
  <div class="card-body">
    <form method="POST"
          action="{{ route("materials.transactions.{$type}.store",['category'=>$category]) }}"
          enctype="multipart/form-data">
      @csrf
      <div class="row gx-3">
        <div class="col-md-6 mb-3">
          <label class="form-label">Material</label>
          <select name="MaterialId" class="form-select" required>
            <option value="">-- selecione --</option>
            @foreach($materials as $m)
              <option value="{{ $m->id }}"
                {{ old('MaterialId')==$m->id?'selected':'' }}>
                {{ $m->Name }} ({{ $m->type->name }}) — Estoque: {{ $m->CurrentStock }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label">Data</label>
          <input type="date" name="TransactionDate" class="form-control"
                 value="{{ old('TransactionDate', date('Y-m-d')) }}" required>
        </div>
        <div class="col-md-3 mb-3">
          <label class="form-label">Quantidade</label>
          <input type="number" name="Quantity" class="form-control"
                 min="1" value="{{ old('Quantity') }}" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Origem / Destino</label>
          <input type="text" name="OriginOrDestination" class="form-control"
                 value="{{ old('OriginOrDestination') }}" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Documento (opcional)</label>
          <input type="file" name="DocumentationPath" class="form-control">
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Observações</label>
          <textarea name="Notes" class="form-control">{{ old('Notes') }}</textarea>
        </div>
      </div>
      <button class="btn btn-success">
        {{ $type=='in'?'Confirmar Entrada':'Confirmar Saída' }}
      </button>
      <a href="{{ route('materials.transactions.index',['category'=>$category]) }}"
         class="btn btn-secondary ms-2">Cancelar</a>
    </form>
  </div>
</div>
@endsection
