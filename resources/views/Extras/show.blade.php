@extends('layouts.admin.layout')
@section('title','Detalhes do Trabalho Extra')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <h4>{{ $job->title }}</h4>
    <div>
      <a href="{{ route('extras.pdfShow', $job->id) }}" class="btn btn-outline-light btn-sm me-2" title="Baixar PDF" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
      </a>
      <a href="{{ route('extras.index') }}" class="btn btn-outline-light btn-sm">Voltar</a>
    </div>
  </div>
  <div class="card-body">
    <p><strong>Valor Total:</strong> {{ number_format($job->totalValue,2,',','.') }}</p>
    <h5>Distribuição</h5>
    <table class="table">
      <thead><tr><th>Funcionário</th><th>Ajus. (Kz)</th><th>Recebe (Kz)</th></tr></thead>
      <tbody>
        @foreach($job->employees as $e)
        <tr>
          <td>{{ $e->fullName }}</td>
          <td>{{ number_format($e->pivot->bonusAdjustment,2,',','.') }}</td>
          <td>{{ number_format($e->pivot->assignedValue,2,',','.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
