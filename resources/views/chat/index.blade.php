@extends('layouts.admin.layout')
@section('title','Chat')
@section('content')
<div class="card my-4">
  <div class="card-header"><h4>Conversas</h4></div>
  <div class="card-body">
    <ul class="nav nav-tabs">
      @if($directorGroup->isNotEmpty())
      <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-director">
          Diretores
        </button>
      </li>
      @endif
      @if($departmentGroups->isNotEmpty())
      <li class="nav-item">
        <button class="nav-link {{ $directorGroup->isEmpty()?'active':'' }}"
                data-bs-toggle="tab" data-bs-target="#tab-dept">
          Departamento
        </button>
      </li>
      @endif
      @if($individuals->isNotEmpty())
      <li class="nav-item">
        <button class="nav-link {{ $directorGroup->isEmpty()&&$departmentGroups->isEmpty()?'active':'' }}"
                data-bs-toggle="tab" data-bs-target="#tab-individual">
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
          <li class="list-group-item d-flex justify-content-between">
            <a href="{{ route('chat.show',$g->id) }}">{{ $g->name }}</a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @endif

      @if($departmentGroups->isNotEmpty())
      <div class="tab-pane fade {{ $directorGroup->isEmpty()?'show active':'' }}" id="tab-dept">
        <ul class="list-group">
          @foreach($departmentGroups as $g)
          <li class="list-group-item d-flex justify-content-between">
            <a href="{{ route('chat.show',$g->id) }}">{{ $g->name }}</a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @endif

      @if($individuals->isNotEmpty())
      <div class="tab-pane fade {{ $directorGroup->isEmpty()&&$departmentGroups->isEmpty()?'show active':'' }}"
           id="tab-individual">
        <ul class="list-group">
          @foreach($individuals as $g)
          <li class="list-group-item d-flex justify-content-between">
            <a href="{{ route('chat.show',$g->id) }}">{{ $g->name }}</a>
            <span class="badge bg-primary">{{ $g->messages()->count() }}</span>
          </li>
          @endforeach
        </ul>
      </div>
      @endif

      @if($directorGroup->isEmpty() && $departmentGroups->isEmpty() && $individuals->isEmpty())
        <p>Não há conversas disponíveis.</p>
      @endif
    </div>
  </div>
</div>
@endsection
