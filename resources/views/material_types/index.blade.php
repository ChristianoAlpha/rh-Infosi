@extends('layouts.admin.layout')
@section('title','Tipos de Material')

@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between">
    <span><i class="fas fa-tags me-2"></i>Lista de Tipos de Material</span>
    <a href="{{ route('material-types.create') }}" class="btn btn-outline-light btn-sm">
      <i class="fas fa-plus-circle me-1"></i> Novo Tipo
    </a>
  </div>
  <div class="card-body">
    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($types as $t)
          <tr>
            <td>{{ $t->name }}</td>
            <td>{{ $t->description ?? '—' }}</td>
            <td>
                {{-- Visualizar --}}
                <a href="{{ route('material-types.show', $t->id) }}"
                   class="btn btn-sm btn-info"
                   title="Visualizar">
                  <i class="bi bi-eye"></i>
                </a>
              
                {{-- Editar --}}
                <a href="{{ route('material-types.edit', $t->id) }}"
                   class="btn btn-sm btn-warning"
                   title="Editar">
                  <i class="bi bi-pencil"></i>
                </a>
              
                {{-- Apagar (link, dispara modal global) --}}
                <a href="#"
                   data-url="{{ url('material-types/'.$t->id.'/delete') }}"
                   class="btn btn-sm btn-danger delete-btn"
                   title="Apagar">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center">Nenhum tipo cadastrado.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

