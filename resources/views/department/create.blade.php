@extends('layout')
@section('title', 'Departments (Departamentos)')
@section('content')


<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Lista de Departamentos
        <!--link que vai para a view index a onde estão listados todos os departamentos pertencente a rota depart-->

        <a href="{{asset('depart')}}" class="float-end btn btn-sm btn-info">Ver todos</a>
    </div>  
    <div class="card-body">
        <!-- Mensagem de erro caso não se submeta corretamente um departamento novo -->
        @if ($errors->any())
            @foreach($errors->all() as $error)
            <p class="text-danger"> {{($error)}} </p>
            @endforeach
            
        @endif

        @if (Session::has('msg'))

         <p class="text-success"> {{session('msg')}} </p>
            
        @endif

        <form method="POST" action="{{asset('depart')}}"> 
            @csrf
            <table class="table table-bordered">
                <tr>
                    <th>Title</th>
                    <td>
                        <input type="text" name="title" class="form-control">
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