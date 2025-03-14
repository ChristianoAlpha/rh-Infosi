@extends('layouts.layout')
@section('title', 'Novo Pedido de Licença')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">
    <span><i class="bi bi-file-alt me-2"></i>Novo Pedido de Licença</span>
    <a href="{{ route('leaveRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    <!-- Formulário para buscar funcionário pelo ID -->
    <form action="{{ route('leaveRequest.searchEmployee') }}" method="GET" class="mb-4">
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

    @isset($employee)
      <hr>
      <form action="{{ route('leaveRequest.store') }}" method="POST">
        @csrf
        <!-- ID do Funcionário -->
        <input type="hidden" name="employeeId" value="{{ $employee->id }}">

        <div class="container">
          <div class="row">
            <!-- Coluna da esquerda: Nome, Contacto e Tipo de Funcionário -->
            <div class="col-md-6">
              <!-- Nome do Funcionário -->
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

            <!-- Coluna da direita: Departamento e Tipo de Licença -->
            <div class="col-md-6">
              @isset($currentDepartment)
                <input type="hidden" name="departmentId" value="{{ $currentDepartment->id }}">
                <div class="mb-3">
                  <label class="form-label">Departamento a que Pertence</label>
                  <input type="text" class="form-control" value="{{ $currentDepartment->title }}" readonly>
                </div>
              @endisset

              <!-- Tipo de Licença -->
              <div class="mb-3">
                <label class="form-label">Tipo de Licença</label>
                <select name="leaveTypeId" class="form-select" required>
                  <option value="">-- Selecione o tipo de licença --</option>
                  @foreach($leaveTypes as $lt)
                    <option value="{{ $lt->id }}" @if(old('leaveTypeId') == $lt->id) selected @endif>
                      {{ $lt->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!-- Linha para o campo Razão do Pedido -->
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Razão do Pedido</label>
                <textarea name="reason" rows="3" class="form-control">{{ old('reason') }}</textarea>
              </div>
            </div>
          </div>

      
          <div class="row">
            <div class="col text-center">
              <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Salvar Pedido de Licença
              </button>
            </div>
          </div>
        </div>
      </form>
    @endisset

  </div>
</div>

@endsection
