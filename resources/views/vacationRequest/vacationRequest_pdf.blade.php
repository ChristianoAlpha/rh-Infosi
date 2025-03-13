@extends('layouts.pdf')

@section('pdfTitle', 'Relatório de Pedidos de Férias')

@section('titleSection')
  <h4>Relatório de Pedidos de Férias</h4>
  <p style="text-align: center;">
    <strong>Total de Pedidos:</strong> <ins>{{ $allRequests->count() }}</ins>
  </p>
@endsection

@section('contentTable')
  @if($allRequests->count())
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Funcionário</th>
          <th>Tipo de Férias</th>
          <th>Data de Início</th>
          <th>Data de Fim</th>
          <th>Documento de Suporte</th>
          <th>Razão</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($allRequests as $vr)
          <tr>
            <td>{{ $vr->id }}</td>
            <td>{{ $vr->employee->fullName ?? '-' }}</td>
            <td>{{ $vr->vacationType }}</td>
            <td>{{ \Carbon\Carbon::parse($vr->vacationStart)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($vr->vacationEnd)->format('d/m/Y') }}</td>
            <td>
              @if($vr->supportDocument)
                {{ $vr->originalFileName }}
              @else
                -
              @endif
            </td>
            <td>{{ $vr->reason ?? '-' }}</td>
            <!-- Exibir status -->
            <td>
              @if($vr->approvalStatus == 'Aprovado')
                <span class="badge bg-success">Aprovado</span>
              @elseif($vr->approvalStatus == 'Pendente')
                <span class="badge bg-warning">Pendente</span>
              @elseif($vr->approvalStatus == 'Recusado')
                <span class="badge bg-danger">Recusado</span>
              @else
                <span>{{ $vr->approvalStatus }}</span>
              @endif
            </td>
            
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">Nenhum pedido de férias registrado.</p>
  @endif
@endsection
