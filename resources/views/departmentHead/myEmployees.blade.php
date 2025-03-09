@extends('layouts.layout')
@section('title', 'Meus Funcionários')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">
    <h4>Meus Funcionários</h4>
  </div>
  <div class="card-body">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Departamento</th>
          <th>Cargo</th>
        </tr>
      </thead>
      <tbody>
        @forelse($employees as $emp)
          <tr>
            <td>{{ $emp->id }}</td>
            <td>{{ $emp->fullName }}</td>
            <td>{{ $emp->department->title ?? '-' }}</td>
            <td>{{ $emp->position->name ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4">Nenhum funcionário encontrado.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
