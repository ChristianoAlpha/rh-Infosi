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
        <th>Funcionário identificado no sistema pelo ID Nº</th>
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

      <tr>
        <th>Telefone</th>
        <td>
          @if($employee->phone_code)
            {{ $employee->phone_code }} 
          @endif
          {{ $employee->mobile }}
        </td>
      </tr>
              
      <tr>
        <th>Nome do Pai</th>
        <td>{{ $employee->fatherName }}</td>
      </tr>
      <tr>
        <th>Nome da Mãe</th>
        <td>{{ $employee->motherName }}</td>
      </tr>
      <tr>
        <th>Bilhete de Identidade</th>
        <td>{{ $employee->bi }}</td>
      </tr>
      <tr>
        <th>Data de Nascimento</th>
        <td>{{ \Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y') }}</td>
      </tr>
      <tr>
        <th>Nacionalidade</th>
        <td>{{ $employee->nationality }}</td>
      </tr>
      <tr>
        <th>Gênero</th>
        <td>{{ $employee->gender }}</td>
      </tr>
      
    </table>
  </div>
</div>

@endsection
