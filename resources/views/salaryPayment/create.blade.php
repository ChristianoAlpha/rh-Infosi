@extends('layouts.layout')
@section('title', 'Adicionar Pagamento de Salário')
@section('content')
<div class="row justify-content-center">
  <div class="{{ isset($employee) ? 'col-md-5' : 'col-md-8' }}">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h4>Adicionar Pagamento de Salário</h4>
        <a href="{{ route('salaryPayment.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
          <i class="bi bi-arrow-left"></i> Voltar
        </a>
      </div>
      <div class="card-body">
        @if(!isset($employee))
          <form method="GET" action="{{ route('salaryPayment.searchEmployee') }}" class="mb-4">
            <div class="row g-3">
              <div class="col-md-8">
                <div class="form-floating">
                  <input type="text" name="employeeSearch" class="form-control"
                         placeholder="Pesquisar por ID ou Nome do Funcionário"
                         value="{{ old('employeeSearch') }}">
                  <label for="employeeSearch">ID ou Nome do Funcionário</label>
                </div>
                @error('employeeSearch')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100 mt-0">
                  <i class="bi bi-search"></i> Buscar
                </button>
              </div>
            </div>
          </form>
        @else
          <hr>
   
          <div class="mb-3">
            <h5>Dados do Funcionário</h5>
            <p><strong>Nome:</strong> {{ $employee->fullName }}</p>
            <p><strong>E-mail:</strong> {{ $employee->email }}</p>
            <p><strong>Departamento:</strong> {{ $employee->department->title ?? '-' }}</p>
          </div>

          <form method="POST" action="{{ route('salaryPayment.store') }}">
            @csrf
            <input type="hidden" name="employeeId" value="{{ $employee->id }}">

            <div class="mb-3">
              <label for="baseSalary" class="form-label">Salário Básico (Kz)</label>
              <input type="text" name="baseSalary" id="baseSalary"
                     class="form-control currency"
                     value="{{ old('baseSalary', 0) }}" required>
            </div>

            <div class="mb-3">
              <label for="subsidies" class="form-label">Subsídios (Kz)</label>
              <input type="text" name="subsidies" id="subsidies"
                     class="form-control currency"
                     value="{{ old('subsidies', 0) }}" required>
            </div>

            <div class="mb-3">
              <label for="irtRate" class="form-label">IRT (%)</label>
              <input type="text" name="irtRate" id="irtRate"
                     class="form-control currency"
                     value="{{ old('irtRate', 0) }}" required>
            </div>

            <div class="mb-3">
              <label for="inssRate" class="form-label">INSS (%)</label>
              <input type="text" name="inssRate" id="inssRate"
                     class="form-control currency"
                     value="{{ old('inssRate', 0) }}" required>
            </div>

            <div class="mb-3">
              <label for="discount" class="form-label">Desconto (Kz)</label>
              <input type="text" name="discount" id="discount"
                     class="form-control currency"
                     value="{{ old('discount', 0) }}">
            </div>

            <div class="mb-3">
              <label for="paymentDate" class="form-label">Data de Pagamento</label>
              <input type="date" name="paymentDate" id="paymentDate"
                     class="form-control"
                     value="{{ old('paymentDate') }}">
            </div>

            <div class="mb-3">
              <label for="paymentStatus" class="form-label">Status do Pagamento</label>
              <select name="paymentStatus" id="paymentStatus" class="form-select">
                <option value="Pending" @if(old('paymentStatus')=='Pending') selected @endif>Pendente</option>
                <option value="Completed" @if(old('paymentStatus')=='Completed') selected @endif>Concluído</option>
                <option value="Failed" @if(old('paymentStatus')=='Failed') selected @endif>Falhou</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="paymentComment" class="form-label">Comentário</label>
              <textarea name="paymentComment" id="paymentComment"
                        class="form-control">{{ old('paymentComment') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">
              <i class="bi bi-check-circle"></i> Salvar Pagamento
            </button>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
