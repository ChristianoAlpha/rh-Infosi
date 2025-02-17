{{--SHOW--}}
@extends('layout')
@section('title', 'Ver Especialidade')
@section('content')

<div class="card mb-4 mt-4">
  <div class="card-header">
    <i class="fas fa-table me-1"></i>
    Ver Especialidade
    <a href="{{ asset('specialties') }}" class="float-end btn btn-sm btn-success">Ver Todos</a>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th>Nome da Especialidade</th>
        <td>{{ $data->name }}</td>
      </tr>
      <tr>
        <th>Descrição</th>
        <td>{{ $data->description }}</td>
      </tr>
    </table>
  </div>
</div>

@endsection

