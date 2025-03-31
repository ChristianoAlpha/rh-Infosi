@extends('layouts.admin.layout')
@section('title', 'Pedidos de Licença')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-file-alt me-2"></i>Lista de Pedidos de Licença</span>
    <div>
      <a href="{{ route('leaveRequest.pdfAll') }}" class="btn btn-outline-light btn-sm" title="Baixar PDF">
        <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
      </a>      
      <a href="{{ route('leaveRequest.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo Pedido">
        <i class="bi bi-plus-circle"></i> Novo Pedido
      </a>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Funcionário</th>
            <th>Tipo de Licença</th>
            <th>Departamento</th>
            <th>Data de Início</th>
            <th>Data de Término</th>
            <th>Razão</th>
            <th>Status</th>
            <th>Comentário</th>
            <th>Criado em</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $lr)
          <tr>
            <td>{{ $lr->employee->fullName ?? '-' }}</td>
            <td>{{ $lr->leaveType->name ?? '-' }}</td>
            <td>{{ $lr->department->title ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($lr->leaveStart)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($lr->leaveEnd)->format('d/m/Y') }}</td>
            <td>{{ $lr->reason ?? '-' }}</td>
            <td>
              @if($lr->approvalStatus == 'Aprovado')
                <span class="badge bg-success">Aprovado</span>
              @elseif($lr->approvalStatus == 'Recusado')
                <span class="badge bg-danger">Recusado</span>
              @else
                <span class="badge bg-warning">Pendente</span>
              @endif
            </td>
            <td>{{ $lr->approvalComment ?? '-' }}</td>
            <td>{{ $lr->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center">Nenhum pedido de licença listado.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
