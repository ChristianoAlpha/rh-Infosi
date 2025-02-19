@extends('layout')
@section('title', 'Lista de Especialidades')
@section('content')

<div class="card mb-4 mt-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-card-list me-2"></i>Todas as Especialidades</span>
    <a href="{{ route('specialties.create') }}" class="btn btn-outline-light btn-sm" title="Nova Especialidade">
      <i class="bi bi-plus-circle"></i>
    </a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="datatablesSimple" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $d)
          <tr>
            <td>{{ $d->id }}</td>
            <td>{{ $d->name }}</td>
            <td>{{ $d->description ?? '-' }}</td>
            <td>
              <a href="{{ route('specialties.show', $d->id) }}" class="btn btn-warning btn-sm" title="Visualizar">
                <i class="bi bi-eye"></i>
              </a>
              <a href="{{ route('specialties.edit', $d->id) }}" class="btn btn-info btn-sm" title="Editar">
                <i class="bi bi-pencil"></i>
              </a>
              <a onclick="return confirm('Apagar esta especialidade?')" href="{{ url('specialties/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm" title="Apagar">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
