@extends('layouts.admin.layout')
@section('title', 'Materiais Estoque')
@section('content')

<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white">
    <i class="fas fa-boxes me-2"></i> Estoque de Materiais ({{ ucfirst($category) }})
  </div>
  <div class="card-body">
    <a href="{{ route('materials.create', ['category'=>$category]) }}"
       class="btn btn-primary mb-3">
      <i class="bi bi-plus-circle"></i> Novo Material
    </a>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Serial Number</th>
            <th>Unit</th>
            <th>Fornecedor</th>
            <th>Estoque Atual</th>
            <th>Data de Entrada</th>
            <th>Observações</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @forelse($materials as $m)
          <tr>
            <td>{{ $m->Name }}</td>
            <td>{{ $m->SerialNumber }}</td>
            <td>{{ $m->UnitOfMeasure }}</td>
            <td>{{ $m->SupplierName }}</td>
            <td>{{ $m->CurrentStock }}</td>
            <td>{{ \Carbon\Carbon::parse($m->EntryDate)->format('d/m/Y') }}</td>
            <td>{{ $m->Notes }}</td>
            <td>
              <a href="{{ route('materials.edit',$m->id) }}" class="btn btn-sm btn-warning">Editar</a>
              <form action="{{ route('materials.destroy',$m->id) }}"
                    method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger"
                        onclick="return confirm('Confirma exclusão?')">
                  Excluir
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="8" class="text-center">Nenhum material cadastrado.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
