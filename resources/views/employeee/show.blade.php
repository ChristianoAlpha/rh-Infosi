{{--SHOW--}}
@extends('layout')
@section('title', 'Ver Funcionário')
@section('content')

<div class="card mb-4 mt-4">
  <div class="card-header">
    <i class="fas fa-table me-1"></i>
    Ver Funcionário
    <a href="{{ asset('employeee') }}" class="float-end btn btn-sm btn-success">Ver Todos</a>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th>Departamento</th>
        <td>{{ $data->department->title ?? $data->departmentId }}</td>
      </tr>
      <tr>
        <th>Cargo</th>
        <td>{{ $data->position->name ?? $data->position_id }}</td>
      </tr>
      <tr>
        <th>Especialidade</th>
        <td>{{ $data->specialty->name ?? $data->specialty_id }}</td>
      </tr>
      <tr>
        <th>Nome Completo</th>
        <td>{{ $data->fullName }}</td>
      </tr>
      <tr>
        <th>Endereço</th>
        <td>{{ $data->address }}</td>
      </tr>
      <tr>
        <th>Telefone</th>
        <td>{{ $data->mobile }}</td>
      </tr>
      <tr>
        <th>Nome do Pai</th>
        <td>{{ $data->father_name }}</td>
      </tr>
      <tr>
        <th>Nome da Mãe</th>
        <td>{{ $data->mother_name }}</td>
      </tr>
      <tr>
        <th>Bilhete de Identidade</th>
        <td>{{ $data->bi }}</td>
      </tr>
      <tr>
        <th>Data de Nascimento</th>
        <td>{{ $data->birth_date }}</td>
      </tr>
      <tr>
        <th>Nacionalidade</th>
        <td>{{ $data->nationality }}</td>
      </tr>
      <tr>
        <th>Gênero</th>
        <td>{{ $data->gender }}</td>
      </tr>
      <tr>
        <th>Email</th>
        <td>{{ $data->email }}</td>
      </tr>
    </table>
  </div>
</div>

@endsection
