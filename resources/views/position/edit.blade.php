{{--UPDATE--}}
@extends('layout')
@section('title', 'Editar Cargo')
@section('content')

<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Editar Cargo
        <a href="{{ route('positions') }}" class="float-end btn btn-sm btn-info">Ver Todos</a>
    </div>  
    <div class="card-body">
        @if ($errors->any())
            @foreach($errors->all() as $error)
            <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif

        @if(Session::has('msg'))
            <p class="text-success">{{ session('msg') }}</p>
        @endif

        <form method="POST" action="{{ route('positions.update', $data->id) }}">
            @method('put')
            @csrf
            <table class="table table-bordered">
                <tr>
                    <th>Nome do Cargo</th>
                    <td>
                        <input type="text" value="{{ $data->name }}" name="name" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Descrição</th>
                    <td>
                        <textarea name="description" class="form-control" rows="3">{{ $data->description }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

@endsection