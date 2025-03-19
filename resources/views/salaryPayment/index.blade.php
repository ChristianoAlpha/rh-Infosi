@extends('layouts.layout')
@section('title', 'Pagamentos de Salário')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-money-bill-wave me-2"></i>Pagamentos de Salário</span>
    <div>
      <a href="{{ route('salaryPayment.pdfAll') }}" class="btn btn-outline-light btn-sm" title="Baixar PDF">
        <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
      </a>
      <a href="{{ route('salaryPayment.create') }}" class="btn btn-outline-light btn-sm" title="Adicionar Novo Pagamento">
        <i class="bi bi-plus-circle"></i> Adicionar Novo
      </a>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Funcionário</th>
            <th>Sal. Básico (Kz)</th>
            <th>Subsídios (Kz)</th>
            <th>IRT (%)</th>
            <th>INSS (%)</th>
            <th>Desconto (Kz)</th>
            <th>Sal. Líquido (Kz)</th>
            <th>Data de Pagamento</th>
            <th>Status</th>
            <th>Comentário</th>
            <th>Criado em</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($salaryPayments as $payment)
            <tr>
              <td>{{ $payment->employee->fullName ?? '-' }}</td>
              <td>{{ $payment->baseSalary }}</td>
              <td>{{ $payment->subsidies }}</td>
              <td>{{ $payment->irtRate }}</td>
              <td>{{ $payment->inssRate }}</td>
              <td>{{ $payment->discount }}</td>
              <td>{{ $payment->salaryAmount }}</td>
              <td>{{ $payment->paymentDate }}</td>
              <td>{{ $payment->paymentStatus }}</td>
              <td>{{ $payment->paymentComment ?? '-' }}</td>
              <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
              <td>
                <a href="{{ route('salaryPayment.show', $payment->id) }}" class="btn btn-warning btn-sm" title="Visualizar">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('salaryPayment.edit', $payment->id) }}" class="btn btn-info btn-sm" title="Editar">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('salaryPayment.destroy', $payment->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" title="Deletar">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
