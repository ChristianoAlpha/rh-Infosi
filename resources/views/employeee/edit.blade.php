@extends('layout')
@section('title', 'Editar Funcionário')
@section('content')

<div class="card mb-4 mt-4">
  <div class="card-header">
    <i class="fas fa-table me-1"></i> Edição de Funcionários
    <a href="{{ asset('employeee') }}" class="float-end btn btn-sm btn-info">Ver todos</a>
  </div>
  <div class="card-body">
    {{-- Exibição de erros --}}
    @if ($errors->any())
      @foreach($errors->all() as $error)
        <p class="text-danger">{{ $error }}</p>
      @endforeach
    @endif

    @if (Session::has('msg'))
      <p class="text-success">{{ session('msg') }}</p>
    @endif

    <form method="POST" action="{{ asset('employeee/' . $data->id) }}" enctype="multipart/form-data">
      @csrf 
      @method('put')

      <!-- Linha 1: Departamento, Cargo e Especialidade -->
      <div class="row mb-3">
        <div class="col-md-4">
          <label for="depart" class="form-label">Departamento</label>
          <select name="depart" id="depart" class="form-control">
            <option value="">-- Selecione o Departamento --</option>
            @foreach($departs as $depart)
              <option value="{{ $depart->id }}" @if($depart->id == $data->departmentId) selected @endif>
                {{ $depart->title }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label for="position_id" class="form-label">Cargo</label>
          <select name="position_id" id="position_id" class="form-control">
            <option value="">-- Selecione o Cargo --</option>
            @foreach($positions as $position)
              <option value="{{ $position->id }}" @if(isset($data->position_id) && $position->id == $data->position_id) selected @endif>
                {{ $position->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label for="specialty_id" class="form-label">Especialidade</label>
          <select name="specialty_id" id="specialty_id" class="form-control">
            <option value="">-- Selecione a Especialidade --</option>
            @foreach($specialties as $specialty)
              <option value="{{ $specialty->id }}" @if(isset($data->specialty_id) && $specialty->id == $data->specialty_id) selected @endif>
                {{ $specialty->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <!-- Linha 2: Nome Completo (linha inteira) -->
      <div class="row mb-3">
        <div class="col-md-12">
          <label for="fullName" class="form-label">Nome Completo</label>
          <input type="text" name="fullName" id="fullName" class="form-control" placeholder="Digite o nome completo" value="{{ $data->fullName }}">
        </div>
      </div>

      <!-- Linha 3: Endereço e Telefone -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="address" class="form-label">Endereço</label>
          <input type="text" name="address" id="address" class="form-control" placeholder="Digite o endereço" value="{{ $data->address }}">
        </div>
        <div class="col-md-6">
          <label for="mobile" class="form-label">Telefone</label>
          <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Digite o telefone" value="{{ $data->mobile }}">
        </div>
      </div>

      <!-- Linha 4: Nome do Pai e Nome da Mãe -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="father_name" class="form-label">Nome do Pai</label>
          <input type="text" name="father_name" id="father_name" class="form-control" placeholder="Nome do pai" value="{{ old('father_name', $data->father_name ?? '') }}">
        </div>
        <div class="col-md-6">
          <label for="mother_name" class="form-label">Nome da Mãe</label>
          <input type="text" name="mother_name" id="mother_name" class="form-control" placeholder="Nome da mãe" value="{{ old('mother_name', $data->mother_name ?? '') }}">
        </div>
      </div>

      <!-- Linha 5: Bilhete de Identidade e Data de Nascimento -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="bi" class="form-label">Bilhete de Identidade</label>
          <input type="text" name="bi" id="bi" class="form-control" placeholder="Número do BI" value="{{ old('bi', $data->bi ?? '') }}">
        </div>
        <div class="col-md-6">
          <label for="birth_date" class="form-label">Data de Nascimento</label>
          <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date', $data->birth_date ?? '') }}">
        </div>
      </div>

      <!-- Linha 6: Nacionalidade e Gênero -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="nationality" class="form-label">Nacionalidade</label>
          <input type="text" name="nationality" id="nationality" class="form-control" placeholder="Digite a nacionalidade" value="{{ old('nationality', $data->nationality ?? '') }}">
        </div>
        <div class="col-md-6">
          <label for="gender" class="form-label">Gênero</label>
          <select name="gender" id="gender" class="form-control">
            <option value="">-- Selecione o Gênero --</option>
            <option value="Masculino" @if($data->gender == 'Masculino') selected @endif>Masculino</option>
            <option value="Feminino" @if($data->gender == 'Feminino') selected @endif>Feminino</option>
          </select>
        </div>
      </div>

      <!-- Linha 7: Email (linha inteira) -->
      <div class="row mb-3">
        <div class="col-md-12">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Digite o email" value="{{ $data->email }}">
        </div>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
      </div>
    </form>
  </div>
</div>

@endsection
