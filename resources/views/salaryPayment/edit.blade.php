@extends('layouts.admin.layout')
@section('title', 'Editar Pagamento de Salário')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h4>Editar Pagamento de Salário</h4>
        <a href="{{ route('salaryPayment.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
          <i class="bi bi-arrow-left"></i> Voltar
        </a>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('salaryPayment.update', $salaryPayment->id) }}">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="employeeId" class="form-label">Funcionário</label>
            <select name="employeeId" id="employeeId" class="form-select">
              <option value="">Selecione o Funcionário</option>
              @foreach($employees as $emp)
                <option value="{{ $emp->id }}" @if($salaryPayment->employeeId == $emp->id) selected @endif>
                  {{ $emp->fullName }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="baseSalary" class="form-label">Salário Básico (Kz)</label>
            <input type="text" name="baseSalary" id="baseSalary"
                   class="form-control currency"
                   value="{{ old('baseSalary', $salaryPayment->baseSalary) }}" required>
          </div>

          <div class="mb-3">
            <label for="subsidies" class="form-label">Subsídios (Kz)</label>
            <input type="text" name="subsidies" id="subsidies"
                   class="form-control currency"
                   value="{{ old('subsidies', $salaryPayment->subsidies) }}" required>
          </div>

          <div class="mb-3">
            <label for="irtRate" class="form-label">IRT (%)</label>
            <input type="text" name="irtRate" id="irtRate"
                   class="form-control currency"
                   value="{{ old('irtRate', $salaryPayment->irtRate) }}" required>
          </div>

          <div class="mb-3">
            <label for="inssRate" class="form-label">INSS (%)</label>
            <input type="text" name="inssRate" id="inssRate"
                   class="form-control currency"
                   value="{{ old('inssRate', $salaryPayment->inssRate) }}" required>
          </div>

          <div class="mb-3">
            <label for="discount" class="form-label">Desconto (Kz)</label>
            <input type="text" name="discount" id="discount"
                   class="form-control currency"
                   value="{{ old('discount', $salaryPayment->discount) }}">
          </div>

          <div class="mb-3">
            <label for="paymentDate" class="form-label">Data de Pagamento</label>
            <input type="date" name="paymentDate" id="paymentDate"
                   class="form-control"
                   value="{{ old('paymentDate', $salaryPayment->paymentDate) }}">
          </div>

          <div class="mb-3">
            <label for="paymentStatus" class="form-label">Status do Pagamento</label>
            <select name="paymentStatus" id="paymentStatus" class="form-select">
              <option value="Pending" @if($salaryPayment->paymentStatus == 'Pending') selected @endif>Pendente</option>
              <option value="Completed" @if($salaryPayment->paymentStatus == 'Completed') selected @endif>Concluído</option>
              <option value="Failed" @if($salaryPayment->paymentStatus == 'Failed') selected @endif>Falhou</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="paymentComment" class="form-label">Comentário</label>
            <textarea name="paymentComment" id="paymentComment" class="form-control">{{ old('paymentComment', $salaryPayment->paymentComment) }}</textarea>
          </div>

          <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-check-circle"></i> Atualizar Pagamento
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
