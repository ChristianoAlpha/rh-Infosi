@extends('layout')
@section('title', 'Lista de Especialidades')
@section('content')

<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Todas as Especialidades
        <a href="{{ asset('specialties/create') }}" class="float-end btn btn-sm btn-info">Nova Especialidade</a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
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
                        <a href="{{ asset('specialties', $d->id) }}" class="btn btn-warning btn-sm">Ver</a>
                        <a href="{{ asset('specialties/', $d->id. '/edit') }}" class="btn btn-info btn-sm">Editar</a>
                        <a onclick="return confirm('Apagar esta especialidade?')" href="{{ asset('specialties/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm">Apagar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection