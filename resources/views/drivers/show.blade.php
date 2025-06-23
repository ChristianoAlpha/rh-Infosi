@extends('layouts.admin.layout')
@section('title','Driver Details')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">Driver #{{ $driver->id }}</div>
  <div class="card-body">
    <ul class="list-group">
      <li class="list-group-item"><strong>Employee:</strong> {{ $driver->employee->fullName ?? '-' }}</li>
      <li class="list-group-item"><strong>Full Name:</strong> {{ $driver->fullName ?? '-' }}</li>
      <li class="list-group-item"><strong>CPF:</strong> {{ $driver->cpf ?? '-' }}</li>
      <li class="list-group-item"><strong>License #:</strong> {{ $driver->licenseNumber }}</li>
      <li class="list-group-item"><strong>Category:</strong> {{ $driver->licenseCategory }}</li>
      <li class="list-group-item"><strong>Expiry:</strong> {{ $driver->licenseExpiry }}</li>
      <li class="list-group-item"><strong>Status:</strong> {{ $driver->status }}</li>
      <li class="list-group-item"><strong>Assigned Vehicles:</strong>
        @foreach($driver->vehicles as $v)
          <span class="badge bg-secondary">{{ $v->plate }} ({{ $v->pivot->startDate }}–{{ $v->pivot->endDate ?? 'now' }})</span>
        @endforeach
      </li>
    </ul>
  </div>
</div>

@endsection
