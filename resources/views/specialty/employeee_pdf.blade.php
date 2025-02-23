@extends('layouts.pdf')

@section('pdfTitle', 'Relatório por Especialidade')

@section('titleSection')
<h4>Relatório dos Funcionários com a especialidade de: {{ $specialty->name }}</h4>
<p style="text-align: center;">
  <strong>Total de Funcionários:</strong> <ins>{{ $specialty->employeee->count() }}</ins>
</p>
@endsection

@section('contentTable')
@if($specialty->employeee && $specialty->employeee->count())
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome Completo</th>
        <th>Email</th>
        <th>Cargo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($specialty->employeee as $emp)
        <tr>
          <td>{{ $emp->id }}</td>
          <td>{{ $emp->fullName }}</td>
          <td>{{ $emp->email }}</td>
          <td>{{ $emp->position->name ?? '-' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@else
  <p style="text-align:center;">Não há funcionários com esta Especialidade.</p>
@endif
@endsection
