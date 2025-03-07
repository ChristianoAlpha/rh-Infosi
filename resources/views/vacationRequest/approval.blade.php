@extends('layouts.layout')
@section('title', 'Aprovar Pedidos de Férias')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-umbrella-beach me-2"></i>Pedidos de Férias para Aprovação</span>
    <a href="{{ route('vacationRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    @if($data->count() > 0)
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Funcionário</th>
              <th>Tipo de Férias</th>
              <th>Data de Início</th>
              <th>Data de Fim</th>
              <th>Status Atual</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $vr)
              <tr>
                <td>{{ $vr->id }}</td>
                <td>{{ $vr->employee->fullName ?? '-' }}</td>
                <td>{{ $vr->vacationType }}</td>
                <td>{{ \Carbon\Carbon::parse($vr->vacationStart)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($vr->vacationEnd)->format('d/m/Y') }}</td>
                <td>{{ $vr->approvalStatus }}</td>
                <td>
                  <!-- Formulário inline para atualizar status -->
                  <form action="{{ route('vacationRequest.updateApproval', $vr->id) }}" method="POST" class="d-flex">
                    @csrf
                    <select name="approvalStatus" class="form-select form-select-sm me-2" required>
                      <option value="Pendente" @if($vr->approvalStatus == 'Pendente') selected @endif>Pendente</option>
                      <option value="Aprovado" @if($vr->approvalStatus == 'Aprovado') selected @endif>Aprovado</option>
                      <option value="Recusado" @if($vr->approvalStatus == 'Recusado') selected @endif>Recusado</option>
                    </select>
                    <input type="text" name="approvalComment" class="form-control form-control-sm me-2" placeholder="Comentário" value="{{ $vr->approvalComment }}">
                    <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
     <p class="text-center">Nenhum pedido de férias para aprovação.</p> 
    @endif
  </div>
</div>

@endsection
