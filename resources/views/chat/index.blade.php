@extends('layouts.admin.layout')

@section('title', 'Chat')
@section('content')
<div class="card my-4">
  <div class="card-header">
    <h4>Conversas</h4>
  </div>
  <div class="card-body">
    <!-- Abas dinâmicas baseadas no tipo de grupo -->
    <ul class="nav nav-tabs" id="chatTab" role="tablist">
      @if($directorGroup->isNotEmpty())
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="director-tab" data-bs-toggle="tab" data-bs-target="#tab-director" type="button">
          Diretores
        </button>
      </li>
      @endif
      @if($departmentGroups->isNotEmpty())
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ $directorGroup->isEmpty() ? 'active' : '' }}" id="dept-tab" data-bs-toggle="tab" data-bs-target="#tab-dept" type="button">
          Departamento
        </button>
      </li>
      @endif
      @if($individuals->isNotEmpty())
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ $directorGroup->isEmpty() && $departmentGroups->isEmpty() ? 'active' : '' }}" id="individual-tab" data-bs-toggle="tab" data-bs-target="#tab-individual" type="button">
          Individual
        </button>
      </li>
      @endif
    </ul>

    <div class="tab-content mt-3">
      @if($directorGroup->isNotEmpty())
      <div class="tab-pane fade show active" id="tab-director">
        <ul class="list-group">
          @foreach($directorGroup as $g)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('chat.show', $g->id) }}">{{ $g->name }}</a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @endif

      @if($departmentGroups->isNotEmpty())
      <div class="tab-pane fade {{ $directorGroup->isEmpty() ? 'show active' : '' }}" id="tab-dept">
        <ul class="list-group">
          @foreach($departmentGroups as $g)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('chat.show', $g->id) }}">{{ $g->name }}</a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @endif

      @if($individuals->isNotEmpty())
      <div class="tab-pane fade {{ $directorGroup->isEmpty() && $departmentGroups->isEmpty() ? 'show active' : '' }}" id="tab-individual">
        <ul class="list-group">
          @foreach($individuals as $g)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('chat.show', $g->id) }}">{{ $g->name }}</a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @endif

      @if($directorGroup->isEmpty() && $departmentGroups->isEmpty() && $individuals->isEmpty())
        <p class="mt-3">Não há conversas disponíveis.</p>
      @endif
    </div>
  </div>
</div>
@endsection
