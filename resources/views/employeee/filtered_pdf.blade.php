@extends('layouts.pdf')

@section('pdfTitle', 'Relatório de Funcionários Filtrados')

@section('titleSection')
  <h4>Relatório de Funcionários Filtrados</h4>
  <p style="text-align: center;">
    <strong>Período:</strong> {{ $startDate }} a {{ $endDate }} <br>
    <hr>
    <strong>Total de Funcionários:</strong> <ins>{{ $filtered->count() }}</ins><br>
  </p>
@endsection

@section('contentTable')
  @if($filtered->count())
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome Completo</th>
          <th>Departamento</th>
          <th>Tipo de Funcionario</th>
          <th>Cargo</th>
          <th>Especialidade</th>
          <th>Data de Registro</th>
        </tr>
      </thead>
      <tbody>
        @foreach($filtered as $emp)
          <tr>
            <td>{{ $emp->id }}</td>
            <td>{{ $emp->fullName }}</td>
            <td>{{ $emp->department->title ?? '-' }}</td>
            <td>{{ $emp->employeeType->name ?? '-' }}</td>
            <td>{{ $emp->position->name ?? '-' }}</td>
            <td>{{ $emp->specialty->name ?? '-' }}</td>
            <td>{{ $emp->created_at->format('d/m/Y H:i') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">Nenhum funcionário encontrado neste período.</p>
  @endif
@endsection
