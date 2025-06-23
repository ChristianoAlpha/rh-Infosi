@extends('layouts.admin.layout')
@section('title','Edit Maintenance')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">Edit Maintenance #{{ $maintenance->id }}</div>
  <div class="card-body">
    <form action="{{ route('maintenance.update',$maintenance->id) }}" method="POST">
      @csrf @method('PUT')

      <div class="row g-3">
        <div class="col-md-4">
          <div class="form-floating">
            <select name="vehicleId" class="form-select">
              @foreach($vehicles as $v)
                <option value="{{ $v->id }}"
                  @if(old('vehicleId',$maintenance->vehicleId)==$v->id) selected @endif>
                  {{ $v->plate }}
                </option>
              @endforeach
            </select>
            <label>Vehicle</label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating">
            <select name="type" class="form-select">
              @foreach(['Preventive','Corrective'] as $t)
                <option value="{{ $t }}"
                  @if(old('type',$maintenance->type)==$t) selected @endif>
                  {{ $t }}
                </option>
              @endforeach
            </select>
            <label>Type</label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating">
            <input type="date" name="maintenanceDate" class="form-control"
                   value="{{ old('maintenanceDate',$maintenance->maintenanceDate) }}">
            <label>Date</label>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <div class="form-floating">
            <input type="number" step="0.01" name="cost" class="form-control"
                   value="{{ old('cost',$maintenance->cost) }}">
            <label>Cost</label>
          </div>
        </div>

        <div class="col-md-8">
          <div class="form-floating">
            <textarea name="description" class="form-control" style="height:58px">{{ old('description',$maintenance->description) }}</textarea>
            <label>Description</label>
          </div>
        </div>
      </div>

      <div class="d-grid gap-2 col-4 mx-auto mt-4">
        <button class="btn btn-primary btn-lg">
          <i class="bi bi-check-circle me-2"></i>Update
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
