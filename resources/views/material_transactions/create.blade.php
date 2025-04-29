@extends('layouts.admin.layout')
@section('title', $type=='in' ? 'Registrar Entrada' : 'Registrar Saída')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="bi bi-arrow-{{ $type=='in'?'down':'up' }}-circle me-2"></i>
    {{ $type=='in' ? 'Registrar Entrada' : 'Registrar Saída' }}
    <small class="text-white-50">({{ ucfirst($category) }})</small>
  </div>
  <div class="card-body">
    <form action="{{ route("materials.transactions.{$type}.store", ['category'=>$category]) }}"
          method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row gx-3 gy-2">
        <div class="col-md-6">
          <label class="form-label">Material</label>
          <select name="MaterialId" class="form-select" required>
            <option value="">-- selecione --</option>
            @foreach($materials as $m)
              <option value="{{ $m->id }}">
                {{ $m->Name }} (Estoque: {{ $m->CurrentStock }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Data</label>
          <input type="date" name="TransactionDate" class="form-control"
                 value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="col-md-3">
          <label class="form-label">Quantidade</label>
          <input type="number" name="Quantity" class="form-control" min="1" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Identificador do Fornecedor (B.I ou NIF)</label>
          @if($type=='in')
            <input type="text" class="form-control">
          @else
            <input type="text" class="form-control">
          @endif
        </div>

        <div class="col-md-6">
          <label class="form-label">Documentação (opcional)</label>
          <input type="file" name="Documentation" class="form-control">
        </div>

        <div class="col-12">
          <label class="form-label">Observações (opcional)</label>
          <textarea name="Notes" class="form-control" rows="2"></textarea>
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle me-1"></i>
          {{ $type=='in' ? 'Confirmar Entrada' : 'Confirmar Saída' }}
        </button>
        <a href="{{ route('materials.transactions.index',['category'=>$category]) }}"
           class="btn btn-secondary ms-2">Cancelar</a>
      </div>
    </form>
  </div>
</div>

@endsection
