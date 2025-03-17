@extends('layouts.layout')
@section('title', 'Salary Payment Details')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span>Salary Payment Details</span>
    <a href="{{ route('salaryPayment.index') }}" class="btn btn-outline-light btn-sm" title="Back">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th>Employee</th>
        <td>{{ $salaryPayment->employee->fullName ?? '-' }}</td>
      </tr>
      <tr>
        <th>Salary Amount</th>
        <td>{{ $salaryPayment->salaryAmount }}</td>
      </tr>
      <tr>
        <th>Payment Date</th>
        <td>{{ $salaryPayment->paymentDate }}</td>
      </tr>
      <tr>
        <th>Payment Status</th>
        <td>{{ $salaryPayment->paymentStatus }}</td>
      </tr>
      <tr>
        <th>Comment</th>
        <td>{{ $salaryPayment->paymentComment ?? '-' }}</td>
      </tr>
      <tr>
        <th>Created At</th>
        <td>{{ $salaryPayment->created_at->format('d/m/Y H:i') }}</td>
      </tr>
    </table>
  </div>
</div>
@endsection
