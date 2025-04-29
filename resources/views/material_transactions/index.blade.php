@extends('layouts.admin.layout')
@section('title', 'Histórico de Movimentações')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-history me-2"></i> Histórico ({{ ucfirst($category) }})</span>
    <div>
      <a href="{{ route('materials.transactions.report-all',['category'=>$category]) }}"
         class="btn btn-outline-light btn-sm">
        <i class="bi bi-file-earmark-pdf"></i> PDF Completo
      </a>
      @if(request()->filled('startDate') || request()->filled('endDate') || request()->filled('type'))
      <a href="{{ url()->current() }}?{{ http_build_query(request()->only(['startDate','endDate','type'])) }}"
         class="btn btn-outline-light btn-sm">
        <i class="bi bi-file-earmark-pdf"></i> PDF Filtrado
      </a>
      @endif
      <a href="{{ route('materials.transactions.report-in',['category'=>$category]) }}"
         class="btn btn-outline-light btn-sm">PDF Entradas</a>
      <a href="{{ route('materials.transactions.report-out',['category'=>$category]) }}"
         class="btn btn-outline-light btn-sm">PDF Saídas</a>
    </div>
  </div>

  <div class="card-body">
    <!-- filtros -->
    <form method="GET" action="{{ route('materials.transactions.index',['category'=>$category]) }}"
          class="row gx-3 gy-2 mb-4">
      <div class="col-md-3">
        <label class="form-label">Data Início</label>
        <input type="date" name="startDate" class="form-control"
               value="{{ request('startDate') }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">Data Fim</label>
        <input type="date" name="endDate" class="form-control"
               value="{{ request('endDate') }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">Tipo</label>
        <select name="type" class="form-select">
          <option value="">Todos</option>
          <option value="in"  {{ request('type')=='in'?'selected':'' }}>Entrada</option>
          <option value="out" {{ request('type')=='out'?'selected':'' }}>Saída</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filtrar</button>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th style="width:8%">Tipo</th>
            <th style="width:25%">Material</th>
            <th style="width:10%">Quantidade</th>
            <th style="width:12%">Data</th>
            <th style="width:20%">Origem / Destino</th>
            <th style="width:15%">Responsável</th>
            <th style="width:10%">Observações</th>
          </tr>
        </thead>
        <tbody>
          @forelse($txs as $t)
            <tr>
              <td>{{ $t->TransactionType=='in'?'Entrada':'Saída' }}</td>
              <td>{{ $t->material->Name }}</td>
              <td>{{ $t->Quantity }}</td>
              <td>{{ \Carbon\Carbon::parse($t->TransactionDate)->format('d/m/Y') }}</td>
              <td>
                {{ $t->TransactionType=='in'
                    ? $t->SupplierName 
                    : $t->department->title }}
              </td>
              <td>{{ $t->creator->fullName ?? $t->creator->name }}</td>
              <td>{{ $t->Notes }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center">Nenhuma movimentação encontrada.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
