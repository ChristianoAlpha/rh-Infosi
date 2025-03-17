@extends('layouts.layout')
@section('title', 'Salary Payments')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-money-bill-wave me-2"></i>Salary Payments</span>
    <div>
      <a href="{{ route('salaryPayment.pdfAll') }}" class="btn btn-outline-light btn-sm" title="Download PDF">
        <i class="bi bi-file-earmark-pdf"></i> Download PDF
      </a>
      <a href="{{ route('salaryPayment.create') }}" class="btn btn-outline-light btn-sm" title="Add New Payment">
        <i class="bi bi-plus-circle"></i> Add New
      </a>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Salary Amount</th>
            <th>Payment Date</th>
            <th>Payment Status</th>
            <th>Comment</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($salaryPayments as $payment)
          <tr>
            <td>{{ $payment->employee->fullName ?? '-' }}</td>
            <td>{{ $payment->salaryAmount }}</td>
            <td>{{ $payment->paymentDate }}</td>
            <td>{{ $payment->paymentStatus }}</td>
            <td>{{ $payment->paymentComment ?? '-' }}</td>
            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
            <td>
              <a href="{{ route('salaryPayment.show', $payment->id) }}" class="btn btn-warning btn-sm" title="View">
                <i class="bi bi-eye"></i>
              </a>
              <a href="{{ route('salaryPayment.edit', $payment->id) }}" class="btn btn-info btn-sm" title="Edit">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('salaryPayment.destroy', $payment->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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
