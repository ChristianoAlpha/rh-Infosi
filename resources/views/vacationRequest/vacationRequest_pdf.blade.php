@extends('layouts.pdf')

@section('pdfTitle', 'Relatório de Pedidos de Férias')

@section('titleSection')
  <h4>Relatório de Pedidos de Férias</h4>
  <p style="text-align: center;">
    <strong>Total de Pedidos:</strong> <ins>{{ $allVacationRequests->count() }}</ins>
  </p>
@endsection

@section('contentTable')
  @if($allVacationRequests->count())
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Funcionário</th>
          <th>Departamento</th>
          <th>Tipo de Férias</th>
          <th>Data de Início</th>
          <th>Data de Fim</th>
          <th>Data de Registro</th>
        </tr>
      </thead>
      <tbody>
        @foreach($allVacationRequests as $vr)
          <tr>
            <td>{{ $vr->id }}</td>
            <td>{{ $vr->employee->fullName ?? '-' }}</td>
            <td>{{ $vr->department->title ?? '-' }}</td>
            <td>{{ $vr->vacationType }}</td>
            <td>{{ \Carbon\Carbon::parse($vr->vacationStart)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($vr->vacationEnd)->format('d/m/Y') }}</td>
            <td>{{ $vr->created_at->format('d/m/Y H:i') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">Nenhum pedido de férias registrado.</p>
  @endif
@endsection
