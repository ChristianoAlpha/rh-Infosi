@extends('layouts.layout')
@section('title', 'Criar Administrador')
@section('content')
<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-person-plus me-2"></i>Novo Administrador</span>
    <a href="{{ route('admins.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    <!-- Formulário de pesquisa de funcionário -->
    <form id="employeeSearchForm" method="GET" action="{{ route('admins.searchEmployee') }}" class="mb-3">
      <div class="row g-2">
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text" name="employeeSearch" id="employeeSearch" class="form-control" placeholder="ID ou Nome do Funcionário">
            <label for="employeeSearch">Pesquisar Funcionário (ID ou Nome)</label>
          </div>
        </div>
        <div class="col-md-4">
          <button type="submit" id="btnSearchEmployee" class="btn btn-primary w-100">Buscar</button>
        </div>
      </div>
    </form>
    <!-- Área para exibir o resultado da pesquisa -->
    <div id="employeeResult" class="mb-3"></div>

    <!-- Formulário de criação de administrador -->
    <form method="POST" action="{{ route('admins.store') }}" id="adminCreateForm">
      @csrf
      <div class="row g-3">
        <!-- Funcionário Vinculado: este select será preenchido automaticamente -->
        <div class="col-md-6">
          <div class="form-floating">
            <select name="employeeId" id="employeeId" class="form-select">
              <option value="">Selecione um Funcionário (Opcional)</option>
              @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
              @endforeach
            </select>
            <label for="employeeId">Funcionário Vinculado</label>
          </div>
        </div>
        <!-- Nível de Acesso -->
        <div class="col-md-6">
          <div class="form-floating">
            <select name="role" id="role" class="form-select" required>
              <option value="">Selecione o Papel</option>
              <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Administrador</option>
              <option value="director" {{ old('role')=='director' ? 'selected' : '' }}>Diretor</option>
              <option value="department_head" {{ old('role')=='department_head' ? 'selected' : '' }}>Chefe de Departamento</option>
              <option value="employee" {{ old('role')=='employee' ? 'selected' : '' }}>Funcionário</option>
            </select>
            <label for="role">Papel</label>
          </div>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <!-- Email: este campo será preenchido automaticamente -->
        <div class="col-md-6">
          <div class="form-floating">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required readonly>
            <label for="email">Email do Funcionário</label>
          </div>
        </div>
        <!-- Senha com toggle -->
        <div class="col-md-6 position-relative">
          <div class="form-floating">
            <input type="password" name="password" id="password" class="form-control" placeholder="Senha" required>
            <label for="password">Senha</label>
          </div>
          <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password', this)">
            <i class="bi bi-eye-fill"></i>
          </span>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <!-- Confirmação de senha -->
        <div class="col-md-6">
          <div class="form-floating">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirme a Senha" required>
            <label for="password_confirmation">Confirme a Senha</label>
          </div>
        </div>
      </div>
      <!-- Indicador de força da senha -->
      <div class="mt-2" id="passwordStrength" style="font-size: 0.9rem;"></div>
      <div class="mt-3 text-center">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle"></i> Salvar Usuário
        </button>
      </div>
    </form>
  </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Função para alternar exibição da senha
function togglePassword(fieldId, iconElement) {
  const field = document.getElementById(fieldId);
  if (field.type === 'password') {
    field.type = 'text';
    iconElement.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
  } else {
    field.type = 'password';
    iconElement.innerHTML = '<i class="bi bi-eye-fill"></i>';
  }
}

// Função para checar a força da senha (exemplo simples)
$('#password').on('input', function(){
  const strengthDiv = $('#passwordStrength');
  const pwd = $(this).val();
  let strength = 0;
  if(pwd.length >= 8) strength++;
  if(pwd.match(/[a-z]/)) strength++;
  if(pwd.match(/[A-Z]/)) strength++;
  if(pwd.match(/[0-9]/)) strength++;
  if(pwd.match(/[^a-zA-Z0-9]/)) strength++;
  let strengthText = '';
  if(strength <= 2) {
    strengthText = '<span class="text-danger">Senha fraca</span>';
  } else if(strength === 3 || strength === 4) {
    strengthText = '<span class="text-warning">Senha média</span>';
  } else if(strength === 5) {
    strengthText = '<span class="text-success">Senha forte</span>';
  }
  strengthDiv.html(strengthText);
});

// AJAX para pesquisa de funcionário
$('#employeeSearchForm').on('submit', function(e){
  e.preventDefault();
  const searchTerm = $('#employeeSearch').val().trim();
  if(searchTerm === ''){
    alert('Por favor, insira um ID ou nome para pesquisar.');
    return;
  }
  $.ajax({
    url: "{{ route('admins.searchEmployee') }}",
    data: { employeeSearch: searchTerm },
    method: 'GET',
    success: function(data) {
      // Preenche o select de funcionário com o resultado
      if(data.id) {
        $('#employeeId').html(`<option value="${data.id}" selected>${data.fullName}</option>`);
        // Preenche o campo email automaticamente
        $('#email').val(data.email);
        $('#employeeResult').html('<div class="alert alert-success">Funcionário encontrado: ' + data.fullName + ' (' + data.email + ')</div>');
      } else {
        $('#employeeResult').html('<div class="alert alert-danger">Funcionário não encontrado.</div>');
      }
    },
    error: function(xhr) {
      $('#employeeResult').html('<div class="alert alert-danger">Funcionário não encontrado.</div>');
    }
  });
});
</script>
@endsection

@endsection
