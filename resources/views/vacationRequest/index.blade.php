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
      <table class="table table-striped table-hover table-bordered" >
        <thead>
          <tr>
            <th>ID</th>
            <th>Funcionário</th>
            <th>Tipo de Férias</th>
            <th>Razão</th>
            <th>Data de Início</th>
            <th>Data de Fim</th>
            <th>Documento</th>
            <th>Data de Registro</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $vr)
          <tr>
            <td>{{ $vr->id }}</td>
            <td>{{ $vr->employee->fullName ?? '-' }}</td>
            <td>{{ $vr->vacationType }}</td>
            <td>{{ $vr->reason }}</td>
            <td>{{ \Carbon\Carbon::parse($vr->vacationStart)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($vr->vacationEnd)->format('d/m/Y') }}</td>
            <td>
              @if($vr->supportDocument)
                <a href="{{ Storage::url($vr->supportDocument) }}" target="_blank">
                  {{ $vr->originalFileName ?? 'Documento' }}
                </a>
              @else
                -
              @endif
            </td>
            <td>{{ $vr->created_at->format('d/m/Y H:i') }}</td>
            <td>
              <!-- Botão para visualizar (show) -->
              <a href="{{ route('vacationRequest.show', $vr->id) }}" class="btn btn-warning btn-sm" title="Ver Detalhes">
                <i class="bi bi-eye"></i>
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center">Nenhum pedido de férias registrado.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
