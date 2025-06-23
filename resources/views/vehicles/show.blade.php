@extends('layouts.admin.layout')
@section('title','Vehicle Details')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white">Vehicle Nº{{ $vehicle->id }}</div>
  <div class="card-body">
    <ul class="list-group">
      <li class="list-group-item"><strong>Matricula:</strong> {{ $vehicle->plate }}</li>
      <li class="list-group-item"><strong>Modelo:</strong> {{ $vehicle->model }}</li>
      <li class="list-group-item"><strong>Marca:</strong> {{ $vehicle->brand }}</li>
      <li class="list-group-item"><strong>Status:</strong> {{ $vehicle->status }}</li>
      <li class="list-group-item"><strong>Condutores:</strong>
        @foreach($vehicle->drivers as $d)
          <span class="badge bg-secondary">{{ $d->fullName }} ({{ $d->pivot->startDate }} to {{ $d->pivot->endDate ?? 'now' }})</span>
        @endforeach
      </li>
      <li class="list-group-item"><strong>
      Registros de manutenção:</strong>
        <ul>
          @foreach($vehicle->maintenance as $m)
            <li>{{ $m->maintenanceDate }} – {{ $m->type }} – {{ $m->cost }}</li>
          @endforeach
        </ul>
      </li>
      <li class="list-group-item"><strong>Notas:</strong> {{ $vehicle->notes }}</li>
    </ul>
  </div>
</div>

@endsection
