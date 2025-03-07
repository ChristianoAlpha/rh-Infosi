@extends('layouts.layout')
@section('title', 'Pedidos de Férias Pendentes')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-umbrella-beach me-2"></i>Pedidos de Férias Pendentes</span>
    <a href="{{ route('employeee.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
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
            <th>Tipo de Férias</th>
            <th>Data de Início</th>
            <th>Data de Fim</th>
            <th>Razão</th>
            <th>Status</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
          @forelse($requests as $req)
            <tr>
              <td>{{ $req->id }}</td>
              <td>{{ $req->employee->fullName ?? '-' }}</td>
              <td>{{ $req->vacationType }}</td>
              <td>{{ \Carbon\Carbon::parse($req->vacationStart)->format('d/m/Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($req->vacationEnd)->format('d/m/Y') }}</td>
              <td>{{ $req->reason ?? '-' }}</td>
              <td>{{ $req->status }}</td>
              <td>
                <form action="{{ route('departmentHead.updateVacationRequestStatus', $req->id) }}" method="POST" style="display: inline;">
                  @csrf
                  @method('PUT')
                  <select name="status" onchange="this.form.submit()">
                    <option value="Pendente" {{ $req->status == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="Aprovado" {{ $req->status == 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
                    <option value="Recusado" {{ $req->status == 'Recusado' ? 'selected' : '' }}>Recusado</option>
                  </select>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center">Nenhum pedido pendente.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
