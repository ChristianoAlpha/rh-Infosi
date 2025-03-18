@extends('layouts.layout')
@section('title', 'Editar Pagamento de Salário')
@section('content')
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
          @foreach($employees as $employee)
            <option value="{{ $employee->id }}" @if($salaryPayment->employeeId == $employee->id) selected @endif>
              {{ $employee->fullName }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="salaryAmount" class="form-label">Valor do Salário (Kz)</label>
        <input type="number" step="0.01" name="salaryAmount" id="salaryAmount" class="form-control" value="{{ $salaryPayment->salaryAmount }}" required>
      </div>
      <div class="mb-3">
        <label for="paymentDate" class="form-label">Data de Pagamento</label>
        <input type="date" name="paymentDate" id="paymentDate" class="form-control" value="{{ $salaryPayment->paymentDate }}">
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
        <textarea name="paymentComment" id="paymentComment" class="form-control">{{ $salaryPayment->paymentComment }}</textarea>
      </div>
      <button type="submit" class="btn btn-success w-100">
        <i class="bi bi-check-circle"></i> Atualizar Pagamento
      </button>
    </form>
  </div>
</div>
@endsection
