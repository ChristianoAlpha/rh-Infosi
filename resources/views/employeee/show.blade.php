@extends('layouts.admin.layout')
@section('title', 'Ver Funcionário')
@section('content')

<div class="card my-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="bi bi-eye me-2"></i>Ver Funcionário</span>
    <a href="{{ route('employeee.index') }}" class="btn btn-outline-light btn-sm" title="Ver Todos">
      <i class="bi bi-card-list"></i>
    </a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tr>
          <th>Departamento</th>
          <td>{{ $data->department->title ?? $data->departmentId }}</td>
        </tr>
        <tr>
          <th>Tipo de Funcionário</th>
          <td>{{ $data->employeeType->name ?? '-' }}</td>
        </tr>
        <tr>
          <th>Cargo</th>
          <td>{{ $data->position->name ?? $data->positionId }}</td>
        </tr>
        <tr>
          <th>Especialidade</th>
          <td>{{ $data->specialty->name ?? $data->specialtyId }}</td>
        </tr>
        <tr>
          <th>Nome Completo</th>
          <td>{{ $data->fullName }}</td>
        </tr>
        <tr>
          <th>Endereço</th>
          <td>{{ $data->address }}</td>
        </tr>
        <tr>
          <th>Telefone</th>
          <td>
            @if($data->phone_code) {{ $data->phone_code }} @endif {{ $data->mobile }}
          </td>
        </tr>
        <tr>
          <th>Nome do Pai</th>
          <td>{{ $data->fatherName }}</td>
        </tr>
        <tr>
          <th>Nome da Mãe</th>
          <td>{{ $data->motherName }}</td>
        </tr>
        <tr>
          <th>Bilhete de Identidade</th>
          <td>{{ $data->bi }}</td>
        </tr>
        <tr>
          <th>Cópia do BI</th>
          <td>
            @if($data->biPhoto)
              @if(Str::endsWith($data->biPhoto, ['.pdf']))
                <a href="{{ asset('frontend/images/biPhotos/'.$data->biPhoto) }}" target="_blank">Ver Bilhete de Identidade</a>
              @else
                <img src="{{ asset('frontend/images/biPhotos/'.$data->biPhoto) }}" style="max-width:200px;">
              @endif
            @else
              -
            @endif
          </td>
        </tr>
        <tr>
          <th>Data de Nascimento</th>
          <td>{{ $data->birth_date }}</td>
        </tr>
        <tr>
          <th>Nacionalidade</th>
          <td>{{ $data->nationality }}</td>
        </tr>
        <tr>
          <th>Gênero</th>
          <td>{{ $data->gender }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ $data->email }}</td>
        </tr>
        <tr>
          <th>IBAN</th>
          <td>{{ $data->iban ?? '-' }}</td>
        </tr>
      </table>
    </div>
  </div>
</div>

@endsection
