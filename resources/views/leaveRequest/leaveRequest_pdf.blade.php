@extends('layouts.pdf')

@section('pdfTitle', 'Relatório de Pedidos de Licença')

@section('titleSection')
  <h4>Relatório de Pedidos de Licença</h4>
  <p style="text-align: center;">
    <strong>Total de Pedidos:</strong> <ins>{{ $allLeaveRequests->count() }}</ins>
  </p>
@endsection

@section('contentTable')
  @if($allLeaveRequests->count())
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Funcionário</th>
          <th>Departamento</th>
          <th>Tipo de Licença</th>
          <th>Razão</th>
          <th>Data de Registro</th>
        </tr>
      </thead>
      <tbody>
        @foreach($allLeaveRequests as $leaveRequest)
          <tr>
            <td>{{ $leaveRequest->id }}</td>
            <td>{{ $leaveRequest->employee->fullName ?? '-' }}</td>
            <td>{{ $leaveRequest->department->title ?? '-' }}</td>
            <td>{{ $leaveRequest->leaveType->name ?? '-' }}</td>
            <td>{{ $leaveRequest->reason ?? '-' }}</td>
            <td>{{ $leaveRequest->created_at->format('d/m/Y H:i') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">Nenhum pedido de licença registrado.</p>
  @endif
@endsection
