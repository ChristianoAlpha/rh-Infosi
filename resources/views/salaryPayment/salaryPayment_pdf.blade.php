@extends('layouts.pdf')
@section('pdfTitle', 'Salary Payments Report')
@section('titleSection')
  <h4>Salary Payments Report</h4>
  <p style="text-align: center;">
    <strong>Total Payments:</strong> <ins>{{ $salaryPayments->count() }}</ins>
  </p>
@endsection
@section('contentTable')
  @if($salaryPayments->count())
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Employee</th>
          <th>Salary Amount</th>
          <th>Payment Date</th>
          <th>Status</th>
          <th>Comment</th>
        </tr>
      </thead>
      <tbody>
        @foreach($salaryPayments as $payment)
          <tr>
            <td>{{ $payment->id }}</td>
            <td>{{ $payment->employee->fullName ?? '-' }}</td>
            <td>{{ $payment->salaryAmount }}</td>
            <td>{{ $payment->paymentDate }}</td>
            <td>{{ $payment->paymentStatus }}</td>
            <td>{{ $payment->paymentComment ?? '-' }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">No salary payments recorded.</p>
  @endif
@endsection
