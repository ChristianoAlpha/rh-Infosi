@if($payments->count())
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Funcionário</th>
        <th>Valor (Kz)</th>
        <th>Data Pagamento</th>
        <th>Status</th>
        <th>Criado em</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payments as $p)
        <tr>
          <td>{{ $p->employee->fullName ?? '-' }}</td>
          <td>{{ $p->salaryAmount }}</td>
          <td>{{ $p->paymentDate }}</td>
          <td>{{ $p->paymentStatus }}</td>
          <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@else
  <p class="mt-3">Nenhum pagamento encontrado.</p>
@endif
