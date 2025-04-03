@extends('layouts.admin.layout')
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
    <form method="POST" action="{{ route('admins.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating">
            <!-- Lista de funcionários que ainda não possuem papel -->
            <select name="employeeId" id="employeeId" class="form-select">
              <option value="">Selecione um Funcionário (Opcional)</option>
              @foreach($employees as $employee)
                <option value="{{ $employee->id }}" data-email="{{ $employee->email }}" data-fullname="{{ $employee->fullName }}">
                  {{ $employee->fullName }}
                </option>
              @endforeach
            </select>
            <label for="employeeId">Funcionário Vinculado</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <select name="role" id="role" class="form-select" required>
              <option value="">Selecione o Papel</option>
              <option value="admin">Administrador</option>
              <option value="director">Diretor</option>
              <option value="department_head">Chefe de Departamento</option>
              <option value="employee">Funcionário</option>
            </select>
            <label for="role">Papel</label>
          </div>
        </div>
      </div>

      <!-- Campos extras para Chefe de Departamento (aparecem se o papel selecionado for "department_head") -->
      <div id="department_head_fields" style="display: none;">
        <div class="row g-3 mt-3">
          <div class="col-md-6">
            <div class="form-floating">
              <select name="departmentId" class="form-select">
                <option value="">Selecione o Departamento</option>
                @foreach($departments as $dept)
                  <option value="{{ $dept->id }}">{{ $dept->title }}</option>
                @endforeach
              </select>
              <label for="departmentId">Departamento</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" name="departmentHeadName" class="form-control" placeholder="Nome do Chefe">
              <label for="departmentHeadName">Nome do Chefe de Departamento</label>
            </div>
          </div>
        </div>
        <div class="row g-3 mt-3">
          <div class="col-md-12">
            <div class="form-floating">
              <input type="file" name="photo" class="form-control">
              <label for="photo">Foto do Chefe</label>
            </div>
          </div>
        </div>
      </div>

      <!-- Campo de Email -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
            <label for="email">Email</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="password" name="password" class="form-control" placeholder="Senha" required>
            <label for="password">Senha</label>
          </div>
        </div>
      </div>
      <!-- Campo de Confirmação de Senha -->
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirme a Senha" required>
            <label for="password_confirmation">Confirme a Senha</label>
          </div>
        </div>
      </div>
      <div class="mt-3 text-center">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle"></i> Salvar Usuário
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Atualiza o display dos campos extras de chefe de departamento conforme o papel selecionado
document.getElementById('role').addEventListener('change', function() {
    document.getElementById('department_head_fields').style.display = (this.value === 'department_head') ? 'block' : 'none';
});

// Ao selecionar um funcionário, preenche automaticamente o campo email com os dados dele
document.getElementById('employeeId').addEventListener('change', function() {
    var selected = this.options[this.selectedIndex];
    if(selected && selected.dataset.email) {
        document.getElementById('email').value = selected.dataset.email;
    } else {
        document.getElementById('email').value = '';
    }
});
</script>
@endsection
