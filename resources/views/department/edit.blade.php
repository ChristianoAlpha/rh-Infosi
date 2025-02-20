@extends('layout')
@section('title', 'Atualizar departamento')
@section('content')

<div class="card mb-4 mt-4">
  <div class="card-header">
    <i class="fas fa-table me-1"></i>
    Atualizar departamento

    <a href="{{ asset('depart') }}" class="float-end btn btn-sm btn-info">Ver todos</a>
  </div>  
  <div class="card-body">
    {{-- Mensagens de erro --}}
    @if ($errors->any())
      @foreach($errors->all() as $error)
        <p class="text-danger">{{ $error }}</p>
      @endforeach
    @endif

    @if (Session::has('msg'))
      <p class="text-success">{{ session('msg') }}</p>
    @endif

    <form method="POST" action="{{ asset('depart/'.$data->id) }}"> 
      @method('PUT')
      @csrf
      <table class="table table-bordered">
        <tr>
          <th>Title</th>
          <td>
            <input type="text" value="{{ $data->title }}" name="title" class="form-control">
          </td>
        </tr>
        <tr>
          <th>Descrição</th>
          <td>
            <textarea name="description" class="form-control" rows="3">{{ $data->description }}</textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" class="btn btn-primary" value="Atualizar">
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

@endsection
