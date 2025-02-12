@extends('layout')
@section('title', 'Funcionarios')
@section('content')


<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
       Todos os Funcionarios
        <a href="{{asset('employeee/create')}}" class="float-end btn btn-sm btn-info">Add New (add novo)</a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Departamento</th>
                    <th>Nome Completo</th>
                    <th>Endereço</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Departamento</th>
                    <th>Nome Completo</th>
                    <th>Endereço</th>
                    
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @if ($data)
                    @foreach($data as $d)
                    
                    <tr>
                        <td>{{$d->id}}</td>
                        <td>{{$d->department->title}}</td>
                        <td>{{$d->fullName}}</td>
                        <td>{{$d->address}}</td>
                        <td>
                            <a href="{{asset('depart/' .$d->id)}}" class="btn btn-warning btn-sm">Show</a>
                            <a href="{{asset('depart/' .$d->id.'/edit')}}" class="btn btn-info btn-sm">Editar</a>
                            <a onclick="return confirm('Tens a certeza em Apagar esse Departamento?')" href="{{asset('depart/' .$d->id.'/delete')}}" class="btn btn-danger btn-sm">Apagar</a>
                        </td>
                        
                    </tr>
                    @endforeach
               @endif
            </tbody>
        </table>
    </div>
</div>





@endsection
