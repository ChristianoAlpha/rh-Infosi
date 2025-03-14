@extends('layouts.layout')
@section('title', 'Lista de Pedidos de Licença')
@section('content')

<div class="card mb-4 mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-file-alt me-2"></i>Lista de Pedidos de Licença</span>
    <div>
   
      <a href="{{ route('leaveRequest.pdfAll') }}" class="btn btn-outline-light btn-sm me-2" title="Baixar PDF">
        <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
      </a>
      <a href="{{ route('leaveRequest.create') }}" class="btn btn-outline-light btn-sm" title="Novo Pedido de Licença">
        Novo <i class="bi bi-plus-circle"></i>
      </a>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Funcionário</th>
            <th>Departamento</th>
            <th>Tipo de Licença</th>
            <th>Razão</th>
            <th>Data de Registro</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $lr)
          <tr>
            <td>{{ $lr->id }}</td>
            <td>{{ $lr->employee->fullName ?? '-' }}</td>
            <td>{{ $lr->department->title ?? '-' }}</td>
            <td>{{ $lr->leaveType->name ?? '-' }}</td>
            <td>{{ $lr->reason ?? '-' }}</td>
            <td>{{ $lr->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center">Nenhum pedido de licença registrado.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
