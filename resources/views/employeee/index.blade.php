@extends('layout')
@section('title', 'Funcionarios')
@section('content')

<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Todos os Funcionarios
        <a href="{{ asset('employeee/create') }}" class="float-end btn btn-sm btn-info">Add Novo</a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>Departamento</th>
                    <th>Cargo</th>
                    <th>Especialidade</th>
                    <th>Endereço</th>
                    <th>Action</th>
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
                    <th>Action</th>
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
                                <a onclick="return confirm('Tens a certeza em Apagar esse Funcionario?')" href="{{ asset('employeee/' . $d->id . '/delete') }}" class="btn btn-danger btn-sm">Apagar</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
