@extends('layouts.admin.pdf')

@section('content')
  <h2>Movimentações — {{ ucfirst($category) }}</h2>

  <table style="width:100%; border-collapse: collapse; margin-top:10px;">
    <thead>
      <tr>
        <th style="border:1px solid #000; padding:4px;">Tipo</th>
        <th style="border:1px solid #000; padding:4px;">Material</th>
        <th style="border:1px solid #000; padding:4px;">Qtde</th>
        <th style="border:1px solid #000; padding:4px;">Data</th>
        <th style="border:1px solid #000; padding:4px;">Origem/Dest.</th>
        <th style="border:1px solid #000; padding:4px;">Responsável</th>
        <th style="border:1px solid #000; padding:4px;">Doc.</th>
        <th style="border:1px solid #000; padding:4px;">Obs.</th>
      </tr>
    </thead>
    <tbody>
      @foreach($txs as $t)
      <tr>
        <td style="border:1px solid #000; padding:4px;">
          {{ $t->TransactionType=='in' ? 'Entrada' : 'Saída' }}
        </td>
        <td style="border:1px solid #000; padding:4px;">{{ $t->material->Name }}</td>
        <td style="border:1px solid #000; padding:4px;">{{ $t->Quantity }}</td>
        <td style="border:1px solid #000; padding:4px;">
          {{ \Carbon\Carbon::parse($t->TransactionDate)->format('d/m/Y') }}
        </td>
        <td style="border:1px solid #000; padding:4px;">
          {{ $t->TransactionType=='in'
              ? $t->SupplierName
              : $t->department->title }}
        </td>
        <td style="border:1px solid #000; padding:4px;">{{ $t->creator->fullName }}</td>
        <td style="border:1px solid #000; padding:4px;">
          @if($t->Documentation) OK @else — @endif
        </td>
        <td style="border:1px solid #000; padding:4px;">{{ $t->Notes }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div style="margin-top:30px;">
    <div style="margin-top:40px;">
      _______________________________<br>
      Assinatura do Chefe de Departamento
    </div>
    <div style="margin-top:40px;">
      _______________________________<br>
      Assinatura do Fornecedor
    </div>
  </div>
@endsection
