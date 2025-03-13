@extends('layouts.layout')
@section('title', 'Meu Perfil')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">
    <h4 class="mb-0">Meu Perfil</h4>
  </div>
  <div class="card-body">
    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <table class="table table-bordered">
      <tr>
        <th>ID do Funcionário</th>
        <td>{{ $employee->id }}</td>
      </tr>
      <tr>
        <th>Nome Completo</th>
        <td>{{ $employee->fullName }}</td>
      </tr>
      <tr>
        <th>E-mail</th>
        <td>{{ $employee->email }}</td>
      </tr>
      <tr>
        <th>Departamento</th>
        <td>{{ $employee->department->title ?? '-' }}</td>
      </tr>
      <tr>
        <th>Cargo</th>
        <td>{{ $employee->position->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>Tipo de Funcionário</th>
        <td>{{ $employee->employeeType->name ?? '-' }}</td>
      </tr>
      <!-- Coloque outras informações que desejar -->
    </table>
  </div>
</div>

@endsection
