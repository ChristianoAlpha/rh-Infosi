@extends('layouts.layout')
@section('title', 'Filtrar Estagiários por Data')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span>
      <i class="bi bi-calendar-event me-2"></i>
      Filtrar Estagiários por Data
    </span>

    <div>
      {{-- Botão Voltar para a listagem principal de Estagiários --}}
      <a href="{{ route('intern.index') }}" class="btn btn-outline-light btn-sm" title="Voltar">
        <i class="bi bi-arrow-left"></i> Voltar
      </a>

      {{-- Exibir o botão PDF SOMENTE se já existirem $start e $end (ou como você nomeou) --}}
      @if(isset($start) && isset($end))
        <a href="{{ route('intern.filter.pdf', ['start_date' => $start, 'end_date' => $end]) }}"
           class="btn btn-outline-light btn-sm ms-2"
           title="Baixar PDF deste Filtro">
          <i class="bi bi-file-earmark-pdf"></i> PDF
        </a>
      @endif
    </div>
  </div>

  <div class="card-body">
    {{-- Formulário de Filtro --}}
    <form action="{{ route('intern.filter') }}" method="GET" class="mb-4">
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

    {{-- Se já existir a variável $filtered, significa que foi feita a pesquisa --}}
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
                <th>Email</th>
                <th>Data de Registro</th>
              </tr>
            </thead>
            <tbody>
              @foreach($filtered as $intern)
                <tr>
                  <td>{{ $intern->id }}</td>
                  <td>{{ $intern->fullName }}</td>
                  <td>{{ $intern->department->title ?? '-' }}</td>
                  <td>{{ $intern->position->name ?? '-' }}</td>
                  <td>{{ $intern->specialty->name ?? '-' }}</td>
                  <td>{{ $intern->email }}</td>
                  <td>{{ $intern->created_at->format('d/m/Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-center mt-4">Nenhum estagiário encontrado neste período.</p>
      @endif
    @endisset

  </div>
</div>

@endsection
