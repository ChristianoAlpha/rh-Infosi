@extends('layouts.admin.layout')
@section('title', 'Ver Tipo de Material')

@section('content')
<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-eye me-2"></i>Ver Tipo de Material</span>
    <div>
      <a href="{{ route('material-types.index') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-card-list"></i></a>
      <a href="{{ route('material-types.edit', $type->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
      <a href="#" data-url="{{ route('material-types.destroy', $type->id) }}" class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash"></i></a>
    </div>
  </div>
  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <table class="table table-striped table-bordered mb-0">
          <tr><th>Nome</th><td>{{ $type->name }}</td></tr>
          <tr><th>Descrição</th><td>{{ $type->description ?? '—' }}</td></tr>
          <tr><th>Criado em</th><td>{{ $type->created_at->format('d/m/Y') }}</td></tr>
          <tr><th>Última atualização</th><td>{{ $type->updated_at->format('d/m/Y') }}</td></tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
