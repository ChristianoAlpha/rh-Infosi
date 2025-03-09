@extends('layouts.layout')
@section('title', 'Pedidos de Férias Pendentes')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Pedidos de Férias Pendentes</h4>
  </div>
  <div class="card-body">
    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Funcionário</th>
          <th>Data Início</th>
          <th>Data Fim</th>
          <th>Tipo</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pendingRequests as $req)
          <tr>
            <td>{{ $req->id }}</td>
            <td>{{ $req->employee->fullName ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($req->vacationStart)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($req->vacationEnd)->format('d/m/Y') }}</td>
            <td>{{ $req->vacationType }}</td>
            <td>{{ $req->status }}</td>
            <td>
              <!-- Botão de Aprovar -->
              <form action="{{ route('dh.approveVacation', $req->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">
                  <i class="bi bi-check-circle"></i> Aprovar
                </button>
              </form>
              <!-- Botão de Rejeitar -->
              <form action="{{ route('dh.rejectVacation', $req->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                  <i class="bi bi-x-circle"></i> Rejeitar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7">Nenhum pedido de férias pendente.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
