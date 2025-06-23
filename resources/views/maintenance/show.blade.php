@extends('layouts.admin.layout')
@section('title','Maintenance Details')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">Maintenance #{{ $maintenance->id }}</div>
  <div class="card-body">
    <ul class="list-group">
      <li class="list-group-item"><strong>Vehicle:</strong> {{ $maintenance->vehicle->plate }}</li>
      <li class="list-group-item"><strong>Type:</strong> {{ $maintenance->type }}</li>
      <li class="list-group-item"><strong>Date:</strong> {{ $maintenance->maintenanceDate }}</li>
      <li class="list-group-item"><strong>Cost:</strong> {{ $maintenance->cost }}</li>
      <li class="list-group-item"><strong>Description:</strong> {{ $maintenance->description }}</li>
    </ul>
  </div>
</div>

@endsection
