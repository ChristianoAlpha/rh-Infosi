@extends('layouts.admin.layout')
@section('title','Histórico — '.ucfirst($category))
@section('content')
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between">
    <span><i class="bi bi-clock-history me-2"></i>Histórico — {{ ucfirst($category) }}</span>
    <div>
      <a href="{{ route('materials.transactions.report-in',['category'=>$category]) }}"
         class="btn btn-sm btn-outline-light">
        <i class="bi bi-file-earmark-pdf"></i> PDF Entradas
      </a>
      <a href="{{ route('materials.transactions.report-out',['category'=>$category]) }}"
         class="btn btn-sm btn-outline-light">
        <i class="bi bi-file-earmark-pdf"></i> PDF Saídas
      </a>
      <a href="{{ route('materials.transactions.report-all',['category'=>$category]) }}"
         class="btn btn-sm btn-outline-light">
        <i class="bi bi-file-earmark-pdf"></i> PDF Total
      </a>
    </div>
  </div>
  <div class="card-body">
    <form class="row g-3 mb-3" method="GET" action="">
      <div class="col-md-3">
        <input type="date" name="startDate" class="form-control"
               value="{{ request('startDate') }}" placeholder="Início">
      </div>
      <div class="col-md-3">
        <input type="date" name="endDate" class="form-control"
               value="{{ request('endDate') }}" placeholder="Fim">
      </div>
      <div class="col-md-3">
        <select name="type" class="form-select">
          <option value="">Todos</option>
          <option value="in"  {{ request('type')=='in'?'selected':'' }}>Entrada</option>
          <option value="out" {{ request('type')=='out'?'selected':'' }}>Saída</option>
        </select>
      </div>
      <div class="col-md-3 d-grid">
        <button class="btn btn-primary">
          <i class="bi bi-filter"></i> Filtrar
        </button>
      </div>
    </form>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Material</th>
          <th>Qtde</th>
          <th>Data</th>
          <th>Origem/Dest.</th>
          <th>Usuário</th>
        </tr>
      </thead>
      <tbody>
        @forelse($txs as $t)
        <tr>
          <td>{{ $t->TransactionType=='in'?'Entrada':'Saída' }}</td>
          <td>{{ $t->material->Name }}</td>
          <td>{{ $t->Quantity }}</td>
          <td>{{ \Carbon\Carbon::parse($t->TransactionDate)->format('d/m/Y') }}</td>
          <td>{{ $t->OriginOrDestination }}</td>
          <td>{{ $t->creator->fullName }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center">Nenhuma transação.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
