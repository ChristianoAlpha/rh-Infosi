@extends('layouts.pdf')
@section('pdfTitle', 'Relatório de Pagamentos de Salário')
@section('titleSection')
  <h4>Relatório de Pagamentos de Salário</h4>
  <p style="text-align: center;">
    <strong>Total de Pagamentos:</strong> <ins>{{ $salaryPayments->count() }}</ins>
  </p>
@endsection
@section('contentTable')
  @if($salaryPayments->count())
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Funcionário</th>
          <th>Sal. Básico</th>
          <th>Subsídios</th>
          <th>IRT (%)</th>
          <th>INSS (%)</th>
          <th>Desconto</th>
          <th>Sal. Líquido</th>
          <th>Data Pag.</th>
          <th>Status</th>
          <th>Comentário</th>
        </tr>
      </thead>
      <tbody>
        @foreach($salaryPayments as $payment)
          <tr>
            <td>{{ $payment->id }}</td>
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
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">Nenhum pagamento registrado.</p>
  @endif
@endsection
