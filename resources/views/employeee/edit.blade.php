{{--UPDATE--}}
@extends('layout')
@section('title', 'Adicionar Funcionarios')
@section('content')


<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Criação de Funcionarios
        <!--link que vai para a view index a onde estão listados todos os departamentos pertencente a rota depart-->

        <a href="{{asset('employeee')}}" class="float-end btn btn-sm btn-info">Ver todos</a>
    </div>  
    <div class="card-body">
        <!-- Mensagem de erro -->
        @if ($errors->any())
            @foreach($errors->all() as $error)
            <p class="text-danger"> {{$error}} </p>
            @endforeach
            
        @endif

        @if (Session::has('msg'))

         <p class="text-success"> {{session('msg')}} </p>
            
        @endif


        <form method="POST" action="{{asset('employeee/' .$data->id)}}" enctype="multipart/form-data">
            @csrf 
            @method('put')
            <table class="table table-bordered">
                <tr>
                    <th>Departamento</th>
                    <td>
                        <select name="depart" class="form-control">
                            <option value="">-- Selecione o Departamento --</option>
                            {{-- comentario do depart id  --}}
                            @foreach($departs as $depart)
                                <option 
                                    @if($depart->id==$data->departmentId) selected @endif value="{{$depart->id}}">
                                        {{$depart->title}}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Nome Completo</th>
                    <td>
                        {{--Comentario para o value de cada campo que pega o nome atual e manda para a variavel data que atualiza depois da edição--}}
                        <input type="text" value="{{$data->fullName}}" name="fullName" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Fotografia</th>
                    <td>
                        <input type="file" name="photo" class="form-control">
                        <p>
                            <img src="{{asset('public/images/'. $data->photo)}}" width="200" />
                            <input type="hidden" name="prev_photo" value="{{$data->photo}}" />
                        </p>
                    </td>
                </tr>
                <tr>
                    <th>Endereço</th>
                    <td>
                        <input value="{{$data->address}}" type="text"  name="address" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Telefone</th>
                    <td>
                        <input value="{{$data->mobile}}" type="text" name="mobile" class="form-control">
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <input @if($data->status==1) checked @endif type="radio" value="1" name="status">Activo 
                        <br>
                       <input @if($data->status==0) checked @endif  type="radio" value="0" name="status"> Não Activo
                    </td>
                </tr>
                <!-- Campos Adicionais -->
                <tr>
                    <th>Nome do Pai</th>
                    <td><input type="text" name="father_name" class="form-control"></td>
                </tr>
                <tr>
                    <th>Nome da Mãe</th>
                    <td><input type="text" name="mother_name" class="form-control"></td>
                </tr>
                <tr>
                    <th>BI</th>
                    <td><input type="text" name="bi" class="form-control"></td>
                </tr>
                <tr>
                    <th>Data Nasc.</th>
                    <td><input type="date" name="birth_date" class="form-control"></td>
                </tr>
                <tr>
                    <th>Nacionalidade</th>
                    <td><input type="text" name="nationality" class="form-control"></td>
                </tr>
                <tr>
                    <th>Gênero</th>
                    <td>
                        <select name="gender" class="form-control">
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="email" name="email" class="form-control"></td>
                </tr>
                <tr>
                    <th>Cargo</th>
                    <td>
                        <select name="position_id" class="form-control">
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Especialidade</th>
                    <td>
                        <select name="specialty_id" class="form-control">
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                            @endforeach
                        </select>
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