@extends('layouts.admin.layout')
@section('title','Edit Driver')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">Edit Driver #{{ $driver->id }}</div>
  <div class="card-body">
    <form action="{{ route('drivers.update',$driver->id) }}" method="POST">
      @csrf @method('PUT')

      <div class="row g-3">
        <div class="col-md-4">
          <div class="form-floating">
            <select name="employeeId" class="form-select">
              <option value="">Select Employee (optional)</option>
              @foreach($employees as $e)
                <option value="{{ $e->id }}"
                        @if(old('employeeId',$driver->employeeId)==$e->id) selected @endif>
                  {{ $e->fullName }}
                </option>
              @endforeach
            </select>
            <label>Employee</label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating">
            <input type="text" name="fullName" class="form-control" placeholder="Full Name"
                   value="{{ old('fullName',$driver->fullName) }}">
            <label>Full Name</label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating">
            <input type="text" name="cpf" class="form-control" placeholder="CPF"
                   value="{{ old('cpf',$driver->cpf) }}">
            <label>CPF</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <div class="form-floating">
            <input type="text" name="licenseNumber" class="form-control" placeholder="License Number"
                   value="{{ old('licenseNumber',$driver->licenseNumber) }}">
            <label>License Number</label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating">
            <select name="licenseCategory" class="form-select">
              @foreach(['A','B','C','D','E'] as $cat)
                <option value="{{ $cat }}"
                        @if(old('licenseCategory',$driver->licenseCategory)==$cat) selected @endif>
                  {{ $cat }}
                </option>
              @endforeach
            </select>
            <label>License Category</label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating">
            <input type="date" name="licenseExpiry" class="form-control" placeholder="License Expiry"
                   value="{{ old('licenseExpiry',$driver->licenseExpiry) }}">
            <label>License Expiry</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <div class="form-floating">
            <select name="status" class="form-select">
              <option value="Active" @if(old('status',$driver->status)=='Active') selected @endif>Active</option>
              <option value="Inactive" @if(old('status',$driver->status)=='Inactive') selected @endif>Inactive</option>
            </select>
            <label>Status</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-4 mx-auto mt-4">
        <button class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Update Driver
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
