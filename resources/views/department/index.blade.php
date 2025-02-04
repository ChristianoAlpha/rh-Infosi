@extends('layout')
@section('title', 'Departments (Departamentos)')
@section('content')


<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Department List (Lista de Departamentos)
        <a href="{{asset('depart/create')}}" class="float-end">Add New (add novo)</a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                </tr>
            </tfoot>
            <tbody>
                @if ($data)
                    @foreach($data as $d)
                    
                    <tr>
                        <td>{{$d->id}}</td>
                        <td>{{$d->title}}</td>
                        
                    </tr>
                    @endforeach
               @endif
            </tbody>
        </table>
    </div>
</div>





@endsection
