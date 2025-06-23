@extends('layouts.admin.layout')
@section('title','New Driver')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="bi bi-person-badge me-2"></i>New Driver
  </div>
  <div class="card-body">
    <form action="{{ route('drivers.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-4">
          <div class="form-floating">
            <select name="employeeId" class="form-select">
              <option value="">Select Employee (optional)</option>
              @foreach($employees as $e)
                <option value="{{ $e->id }}">{{ $e->fullName }}</option>
              @endforeach
            </select>
            <label>Employee</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input type="text" name="fullName" class="form-control" placeholder="Full Name" value="{{ old('fullName') }}">
            <label>Full Name</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input type="text" name="cpf" class="form-control" placeholder="CPF" value="{{ old('cpf') }}">
            <label>CPF</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <div class="form-floating">
            <input type="text" name="licenseNumber" class="form-control" placeholder="License Number" value="{{ old('licenseNumber') }}">
            <label>License Number</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <select name="licenseCategory" class="form-select">
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
              <option value="E">E</option>
            </select>
            <label>License Category</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input type="date" name="licenseExpiry" class="form-control" placeholder="License Expiry" value="{{ old('licenseExpiry') }}">
            <label>License Expiry</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <div class="form-floating">
            <select name="status" class="form-select">
              <option value="Active" selected>Active</option>
              <option value="Inactive">Inactive</option>
            </select>
            <label>Status</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-4 mx-auto mt-4">
        <button class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Create Driver
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
