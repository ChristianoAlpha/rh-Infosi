@extends('layouts.layout')
@section('title', 'Adicionar Pagamento de Salário')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <h4>Adicionar Pagamento de Salário</h4>
  </div>
  <div class="card-body">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form method="POST" action="{{ route('salaryPayment.store') }}">
          @csrf
          <div class="mb-3">
            <label for="employeeId" class="form-label">Funcionário</label>
            <select name="employeeId" id="employeeId" class="form-select">
              <option value="">Selecione o Funcionário</option>
              @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="salaryAmount" class="form-label">Valor do Salário</label>
            <input type="number" step="0.01" name="salaryAmount" id="salaryAmount" class="form-control" value="{{ old('salaryAmount') }}" required>
          </div>
          <div class="mb-3">
            <label for="paymentDate" class="form-label">Data de Pagamento</label>
            <input type="date" name="paymentDate" id="paymentDate" class="form-control" value="{{ old('paymentDate') }}">
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
            <textarea name="paymentComment" id="paymentComment" class="form-control">{{ old('paymentComment') }}</textarea>
          </div>
          <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-check-circle"></i> Salvar Pagamento
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
