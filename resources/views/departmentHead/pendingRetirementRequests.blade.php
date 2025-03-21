@extends('layouts.layout')
@section('title', 'Pedidos de Reforma Pendentes')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Pedidos de Reforma Pendentes</h4>
    <a href="{{ route('dh.myEmployees') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Funcionário</th>
            <th>Data do Pedido</th>
            <th>Data de Reforma</th>
            <th>Status</th>
            <th>Observações</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pendingRetirements as $req)
            <tr>
              <td>{{ $req->id }}</td>
              <td>{{ $req->employee->fullName ?? '-' }}</td>
              <td>{{ \Carbon\Carbon::parse($req->requestDate)->format('d/m/Y') }}</td>
              <td>{{ $req->retirementDate ? \Carbon\Carbon::parse($req->retirementDate)->format('d/m/Y') : '-' }}</td>
              <td>
                @if($req->status == 'Aprovado')
                  <span class="badge bg-success fs-6">Aprovado</span>
                @elseif($req->status == 'Recusado')
                  <span class="badge bg-danger fs-6">Recusado</span>
                @else
                  <span class="badge bg-warning fs-6">Pendente</span>
                @endif
              </td>
              <td>
                <textarea id="comment-{{ $req->id }}" class="form-control" rows="1" placeholder="Digite comentário"></textarea>
              </td>
              <td>
                <div class="d-flex flex-column flex-md-row">
                  <form action="{{ route('dh.approveRetirement', $req->id) }}" method="POST" class="me-md-2 mb-2 mb-md-0"
                        onsubmit="document.getElementById('hidden-approve-{{ $req->id }}').value = document.getElementById('comment-{{ $req->id }}').value">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="hidden-approve-{{ $req->id }}" name="approvalComment">
                    <button type="submit" class="btn btn-success btn-sm">
                      <i class="bi bi-check-circle"></i> Aprovar
                    </button>
                  </form>
                  <form action="{{ route('dh.rejectRetirement', $req->id) }}" method="POST"
                        onsubmit="document.getElementById('hidden-reject-{{ $req->id }}').value = document.getElementById('comment-{{ $req->id }}').value">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="hidden-reject-{{ $req->id }}" name="approvalComment">
                    <button type="submit" class="btn btn-danger btn-sm">
                      <i class="bi bi-x-circle"></i> Rejeitar
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center">Nenhum pedido de reforma pendente.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
