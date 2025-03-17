@extends('layouts.layout')
@section('title', 'Edit Salary Payment')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <h4>Edit Salary Payment</h4>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('salaryPayment.update', $salaryPayment->id) }}">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label for="employeeId" class="form-label">Employee</label>
        <select name="employeeId" id="employeeId" class="form-select">
          <option value="">Select Employee</option>
          @foreach($employees as $employee)
            <option value="{{ $employee->id }}" @if($salaryPayment->employeeId == $employee->id) selected @endif>{{ $employee->fullName }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="salaryAmount" class="form-label">Salary Amount</label>
        <input type="number" step="0.01" name="salaryAmount" id="salaryAmount" class="form-control" value="{{ $salaryPayment->salaryAmount }}" required>
      </div>
      <div class="mb-3">
        <label for="paymentDate" class="form-label">Payment Date</label>
        <input type="date" name="paymentDate" id="paymentDate" class="form-control" value="{{ $salaryPayment->paymentDate }}">
      </div>
      <div class="mb-3">
        <label for="paymentStatus" class="form-label">Payment Status</label>
        <select name="paymentStatus" id="paymentStatus" class="form-select">
          <option value="Pending" @if($salaryPayment->paymentStatus == 'Pending') selected @endif>Pending</option>
          <option value="Completed" @if($salaryPayment->paymentStatus == 'Completed') selected @endif>Completed</option>
          <option value="Failed" @if($salaryPayment->paymentStatus == 'Failed') selected @endif>Failed</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="paymentComment" class="form-label">Comment</label>
        <textarea name="paymentComment" id="paymentComment" class="form-control">{{ $salaryPayment->paymentComment }}</textarea>
      </div>
      <button type="submit" class="btn btn-success w-100">
        <i class="bi bi-check-circle"></i> Update Payment
      </button>
    </form>
  </div>
</div>
@endsection
