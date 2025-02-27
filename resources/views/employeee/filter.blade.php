@extends('layouts.layout')
@section('title', 'Filtrar Funcionários por Data')
@section('content')

<div class="card my-4 shadow">
  <!-- Cabeçalho com botão Voltar e, se houver filtro, botão PDF -->
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-calendar-event me-2"></i>Filtrar Funcionários por Data</span>
    <div>
      {{-- Se já existir um filtro aplicado (ou seja, se $start e $end existirem), exibimos o botão de PDF --}}
      @if(isset($start) && isset($end))
        <a href="{{ route('employeee.filter.pdf', ['start_date' => $start, 'end_date' => $end]) }}"
           class="btn btn-outline-light btn-sm me-2" title="Baixar PDF">
          <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
        </a>
      @endif

      <a href="{{ route('employeee.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
        <i class="bi bi-arrow-left"></i> Voltar
      </a>
    </div>
  </div>

  <div class="card-body">
    {{-- Formulário de Filtro --}}
    <form action="{{ route('employeee.filter') }}" method="GET" class="mb-4">
      <div class="row g-3">
        <div class="col-md-4">
          <div class="form-floating">
            <input type="date" name="start_date" class="form-control"
                   value="{{ old('start_date', request('start_date')) }}">
            <label for="start_date">Data Inicial</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-floating">
            <input type="date" name="end_date" class="form-control"
                   value="{{ old('end_date', request('end_date')) }}">
            <label for="end_date">Data Final</label>
          </div>
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-search"></i> Filtrar
          </button>
        </div>
      </div>
    </form>

    {{-- Tabela de resultados (caso exista variável $filtered) --}}
    @isset($filtered)
      @if($filtered->count() > 0)
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>Departamento</th>
                <th>Cargo</th>
                <th>Especialidade</th>
                <th>Tipo de Funcionario</th>
                <th>Data de Registro</th>
              </tr>
            </thead>
            <tbody>
              @foreach($filtered as $emp)
                <tr>
                  <td>{{ $emp->id }}</td>
                  <td>{{ $emp->fullName }}</td>
                  <td>{{ $emp->department->title ?? '-' }}</td>
                  <td>{{ $emp->position->name ?? '-' }}</td>
                  <td>{{ $emp->specialty->name ?? '-' }}</td>
                  <td>{{ $d->employeeType->name ?? '-' }}</td>
                  <td>{{ $emp->created_at->format('d/m/Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-center mt-4">Nenhum funcionário encontrado neste período.</p>
      @endif
    @endisset

  </div>
</div>

@endsection
