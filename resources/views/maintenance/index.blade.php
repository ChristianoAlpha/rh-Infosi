@extends('layouts.admin.layout')
@section('title','Maintenance')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-tools me-2"></i>Maintenance Records</span>
    <a href="{{ route('maintenance.create') }}" class="btn btn-outline-light btn-sm">
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
            <th>Vehicle</th>
            <th>Type</th>
            <th>Date</th>
            <th>Cost</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($records as $r)
            <tr>
              <td>{{ $r->id }}</td>
              <td>{{ $r->vehicle->plate }}</td>
              <td>{{ $r->type }}</td>
              <td>{{ $r->maintenanceDate }}</td>
              <td>{{ $r->cost }}</td>
              <td>{{ Str::limit($r->description,30) }}</td>
              <td>
                <a href="{{ route('maintenance.show',$r->id) }}" class="btn btn-warning btn-sm">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('maintenance.edit',$r->id) }}" class="btn btn-info btn-sm">
                  <i class="bi bi-pencil"></i>
                </a>
                <a href="#" data-url="{{ url('maintenance/'.$r->id.'/delete') }}"
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
