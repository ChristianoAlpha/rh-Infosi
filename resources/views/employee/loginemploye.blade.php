{{-- resources/views/employee/create.blade.php --}}
@extends('layout')
@section('title', 'funcionarios')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
                <h3 class="text-center font-weight-light my-4">Funcionario</h3>
            </div>
            <div class="card-body">
                <!-- Exibição de erros -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Mensagem de sucesso -->
                @if (Session::has('msg'))
                    <p class="text-success">{{ session('msg') }}</p>
                @endif

                <form method="POST" action="{{ url('employee') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter name">
                    </div>

                    <div class="mb-3">
                        <label for="father" class="form-label">Nome do Pai</label>
                        <input name="father" type="text" class="form-control" id="father" placeholder="Enter father's name">
                    </div>

                    <div class="mb-3">
                        <label for="mother" class="form-label">Nome da Mãe</label>
                        <input name="mother" type="text" class="form-control" id="mother" placeholder="Enter mother's name">
                    </div>

                    <div class="mb-3">
                        <label for="adress" class="form-label">Endereço</label>
                        <input name="adress" type="text" class="form-control" id="adress" placeholder="Enter address">
                    </div>

                    <div class="mb-3">
                        <label for="bi" class="form-label">BI (Bilhete de Identidade)</label>
                        <input name="bi" type="text" class="form-control" id="bi" placeholder="Enter BI">
                    </div>

                    <div class="mb-3">
                        <label for="birthDay" class="form-label">Data de Nascimento</label>
                        <input name="birthDay" type="date" class="form-control" id="birthDay">
                    </div>

                    <div class="mb-3">
                        <label for="nacionality" class="form-label">Nacionalidade</label>
                        <input name="nacionality" type="text" class="form-control" id="nacionality" placeholder="Enter nacionality">
                    </div>

                    <div class="mb-3">
                        <label for="genero" class="form-label">Genero</label>
                        <select name="genero" id="genero" class="form-control">
                            <option value="Male">Masculino</option>
                            <option value="Female">Femenino</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter phone">
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <input type="submit" class="btn btn-primary" value="Add Employee (Adicionar Funcionario)">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
