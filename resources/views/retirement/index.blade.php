@extends('layouts.layout')
@section('title', 'Pedidos de Reforma')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-user-check me-2"></i>Lista de Pedidos de Reforma</span>
    <div>
      <a href="{{ route('retirements.pdf') }}" class="btn btn-outline-light btn-sm" title="Baixar PDF">
        <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
      </a>
      <a href="{{ route('retirements.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo Pedido">
        <i class="bi bi-plus-circle"></i> Novo Pedido
      </a>
    </div>
  </div>
  <div class="card-body">
    @if($retirements->count())
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Funcionário</th>
              <th>Data do Pedido</th>
              <th>Data de Reforma</th>
              <th>Status</th>
              <th>Observações</th>
              <th>Criado em</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($retirements as $retirement)
              <tr>
                <td>{{ $retirement->employee->fullName ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($retirement->requestDate)->format('d/m/Y') }}</td>
                <td>{{ $retirement->retirementDate ? \Carbon\Carbon::parse($retirement->retirementDate)->format('d/m/Y') : '-' }}</td>
                <td>{{ $retirement->status }}</td>
                <td>{{ $retirement->observations ?? '-' }}</td>
                <td>{{ $retirement->created_at->format('d/m/Y H:i') }}</td>
                <td>
                  <a href="{{ route('retirements.show', $retirement->id) }}" class="btn btn-warning btn-sm" title="Visualizar">
                    <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('retirements.edit', $retirement->id) }}" class="btn btn-info btn-sm" title="Editar">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('retirements.destroy', $retirement->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Deletar">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p>Nenhum pedido de reforma registrado.</p>
    @endif
  </div>
</div>
@endsection
