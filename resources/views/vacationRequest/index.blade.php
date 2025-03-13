@extends('layouts.layout')
@section('title', 'Pedidos de Férias')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-umbrella-beach me-2"></i>Lista de Pedidos de Férias</span>
    <div>
      <a href="{{ route('vacationRequest.pdfAll') }}" class="btn btn-outline-light btn-sm" title="Baixar PDF">
        <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
      </a>
      <a href="{{ route('vacationRequest.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo">
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
            <th>Tipo de Férias</th>
            <th>Data Início</th>
            <th>Data Fim</th>
            <th>Documento</th>
            <th>Razão</th>
            <th>Status</th>
            <th>Comentário</th>
            <th>Criado em</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $vr)
            <tr>
              <td>{{ $vr->employee->fullName }}</td>
              <td>{{ $vr->vacationType }}</td>
              <td>{{ \Carbon\Carbon::parse($vr->vacationStart)->format('d/m/Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($vr->vacationEnd)->format('d/m/Y') }}</td>
              <td>
                @if($vr->supportDocument)
                  <a href="{{ asset('storage/'.$vr->supportDocument) }}" target="_blank">
                    {{ $vr->originalFileName ?? 'Ver Documento' }}
                  </a>
                @else
                  -
                @endif
              </td>
              <td>{{ $vr->reason ?? '-' }}</td>
              <td>
                @if($vr->approvalStatus == 'Aprovado')
                  <span class="badge bg-success fs-6">Aprovado</span>
                @elseif($vr->approvalStatus == 'Pendente')
                  <span class="badge bg-warning fs-6">Pendente</span>
                @elseif($vr->approvalStatus == 'Recusado')
                  <span class="badge bg-danger fs-6">Recusado</span>
                @else
                  <span>{{ $vr->approvalStatus }}</span>
                @endif
              </td>
              <td>{{ $vr->approvalComment ?? '-' }}</td>
              <td>{{ \Carbon\Carbon::parse($vr->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
