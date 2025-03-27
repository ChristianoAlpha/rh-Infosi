@extends('layouts.layout')
@section('title', 'Nova Mobilidade')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">
    <span><i class="bi bi-arrow-left-right me-2"></i> Nova Mobilidade</span>
  </div>
  <div class="card-body">
    <!-- Formulário para buscar o funcionário pelo ID -->
    <form action="{{ route('mobility.searchEmployee') }}" method="GET" class="mb-4">
      <div class="row g-3">
        <div class="col-md-4">
          <div class="form-floating">
            <input type="number" name="employeeId" id="employeeId" class="form-control" placeholder="ID do Funcionário" value="{{ old('employeeId') }}">
            <label for="employeeId">ID do Funcionário</label>
          </div>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100 mt-0">
            <i class="bi bi-search"></i> Buscar
          </button>
        </div>
      </div>
    </form>

    <!-- Se a busca retornar um funcionário, mostramos o formulário de mobilidade -->
    @isset($employee)
      <hr>
      <form action="{{ route('mobility.store') }}" method="POST">
        @csrf
        <!-- ID do funcionário (hidden) -->
        <input type="hidden" name="employeeId" value="{{ $employee->id }}">

        <div class="container">

          <div class="row">
            <!-- Coluna da esquerda: Nome, Contacto e Tipo de Funcionário -->
            <div class="col-md-6">
              <!-- Nome do Funcionário (apenas exibição) -->
              <div class="mb-3">
                <label class="form-label">Nome do Funcionário</label>
                <input type="text" class="form-control" value="{{ $employee->fullName }}" readonly>
              </div>
              <!-- Contacto -->
              <div class="mb-3">
                <label class="form-label">Contacto</label>
                <input type="text" class="form-control" value="{{ $employee->phone_code }} {{ $employee->mobile }}" readonly>
              </div>
              <!-- Tipo de Funcionário -->
              <div class="mb-3">
                <label class="form-label">Tipo de Funcionário</label>
                <input type="text" class="form-control" value="{{ $employee->employeeType->name ?? 'Não definido' }}" readonly>
              </div>
            </div>
            <!-- Coluna da direita: Departamento Atual e Novo Departamento -->
            <div class="col-md-6">
              <!-- Departamento Atual (oldDepartment) -->
              @isset($oldDepartment)
                <input type="hidden" name="oldDepartmentId" value="{{ $oldDepartment->id }}">
                <div class="mb-3">
                  <label class="form-label">Departamento Atual</label>
                  <input type="text" class="form-control" value="{{ $oldDepartment->title }}" readonly>
                </div>
              @endisset
              <!-- Novo Departamento -->
              <div class="mb-3">
                <label class="form-label">Novo Departamento</label>
                <select name="newDepartmentId" class="form-select" required>
                  <option value="" selected>-- Selecione --</option>
                  @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" @if(old('newDepartmentId') == $dept->id) selected @endif>
                      {{ $dept->title }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <!-- Linha para o campo Causa da Mobilidade -->
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Causa da Mobilidade</label>
                <textarea name="causeOfMobility" rows="3" class="form-control">{{ old('causeOfMobility') }}</textarea>
              </div>
            </div>


          </div>

          <div class="row">
            <div class="col text-center">
              <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Salvar Mobilidade
              </button>
            </div>
          </div>
        </div>
      </form>
    @endisset