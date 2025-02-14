{{--SHOW--}}
@extends('layout')
@section('title', 'Ver departamento')
@section('content')


<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Ver departamento
        <!--link que vai para a view index a onde estão listados todos os departamentos pertencente a rota depart-->
        <a href="{{asset('depart')}}" class="float-end btn btn-sm btn-success">Ver todos</a>
    </div>  
    <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Title</th>
                    <td>
                        <!--Ver dados-->
                         {{$data->title}}  
                    </td>
                </tr>
            </table>
    </div>
</div>

@endsection