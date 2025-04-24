@extends('layouts.admin.pdf')

@section('pdfTitle', 'Detalhes do Trabalho Extra')

@section('titleSection')
  <h4>{{ $job->title }}</h4>
  <p><strong>Valor Total:</strong> {{ number_format($job->totalValue,2,',','.') }}</p>
<ins>_______________________________________________________________________________</ins>
@endsection

@section('contentTable')
  <h5>Distribuição</h5>
  <table>
    <thead>
      <tr><th>Funcionário</th><th>Ajuste (Kz)</th><th>Recebe (Kz)</th></tr>
    </thead>
    <tbody>
      @foreach($job->employees as $e)
      <tr>
        <td>{{ $e->fullName }}</td>
        <td>{{ number_format($e->pivot->bonusAdjustment,2,',','.') }}</td>
        <td>{{ number_format($e->pivot->assignedValue,2,',','.') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
