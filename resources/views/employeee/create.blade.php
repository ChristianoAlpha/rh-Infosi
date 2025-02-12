@extends('layout')
@section('title', 'Adicionar Funcionarios')
@section('content')


<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Criar Funcionarios
        <!--link que vai para a view index a onde estão listados todos os departamentos pertencente a rota depart-->

        <a href="{{asset('employeee')}}" class="float-end btn btn-sm btn-info">View All (Ver todos)</a>
    </div>  
    <div class="card-body">
        <!-- -->
        @if ($errors->any())
            @foreach($errors->all() as $error)
            <p class="text-danger"> {{session($error)}} </p>
            @endforeach
            
        @endif

        @if (Session::has('msg'))

         <p class="text-success"> {{session('msg')}} </p>
            
        @endif

        <form method="POST" action="{{asset('employeee')}}" enctype="multipart/form-data"> 
            @csrf
            <table class="table table-bordered">
                <tr>
                    <th>Nome Completo</th>
                    <td>
                        <input type="text" name="fullName" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Fotografia</th>
                    <td>
                        <input type="file" name="photo" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Endereço</th>
                    <td>
                        <input type="text" name="address" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Telefone</th>
                    <td>
                        <input type="text" name="mobile" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <input type="radio" value="1" name="status">Ativo 
                        <br>
                       <input type="radio" checked="checked"  value="0" name="status"> Não Ativo
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