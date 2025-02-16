{{--SHOW--}}
@extends('layout')
@section('title', 'Detalhes do Cargo')
@section('content')

<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Detalhes do Cargo
        <a href="{{ asset('positions') }}" class="float-end btn btn-sm btn-success">Voltar</a>
    </div>  
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Nome</th>
                <td>{{ $data->name }}</td>
            </tr>
            <tr>
                <th>Descrição</th>
                <td>{{ $data->description ?? '-' }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection