@extends('layout')
@section('title', 'Funcionários')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-people-fill me-2"></i>Todos os Funcionários</span>
    <a href="{{ route('employeee.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo">
      <i class="bi bi-plus-circle"></i>
    </a>
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
                  <a href="{{ route('employeee.show', $d->id) }}" class="btn btn-warning btn-sm" title="Visualizar">
                    <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('employeee.edit', $d->id) }}" class="btn btn-info btn-sm" title="Editar">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <a onclick="return confirm('Tens a certeza em Apagar esse Funcionário?')" href="{{ url('employeee/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm" title="Apagar">
                    <i class="bi bi-trash"></i>
                  </a>
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
