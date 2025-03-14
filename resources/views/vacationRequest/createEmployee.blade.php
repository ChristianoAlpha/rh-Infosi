@extends('layouts.layout')
@section('title', 'Novo Pedido de Férias')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-umbrella-beach me-2"></i>Novo Pedido de Férias</span>
    <a href="{{ route('vacationRequest.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    <h5>Seus Dados:</h5>
    <p><strong>Nome:</strong> {{ $employee->fullName }}</p>
    <p><strong>Departamento:</strong> {{ $employee->department->title ?? '-' }}</p>

    <form method="POST" action="{{ route('vacationRequest.store') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="employeeId" value="{{ $employee->id }}">

      <!-- Linha: Tipo de Férias e Documento de Suporte lado a lado -->
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label for="vacationType" class="form-label">Tipo de Férias</label>
          <select name="vacationType" id="vacationType" class="form-select" required>
            <option value="">-- Selecione o Tipo de Férias --</option>
            @foreach($vacationTypes as $vt)
              <option value="{{ $vt }}" {{ old('vacationType') == $vt ? 'selected' : '' }}>{{ $vt }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label for="supportDocument" class="form-label">Documento de Suporte (opcional)</label>
          <input type="file" name="supportDocument" id="supportDocument" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,xlsx">
        </div>
      </div>

      <!-- Linha: Datas de Início e Fim -->
      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating">
            <input type="date" name="vacationStart" id="vacationStart" class="form-control" value="{{ old('vacationStart') }}" required>
            <label for="vacationStart">Data de Início</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <input type="date" name="vacationEnd" id="vacationEnd" class="form-control" value="{{ old('vacationEnd') }}" required>
            <label for="vacationEnd">Data de Fim</label>
          </div>
        </div>
      </div>

      <!-- Linha: Razão do Pedido centralizada -->
      <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
          <div class="mb-3">
            <label for="reason" class="form-label">Razão do Pedido</label>
            <textarea name="reason" id="reason" rows="4" class="form-control">{{ old('reason') }}</textarea>
          </div>
        </div>
      </div>

      <!-- Botão de Envio centralizado -->
      <div class="row">
        <div class="col text-center">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Enviar Pedido
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
