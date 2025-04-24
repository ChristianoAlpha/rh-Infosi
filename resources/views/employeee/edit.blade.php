@extends('layouts.admin.layout')
@section('title', 'Editar Funcionário')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-pencil-square me-2"></i>Editar Funcionário</span>
    <a href="{{ route('employeee.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('employeee.update', $data->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Linha: Departamento, Cargo, Especialidade, Tipo de Funcionário -->
      <div class="row g-3">
        <div class="col-md-3">
          <div class="form-floating">
            <select name="depart" id="depart" class="form-select">
              <option value="">Selecione</option>
              @foreach($departs as $depart)
                <option value="{{ $depart->id }}" @if(old('depart', $data->departmentId) == $depart->id) selected @endif>
                  {{ $depart->title }}
                </option>
              @endforeach
            </select>
            <label for="depart">Departamento</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="positionId" id="positionId" class="form-select">
              <option value="">Selecione</option>
              @foreach($positions as $position)
                <option value="{{ $position->id }}" @if(old('positionId', $data->positionId) == $position->id) selected @endif>
                  {{ $position->name }}
                </option>
              @endforeach
            </select>
            <label for="positionId">Cargo</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="specialtyId" id="specialtyId" class="form-select">
              <option value="">Selecione</option>
              @foreach($specialties as $specialty)
                <option value="{{ $specialty->id }}" @if(old('specialtyId', $data->specialtyId) == $specialty->id) selected @endif>
                  {{ $specialty->name }}
                </option>
              @endforeach
            </select>
            <label for="specialtyId">Especialidade</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="employeeTypeId" id="employeeTypeId" class="form-select">
              <option value="">Selecione</option>
              @foreach($employeeTypes as $etype)
                <option value="{{ $etype->id }}" @if(old('employeeTypeId', $data->employeeTypeId) == $etype->id) selected @endif>
                  {{ $etype->name }}
                </option>
              @endforeach
            </select>
            <label for="employeeTypeId">Tipo de Funcionário</label>
          </div>
        </div>
      </div>

      <!-- Linha: Nome Completo e Email -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="fullName" id="fullName" class="form-control" placeholder="Nome Completo" value="{{ old('fullName', $data->fullName) }}">
            <label for="fullName">Nome Completo</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email', $data->email) }}">
            <label for="email">Email</label>
          </div>
        </div>
      </div>

      <!-- Linha: Endereço e Telefone -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="address" id="address" class="form-control" placeholder="Endereço" value="{{ old('address', $data->address) }}">
            <label for="address">Endereço</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="selected_code" style="height: calc(3.5rem + 5px);">
              Selecione o Código
            </button>
            <ul class="dropdown-menu" id="phone_code_menu" style="max-height: 30em; overflow-y: auto;"></ul>
            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Telefone" maxlength="16" value="{{ old('mobile', $data->mobile) }}">
            <input type="hidden" name="phoneCode" id="phoneCode" value="{{ old('phoneCode', $data->phoneCode) }}">
          </div>
        </div>
      </div>

      <!-- Linha: Nome do Pai e Nome da Mãe -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="fatherName" id="fatherName" class="form-control" placeholder="Nome do Pai" value="{{ old('fatherName', $data->fatherName) }}">
            <label for="fatherName">Nome do Pai</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="motherName" id="motherName" class="form-control" placeholder="Nome da Mãe" value="{{ old('motherName', $data->motherName) }}">
            <label for="motherName">Nome da Mãe</label>
          </div>
        </div>
      </div>

      <!-- Linha: BI e Data de Nascimento -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="bi" id="bi" class="form-control" placeholder="Bilhete de Identidade" value="{{ old('bi', $data->bi) }}">
            <label for="bi">Bilhete de Identidade</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="date" name="birth_date" id="birth_date" class="form-control"
                   value="{{ old('birth_date', $data->birth_date) }}"
                   max="{{ date('Y-m-d') }}"
                   min="{{ \Carbon\Carbon::now()->subYears(120)->format('Y-m-d') }}">
            <label for="birth_date">Data de Nascimento</label>
          </div>
        </div>
      </div>

      <!-- Linha: Nacionalidade e Gênero -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <select name="nationality" id="nationality" class="form-select">
              <option value="">Selecione seu país</option>
              <!-- Preenchido via JS -->
            </select>
            <label for="nationality">Nacionalidade</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <select name="gender" id="gender" class="form-select">
              <option value="">Selecione</option>
              <option value="Masculino" @if(old('gender', $data->gender) == 'Masculino') selected @endif>Masculino</option>
              <option value="Feminino" @if(old('gender', $data->gender) == 'Feminino') selected @endif>Feminino</option>
            </select>
            <label for="gender">Gênero</label>
          </div>
        </div>
      </div>

      <!-- Linha: Fotografia e IBAN -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="iban" id="iban" class="form-control" placeholder="IBAN"
                   value="AO06{{ old('iban') ? substr(old('iban'), 4) : substr($data->iban, 4) }}">
            <label for="iban">IBAN</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="file" name="photo" id="photo" class="form-control">
            <label for="photo">Fotografia</label>
          </div>
        </div>
      </div>

      <!-- Botão de envio -->
      <div class="d-grid gap-2 col-6 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-save2 me-2"></i>Atualizar Funcionário
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
