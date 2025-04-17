{{-- resources/views/retirement/retirement_pdf.blade.php --}}
@extends('layouts.admin.pdf')

@section('pdfTitle', 'Relatório de Reformas')

@section('titleSection')
  <h4>Relatório de Reformas</h4>
  <p style="text-align: center;">
    <strong>Total de Pedidos de Reforma:</strong> <ins>{{ $allRetirements->count() }}</ins>
  </p>
@endsection

@section('contentTable')
  @if($allRetirements->count())
    <table>
      <thead>
        <tr>
          <th style="padding: 8px; border: 1px solid #000;">ID</th>
          <th style="padding: 8px; border: 1px solid #000;">Funcionário</th>
          <th style="padding: 8px; border: 1px solid #000;">Status</th>
          <th style="padding: 8px; border: 1px solid #000;">Observações</th>
          <th style="padding: 8px; border: 1px solid #000;">Registro</th>
        </tr>
      </thead>
      <tbody>
        @foreach($allRetirements as $retire)
          <tr>
            <td style="padding: 8px; border: 1px solid #000;">{{ $retire->id }}</td>
            <td style="padding: 8px; border: 1px solid #000;">{{ $retire->employee->fullName ?? '-' }}</td>
            <td style="padding: 8px; border: 1px solid #000;">{{ $retire->status }}</td>
            <td style="padding: 8px; border: 1px solid #000;">{{ $retire->observations ?? '-' }}</td>
            <td style="padding: 8px; border: 1px solid #000;">{{ $retire->created_at->format('d/m/Y H:i') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p style="text-align: center;">Nenhum pedido de reforma registrado.</p>
  @endif
@endsection
