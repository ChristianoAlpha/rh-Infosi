@extends('layouts.layout')
@section('title', 'Editar Administrador')
@section('content')
<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-pencil-square me-2"></i>Editar Administrador</span>
    <a href="{{ route('admins.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admins.update', $admin->id) }}">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating">
            <select name="employeeId" class="form-select">
              
              <option value="">Selecione um Funcionário (Opcional)</option>
              @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ $admin->employeeId == $employee->id ? 'selected' : '' }}>
                  {{ $employee->fullName }}
                </option>
              @endforeach
            </select>
            <label for="employeeId">Funcionário Vinculado</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <select name="role" class="form-select" required>
              <option value="">Selecione o Papel</option>
              <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>Administrador</option>
              <option value="director" {{ $admin->role == 'director' ? 'selected' : '' }}>Diretor</option>
              <option value="department_head" {{ $admin->role == 'department_head' ? 'selected' : '' }}>Chefe de Departamento</option>
              <option value="employee" {{ $admin->role == 'employee' ? 'selected' : '' }}>Funcionário</option>
            </select>
            <label for="role">Papel</label>
          </div>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $admin->email }}" required>
            <label for="email">Email</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="password" name="password" class="form-control" placeholder="Senha">
            <label for="password">Nova Senha (deixe em branco para não alterar)</label>
          </div>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirme a Senha">
            <label for="password_confirmation">Confirme a Senha</label>
          </div>
        </div>
      </div>
      <div class="mt-3 text-center">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle"></i> Atualizar Usuário
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
