@extends('layouts.layout')
@section('title', 'Editar Pedido de Férias')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-umbrella-beach me-2"></i>Editar Pedido de Férias</span>
        <a href="{{ route('vacationRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
          <i class="bi bi-arrow-left"></i> Voltar
        </a>
      </div>
      <div class="card-body">
        <form action="{{ route('vacationRequest.update', $data->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="vacationType" class="form-label">Tipo de Férias</label>
            <select name="vacationType" id="vacationType" class="form-select" required>
              <option value="">-- Selecione o Tipo --</option>
              @foreach(['15 dias', '30 dias', '22 dias úteis', '11 dias úteis'] as $vt)
                <option value="{{ $vt }}" {{ $data->vacationType == $vt ? 'selected' : '' }}>{{ $vt }}</option>
              @endforeach
            </select>
          </div>
          <div class="row g-2">
            <div class="col-6">
              <div class="form-floating">
                <input type="date" name="vacationStart" id="vacationStart" class="form-control" value="{{ $data->vacationStart }}" required>
                <label for="vacationStart">Data de Início</label>
              </div>
            </div>
            <div class="col-6">
              <div class="form-floating">
                <input type="date" name="vacationEnd" id="vacationEnd" class="form-control" value="{{ $data->vacationEnd }}" required>
                <label for="vacationEnd">Data de Fim</label>
              </div>
            </div>
          </div>
          <div class="mb-3 mt-2">
            <label for="reason" class="form-label">Razão do Pedido</label>
            <textarea name="reason" id="reason" rows="3" class="form-control">{{ $data->reason }}</textarea>
          </div>
          <div class="mb-3">
            <label for="supportDocument" class="form-label">Documento de Suporte (opcional)</label>
            <input type="file" name="supportDocument" id="supportDocument" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
            @if($data->supportDocument)
              <p class="mt-2">Documento Atual: <a href="{{ asset('storage/' . $data->supportDocument) }}" target="_blank">{{ $data->originalFileName }}</a></p>
            @endif
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success">
              <i class="bi bi-check-circle"></i> Atualizar Pedido
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
