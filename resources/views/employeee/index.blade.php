@extends('layout')
@section('title', 'Funcionários')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-table me-2"></i>Todos os Funcionários</span>
    <a href="{{ asset('employeee/create') }}" class="btn btn-outline-light btn-sm">Add Novo</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="datatablesSimple" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome Completo</th>
            <th>Departamento</th>
            <th>Cargo</th>
            <th>Especialidade</th>
            <th>Endereço</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>ID</th>
            <th>Nome Completo</th>
            <th>Departamento</th>
            <th>Cargo</th>
            <th>Especialidade</th>
            <th>Endereço</th>
            <th>Ações</th>
          </tr>
        </tfoot>
        <tbody>
          @if ($data)
            @foreach($data as $d)
              <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->fullName ?? 'Nome não definido' }}</td>
                <td>{{ $d->department->title ?? 'Departamento não encontrado' }}</td>
                <td>{{ $d->position->name ?? 'Cargo não encontrado' }}</td>
                <td>{{ $d->specialty->name ?? 'Especialidade não encontrada' }}</td>
                <td>{{ $d->address ?? 'Endereço não definido' }}</td>
                <td>
                  <a href="{{ asset('employeee/' . $d->id) }}" class="btn btn-warning btn-sm">Show</a>
                  <a href="{{ asset('employeee/' . $d->id . '/edit') }}" class="btn btn-info btn-sm">Editar</a>
                  <a onclick="return confirm('Tens a certeza em Apagar esse Funcionário?')" href="{{ asset('employeee/' . $d->id . '/delete') }}" class="btn btn-danger btn-sm">Apagar</a>
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
