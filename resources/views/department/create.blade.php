@extends('layout')
@section('title', 'Departments (Departamentos)')
@section('content')


<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Department List (Lista de Departamentos)
        <a href="{{asset('depart')}}" class="float-end">View All</a>
    </div>
    <div class="card-body">
        <form method="POST" action=""> 
            @csrf
            <table class="table table-bordered">
                <tr>
                    <th>Title</th>
                    <td>
                        <input type="text" name="title" class="form-control">
                    </td>
                </tr>
            </table>
    
    </form>
       
    </div>
</div>





@endsection