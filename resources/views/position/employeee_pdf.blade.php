@extends('layouts.pdf')

@section('pdfTitle', 'Relatório por Cargo')

@section('titleSection')
<h4>Relatório dos Funcionários com o cargo de: {{ $position->name }}</h4>
<p style="text-align: center;">
  <strong>Total de Funcionários:</strong> <ins>{{ $position->employeee->count() }}</ins>
</p>
@endsection

@section('contentTable')
@if($position->employeee && $position->employeee->count())
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome Completo</th>
        <th>Email</th>
        <th>Especialidade</th>
      </tr>
    </thead>
    <tbody>
      @foreach($position->employeee as $emp)
        <tr>
          <td>{{ $emp->id }}</td>
          <td>{{ $emp->fullName }}</td>
          <td>{{ $emp->email }}</td>
          <td>{{ $emp->specialty->name ?? '-' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@else
  <p style="text-align:center;">Não há funcionários com este Cargo.</p>
@endif
@endsection
