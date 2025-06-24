@extends('layouts.admin.layout')
@section('title','Ver Manutenção')
@section('content')

<div class="container my-5">

  {{-- Cabeçalho com voltar e PDF --}}
  <div class="row mb-4">
    <div class="col-8">
      <h3><i class="bi bi-tools me-2"></i>Ver Manutenção Nº{{ $maintenance->id }}</h3>
    </div>
    <div class="col-4 text-end">
      <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary btn-sm me-2">
        <i class="bi bi-arrow-left"></i> Voltar
      </a>
      <a href="{{ route('maintenance.showPdf', $maintenance->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">
        <i class="bi bi-download"></i> Baixar PDF
      </a>
    </div>
  </div>

  {{-- Detalhes --}}
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white text-center">
          <strong>Detalhes da Manutenção</strong>
        </div>
        <div class="card-body">
          <table class="table table-striped table-borderless mb-0">
            <tbody>
              <tr>
                <th class="ps-0">Viatura</th>
                <td>{{ $maintenance->vehicle->plate }}</td>
              </tr>
              <tr>
                <th class="ps-0">Tipo</th>
                <td>{{ $maintenance->type }}</td>
              </tr>
              <tr>
                <th class="ps-0">Data</th>
                <td>{{ \Carbon\Carbon::parse($maintenance->maintenanceDate)->format('d/m/Y') }}</td>
              </tr>
              <tr>
                <th class="ps-0">Custo</th>
                <td>{{ number_format($maintenance->cost,2,',','.') }}</td>
              </tr>
              <tr>
                <th class="ps-0">Descrição</th>
                <td>{{ $maintenance->description }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
