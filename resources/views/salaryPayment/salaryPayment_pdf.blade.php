@extends('layouts.admin.pdf')
@section('pdfTitle','Relatório de Pagamentos')
@section('titleSection')
  <h4>Relatório de Pagamentos de Salário</h4>
  <p style="text-align:center"><strong>Total:</strong> <ins>{{ $salaryPayments->count() }}</ins></p>
@endsection
@section('contentTable')
  @if($salaryPayments->count())
    <table>
      <thead>
        <tr>
          <th>Competência</th>
          <th>Funcionario</th>
          <th>Base</th>
          <th>Subsídios</th>
          <th>Desconto</th>
          <th>Líquido</th>
          <th>Data Pag.</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($salaryPayments as $p)
        <tr>
          <td>{{ \Carbon\Carbon::parse($p->workMonth)->translatedFormat('F/Y') }}</td>
          <td>{{ $p->employee->fullName }}</td>
          <td>{{ $p->baseSalary }}</td>
          <td>{{ $p->subsidies }}</td>
          <td>{{ $p->discount }}</td>
          <td>{{ $p->salaryAmount }}</td>
          <td>{{ $p->paymentDate }}</td>
          <td>{{ $p->paymentStatus }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align:center">Nenhum pagamento registrado.</p>
  @endif
@endsection