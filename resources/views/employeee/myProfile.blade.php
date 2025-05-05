@extends('layouts.admin.layout')
@section('title', 'Meu Perfil')
@section('content')

@php
  use App\Models\SalaryPayment;
  $latestPayment = SalaryPayment::where('employeeId', $employee->id)
                                ->orderByDesc('paymentDate')
                                ->first();
@endphp

<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-secondary text-white d-flex align-items-center">
          <i class="fas fa-user-circle me-2" style="font-size: 1.7rem;"></i>
          <h4 class="mb-0">Meu Perfil</h4>
        </div>
        <div class="card-body">
          @if(session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
          @endif

          <div class="row">
            <div class="col-md-4 text-center mb-3">
              @if($employee->photo)
                <img src="{{ asset('frontend/images/departments/' . $employee->photo) }}" 
                     class="img-fluid rounded-circle" 
                     style="width:150px; height:150px;">
              @else
                <i class="fas fa-user-circle text-secondary" style="font-size: 7rem;"></i>
              @endif
              <h5 class="mt-3">{{ $employee->fullName }}</h5>
            </div>

            <div class="col-md-8">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>Nome Completo</th>
                    <td>{{ $employee->fullName }}</td>
                  </tr>
                  <tr>
                    <th>E-mail</th>
                    <td>{{ $employee->email }}</td>
                  </tr>
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
                    <th>Telefone</th>
                    <td>
                      @if($employee->phone_code) {{ $employee->phone_code }} @endif {{ $employee->mobile }}
                    </td>
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
                    <th>Bilhete de Identidade</th>
                    <td>{{ $employee->bi }}</td>
                  </tr>
                  <tr>
                    <th>Cópia do BI</th>
                    <td>
                      @if($employee->biPhoto)
                        @if(Str::endsWith($employee->biPhoto, ['.pdf']))
                          <a href="{{ asset('frontend/images/biPhotos/'.$employee->biPhoto) }}" target="_blank">Ver Bilhete de Identidade</a>
                        @else
                          <img src="{{ asset('frontend/images/biPhotos/'.$employee->biPhoto) }}" style="max-width:150px;">
                        @endif
                      @else
                        -
                      @endif
                    </td>
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
  </div>
</div>

@endsection
