
@extends('layouts.admin.layout')
@section('title','Pagamentos de Salário')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-money-bill-wave me-2"></i> Pagamentos de Salário</span>
    <div>
      <a href="{{ route('salaryPayment.pdfAll') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
      <a href="{{ route('salaryPayment.create') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-plus-circle"></i> Novo</a>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Competência</th>
            <th>Funcionário</th>
            <th>IBAN</th>
            <th>Sal. Básico</th>
            <th>Subsídios</th>
            <th>Desconto</th>
            <th>Sal. Líquido</th>
            <th>Pagamento</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($salaryPayments as $p)
          <tr>
            <td>{{ \Carbon\Carbon::parse($p->workMonth)->translatedFormat('F/Y') }}</td>
            <td>{{ $p->employee->fullName }}</td>
            <td>{{ $p->employee->iban }}</td>
            <td>{{ $p->baseSalary }}</td>
            <td>{{ $p->subsidies }}</td>
            <td>{{ $p->discount }}</td>
            <td>{{ $p->salaryAmount }}</td>
            <td>{{ $p->paymentDate }}</td>
            <td>{{ $p->paymentStatus }}</td>
            <td>
              <a href="{{ route('salaryPayment.show',$p->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-eye"></i></a>
              <a href="{{ route('salaryPayment.edit',$p->id) }}" class="btn btn-sm btn-info"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('salaryPayment.destroy',$p->id) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection