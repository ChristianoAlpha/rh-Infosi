@extends('layouts.admin.layout')
@section('title','Novo Trabalho Extra')
@section('content')
<div class="card mb-4 shadow">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h4>Novo Trabalho Extra</h4>
        <a href="{{ route('extras.index') }}" class="btn btn-outline-light btn-sm">Voltar</a>
      </div>
  <div class="card-body">
    <form method="POST" action="{{ route('extras.store') }}" id="jobForm">
      @csrf

      {{-- Campos compactos em uma linha --}}
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Título</label>
          <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Total (Kz)</label>
          <input type="text" name="totalValue" class="form-control currency" value="{{ old('totalValue') }}" required>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Buscar</label>
          <input type="text" id="empSearch" class="form-control" placeholder="Nome...">
          <div id="empList" class="list-group mt-1"></div>
        </div>
      </div>

      <h5>Participantes Selecionados</h5>
      <table class="table" id="selectedTable">
        <thead>
          <tr>
            <th>Funcionário</th>
            <th>Departamento</th>
            <th>Ajus. (Kz)</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <button type="submit" class="btn btn-success">Salvar</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const empSearch = document.getElementById('empSearch'),
        empList   = document.getElementById('empList'),
        selTable  = document.querySelector('#selectedTable tbody');
  let selected = {};

  const searchUrl = "{{ route('extras.searchEmployee') }}";

  empSearch.addEventListener('input', async () => {
    const q = empSearch.value.trim();
    empList.innerHTML = '';
    if (!q) return;
    try {
      const res  = await fetch(`${searchUrl}?q=${encodeURIComponent(q)}`, {
        headers: {'Accept':'application/json'}
      });
      if (!res.ok) return;
      const data = await res.json();
      data.forEach(e => {
        if (selected[e.id]) return;
        const item = document.createElement('a');
        item.href = '#';
        item.className = 'list-group-item';
        item.innerHTML = `<strong>${e.text}</strong><br><small>${e.extra}</small>`;
        item.onclick = ev => { ev.preventDefault(); addParticipant(e); };
        empList.appendChild(item);
      });
    } catch(err) {
      console.error('Falha ao buscar funcionários:', err);
    }
  });

  function addParticipant(e) {
    selected[e.id] = true;
    const tr = document.createElement('tr');
    tr.dataset.id = e.id;
    tr.innerHTML = `
      <td>
        ${e.text}
        <input type="hidden" name="participants[]" value="${e.id}">
      </td>
      <td>${e.extra}</td>
      <td><input type="text" name="bonus[${e.id}]" class="form-control currency" value="0"></td>
      <td><button type="button" class="btn btn-sm btn-danger">Remover</button></td>
    `;
    tr.querySelector('button').onclick = () => {
      delete selected[e.id];
      tr.remove();
    };
    selTable.appendChild(tr);
    empList.innerHTML = '';
    empSearch.value = '';
  }
});
</script>
@endpush
