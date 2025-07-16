@extends("layouts.admin.layout")
@section("title", "Criar Funcionários")
@section("content")

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-person-plus me-2"></i>Novo Funcionário</span>
    <a href="{{ route("employeee.index") }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route("employeee.store") }}" enctype="multipart/form-data">
      @csrf

      <!-- Depart., Cargo, Especialidade, Tipo, Categoria -->
      <div class="row g-3">
        <div class="col-md-3">
          <div class="form-floating">
            <select name="depart" id="depart" class="form-select">
              <option value="" selected>Selecione</option>
              @foreach($departments as $depart)
                <option value="{{ $depart->id }}">{{ $depart->title }}</option>
              @endforeach
            </select>
            <label for="depart">Departamento</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="positionId" id="positionId" class="form-select">
              <option value="" selected>Selecione</option>
              @foreach($positions as $position)
                <option value="{{ $position->id }}">{{ $position->name }}</option>
              @endforeach
            </select>
            <label for="positionId">Cargo</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="specialtyId" id="specialtyId" class="form-select">
              <option value="" selected>Selecione</option>
              @foreach($specialties as $specialty)
                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
              @endforeach
            </select>
            <label for="specialtyId">Especialidade</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="employeeTypeId" id="employeeTypeId" class="form-select">
              <option value="" selected>Selecione</option>
              @foreach($employeeTypes as $etype)
                <option value="{{ $etype->id }}">{{ $etype->name }}</option>
              @endforeach
            </select>
            <label for="employeeTypeId">Tipo de Funcionário</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="employeeCategoryId" id="employeeCategoryId" class="form-select">
              <option value="" selected>Selecione</option>
              @foreach($employeeCategories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
            <label for="employeeCategoryId">Categoria do Funcionário</label>
          </div>
        </div>
        <!-- Novos campos para Habilitações Literárias -->
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" name="academicLevel" id="academicLevel" class="form-control" placeholder="Nível Acadêmico" value="{{ old("academicLevel") }}">
            <label for="academicLevel">Nível Acadêmico</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating">
            <select name="courseId" id="courseId" class="form-select">
              <option value="" selected>Selecione</option>
              @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
              @endforeach
            </select>
            <label for="courseId">Curso</label>
          </div>
        </div>
      </div>

      <!-- Nome e Email -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="fullName" id="fullName" class="form-control" placeholder="Nome Completo" value="{{ old("fullName") }}">
            <label for="fullName">Nome Completo</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email " value="{{ old("email") }}">
            <label for="email">Email (nome.sobrenome@infosi.gov.ao)</label>
          </div>
        </div>
      </div>

      <!-- Endereço e Telefone -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="address" id="address" class="form-control" placeholder="Endereço" value="{{ old("address") }}">
            <label for="address">Endereço</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="selected_code" style="height: calc(3.5rem + 5px);">
              Selecione o Código
            </button>
            <ul class="dropdown-menu" id="phone_code_menu" style="max-height: 30em; overflow-y: auto;"></ul>
            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Telefone" maxlength="16" value="{{ old("mobile") }}">
            <input type="hidden" name="phoneCode" id="phoneCode" value="{{ old("phoneCode") }}">
          </div>
        </div>
      </div>

      <!-- Pai e Mãe -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="fatherName" id="fatherName" class="form-control" placeholder="Nome do Pai" value="{{ old("fatherName") }}">
            <label for="fatherName">Nome do Pai</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="text" name="motherName" id="motherName" class="form-control" placeholder="Nome da Mãe" value="{{ old("motherName") }}">
            <label for="motherName">Nome da Mãe</label>
          </div>
        </div>
      </div>

      <!-- BI, Upload BI e Nascimento -->
   
       <div class="row g-0 mt-3">
        <div class="col-md-3 pe-0">
          <div class="form-floating">
            <input type="text" name="bi" id="bi" class="form-control" placeholder="Bilhete de Identidade" value="{{ old("bi") }}">
            <label for="bi">Bilhete de Identidade</label>
          </div>
        </div>
        <div class="col-md-3 ps-0">
          <div class="form-floating">
            <input type="file" name="biPhoto" id="biPhoto" class="form-control">
            <label for="biPhoto">Cópia do BI (PDF/Foto)</label>
          </div>
        </div>
        <div class="col-md-6 ps-3">
          <div class="form-floating">
            <input type="date" name="birth_date" id="birth_date" class="form-control" placeholder="Data de Nascimento"
                   value="{{ old("birth_date") }}"
                   max="{{ date("Y-m-d") }}"
                   min="{{ \Carbon\Carbon::now()->subYears(120)->format("Y-m-d") }}">
            <label for="birth_date">Data de Nascimento</label>
          </div>
        </div>
      </div>

      <!-- Nacionalidade, Gênero, IBAN, Foto -->
      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <div class="form-floating">
            <select name="nationality" id="nationality" class="form-select">
              <option value="">Selecione seu país</option>
            </select>
            <label for="nationality">Nacionalidade</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <select name="gender" id="gender" class="form-select">
              <option value="" selected>Selecione</option>
              <option value="Masculino" @if(old("gender")=="Masculino") selected @endif>Masculino</option>
              <option value="Feminino" @if(old("gender")=="Feminino") selected @endif>Feminino</option>
            </select>
            <label for="gender">Gênero</label>
          </div>
        </div>
        <div class="col-md-4">
  <div class="form-floating">
    <input
      type="text"
      name="iban"
      id="iban"
      class="form-control"
      placeholder="IBAN"
      value="AO06{{ old("iban") ? substr(old("iban"), 4) : "" }}"
      maxlength="25"
      pattern="AO06[0-9]{21}"
      title="O IBAN deve começar por AO06 seguido de 21 dígitos."
    >
    <label for="iban">IBAN</label>
  </div>
</div>



      <div class="row g-3 mt-3">
        <div class="col-md-6 offset-md-3">
          <div class="form-floating">
            <input type="file" name="photo" id="photo" class="form-control">
            <label for="photo">Fotografia</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-6 mx-auto mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Cadastrar Funcionário
        </button>
      </div>
    </form>
  </div>
</div>

@endsection


