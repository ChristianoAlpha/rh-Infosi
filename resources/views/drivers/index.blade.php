@extends('layouts.admin.layout')
@section('title','Drivers')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-person-badge me-2"></i>All Drivers</span>
    <a href="{{ route('drivers.create') }}" class="btn btn-outline-light btn-sm">
      <i class="bi bi-plus-circle"></i> New
    </a>
  </div>
  <div class="card-body">
    @if(session('msg'))
      <div class="alert alert-success">{{ session('msg') }}</div>
    @endif
    <div class="table-responsive">
      <table id="datatablesSimple" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>CPF</th>
            <th>License #</th>
            <th>Category</th>
            <th>Expiry</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($drivers as $d)
            <tr>
              <td>{{ $d->id }}</td>
              <td>{{ $d->employee ? $d->employee->fullName : $d->fullName }}</td>
              <td>{{ $d->cpf ?? '-' }}</td>
              <td>{{ $d->licenseNumber }}</td>
              <td>{{ $d->licenseCategory }}</td>
              <td>{{ $d->licenseExpiry }}</td>
              <td>{{ $d->status }}</td>
              <td>
                <a href="{{ route('drivers.show',$d->id) }}" class="btn btn-warning btn-sm">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('drivers.edit',$d->id) }}" class="btn btn-info btn-sm">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="#" data-url="{{ url('drivers/'.$d->id.'/delete') }}"
                   class="btn btn-danger btn-sm delete-btn">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
