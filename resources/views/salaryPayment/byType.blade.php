@extends('layouts.layout')
@section('title','Pagamentos por Tipo')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <h4>Pagamentos por Tipo de Funcionário</h4>
  </div>
  <div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="efetivos-tab" data-bs-toggle="tab" data-bs-target="#efetivos-pane" type="button" role="tab">Efetivos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contratados-tab" data-bs-toggle="tab" data-bs-target="#contratados-pane" type="button" role="tab">Contratados</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="outros-tab" data-bs-toggle="tab" data-bs-target="#outros-pane" type="button" role="tab">Outros</button>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">
      <!-- Efetivos -->
      <div class="tab-pane fade show active mt-3" id="efetivos-pane" role="tabpanel">
        @include('salaryPayment._partial_table', ['payments' => $efetivos])
      </div>

      <!-- Contratados -->
      <div class="tab-pane fade mt-3" id="contratados-pane" role="tabpanel">
        @include('salaryPayment._partial_table', ['payments' => $contratados])
      </div>

      <!-- Outros -->
      <div class="tab-pane fade mt-3" id="outros-pane" role="tabpanel">
        @include('salaryPayment._partial_table', ['payments' => $outros])
      </div>
    </div>
  </div>
</div>
@endsection
