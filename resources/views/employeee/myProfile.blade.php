@extends('layouts.admin.layout')
@section('title', 'Meu Perfil')
@section('content')

@php
use App\Models\SalaryPayment;
$latestPayment = SalaryPayment::where('employeeId', $employee->id)
    ->orderByDesc('paymentDate')
    ->first();
@endphp

<div class="container my-5">

  {{-- Mensagem de sucesso --}}
  @if(session('msg'))
    <div class="row justify-content-center mb-4">
      <div class="col-md-6">
        <div class="alert alert-success text-center">{{ session('msg') }}</div>
      </div>
    </div>
  @endif

  {{-- Linha com foto+nome ao lado do card de info pessoal --}}
  <div class="row justify-content-center mb-5 align-items-center">
    {{-- Coluna da foto e nome --}}
    <div class="col-md-4 text-center">
      @if($employee->photo)
        <img src="{{ asset('frontend/images/departments/' . $employee->photo) }}"
             class="img-fluid rounded-circle border"
             style="width:160px; height:160px; object-fit:cover;">
      @else
        <i class="fas fa-user-circle text-secondary" style="font-size:9rem;"></i>
      @endif
      <h4 class="mt-3">{{ $employee->fullName }}</h4>
    </div>

    {{-- Coluna do card de Informações Pessoais Curto --}}
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white text-center">
          <strong>Informações Pessoais</strong>
        </div>
        <div class="card-body">
          <table class="table table-borderless mb-0">
            <tbody>
              <tr>
                <th class="ps-0">E-mail</th>
                <td>{{ $employee->email }}</td>
              </tr>
              <tr>
                <th class="ps-0">Telefone</th>
                <td>
                  @if($employee->phone_code) {{ $employee->phone_code }} @endif
                  {{ $employee->mobile }}
                </td>
              </tr>
              <tr>
                <th class="ps-0">Bilhete de Identidade</th>
                <td>{{ $employee->bi }}</td>
              </tr>
              <tr>
                <th class="ps-0">Cópia do BI</th>
                <td>
                  @if($employee->biPhoto)
                    @if(Str::endsWith($employee->biPhoto, ['.pdf']))
                      <a href="{{ asset('frontend/images/biPhotos/'.$employee->biPhoto) }}"
                         target="_blank">Ver PDF do BI</a>
                    @else
                      <img src="{{ asset('frontend/images/biPhotos/'.$employee->biPhoto) }}"
                           style="max-width:100px; border:1px solid #dee2e6; border-radius:4px;">
                    @endif
                  @else
                    -
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Card de Demais Informações --}}
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white text-center">
          <strong>Detalhes Adicionais</strong>
        </div>
        <div class="card-body px-4">
          <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <th>Departamento</th>
                <td>{{ $employee->department->title ?? '-' }}</td>
              </tr>
              <tr>
                <th>Cargo</th>
                <td>{{ $employee->position->name ?? '-' }}</td>
              </tr>
              <tr>
                <th>Tipo de Funcionário</th>
                <td>{{ $employee->employeeType->name ?? '-' }}</td>
              </tr>
              <tr>
                <th>Nome do Pai</th>
                <td>{{ $employee->fatherName }}</td>
              </tr>
              <tr>
                <th>Nome da Mãe</th>
                <td>{{ $employee->motherName }}</td>
              </tr>
              <tr>
                <th>Data de Nascimento</th>
                <td>{{ \Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y') }}</td>
              </tr>
              <tr>
                <th>Nacionalidade</th>
                <td>{{ $employee->nationality }}</td>
              </tr>
              <tr>
                <th>Gênero</th>
                <td>{{ $employee->gender }}</td>
              </tr>
              <tr>
                <th>IBAN</th>
                <td>{{ $employee->iban }}</td>
              </tr>
              <tr>
                <th>Último Salário Recebido</th>
                <td>
                  @if($latestPayment)
                    {{ number_format($latestPayment->salaryAmount, 2, ',', '.') }}
                  @else
                    -
                  @endif
                </td>
              </tr>
              <tr>
                <th>Data do Último Pagamento</th>
                <td>
                  @if($latestPayment)
                    {{ \Carbon\Carbon::parse($latestPayment->paymentDate)->format('d-m-Y') }}
                  @else
                    -
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
