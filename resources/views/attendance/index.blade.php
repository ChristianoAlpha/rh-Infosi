@extends('layouts.layout')
@section('title', 'Registros de Presença')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-list me-2"></i>Registros de Presença</span>
    <a href="{{ route('attendance.create') }}" class="btn btn-outline-light btn-sm" title="Novo Registro">
      <i class="bi bi-plus-circle"></i> Novo Registro
    </a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Funcionário</th>
            <th>Data</th>
            <th>Status</th>
            <th>Observações</th>
            <th>Criado em</th>
          </tr>
        </thead>
        <tbody>
          @foreach($records as $record)
            <tr>
              <td>{{ $record->id }}</td>
              <td>{{ $record->employee->fullName ?? '-' }}</td>
              <td>{{ \Carbon\Carbon::parse($record->recordDate)->format('d/m/Y') }}</td>
              <td>{{ $record->status }}</td>
              <td>{{ $record->observations ?? '-' }}</td>
              <td>{{ $record->created_at->format('d/m/Y H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
