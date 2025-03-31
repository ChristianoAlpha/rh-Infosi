@extends('layouts.admin.layout')
@section('title', 'Detalhes do Pagamento de Salário')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span>Detalhes do Pagamento de Salário</span>
    <a href="{{ route('salaryPayment.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th>Funcionário</th>
        <td>{{ $salaryPayment->employee->fullName ?? '-' }}</td>
      </tr>
      <tr>
        <th>Salário Básico (Kz)</th>
        <td>{{ $salaryPayment->baseSalary }}</td>
      </tr>
      <tr>
        <th>Subsídios (Kz)</th>
        <td>{{ $salaryPayment->subsidies }}</td>
      </tr>
      <tr>
        <th>IRT (%)</th>
        <td>{{ $salaryPayment->irtRate }}</td>
      </tr>
      <tr>
        <th>INSS (%)</th>
        <td>{{ $salaryPayment->inssRate }}</td>
      </tr>
      <tr>
        <th>Desconto (Kz)</th>
        <td>{{ $salaryPayment->discount }}</td>
      </tr>
      <tr>
        <th>Salário Líquido (Kz)</th>
        <td>{{ $salaryPayment->salaryAmount }}</td>
      </tr>
      <tr>
        <th>Data de Pagamento</th>
        <td>{{ $salaryPayment->paymentDate }}</td>
      </tr>
      <tr>
        <th>Status do Pagamento</th>
        <td>{{ $salaryPayment->paymentStatus }}</td>
      </tr>
      <tr>
        <th>Comentário</th>
        <td>{{ $salaryPayment->paymentComment ?? '-' }}</td>
      </tr>
      <tr>
        <th>Criado em</th>
        <td>{{ $salaryPayment->created_at->format('d/m/Y H:i') }}</td>
      </tr>
    </table>
  </div>
</div>
@endsection
