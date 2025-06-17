@extends('layouts.admin.layout')
@section('title', 'Editar Pedido de Férias')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card mb-4 shadow">
      <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span><i class="fas fa-umbrella-beach me-2"></i>Editar Pedido de Férias</span>
        <a href="{{ route('vacationRequest.index') }}" class="btn btn-outline-light btn-sm">
          <i class="bi bi-arrow-left"></i> Voltar
        </a>
      </div>
      <div class="card-body">
        <form action="{{ route('vacationRequest.update', $data->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="vacationType" class="form-label">Tipo de Férias</label>
            <select name="vacationType" id="vacationType" class="form-select" required>
              <option value="">-- Selecione --</option>
              @foreach(['22 dias úteis','11 dias úteis'] as $vt)
                <option value="{{ $vt }}" {{ $data->vacationType == $vt ? 'selected' : '' }}>{{ $vt }}</option>
              @endforeach
            </select>
            @error('vacationType')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="row g-2">
            <div class="col-6">
              <label for="vacationStart" class="form-label">Data de Início</label>
              <input type="date" name="vacationStart" id="vacationStart" class="form-control" value="{{ $data->vacationStart }}" required>
              @error('vacationStart')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-6">
              <label for="vacationEnd" class="form-label">Data de Fim</label>
              <input type="date" name="vacationEnd" id="vacationEnd" class="form-control" value="{{ $data->vacationEnd }}" readonly required>
              @error('vacationEnd')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
          </div>

          <div class="mb-3 mt-3">
            <label for="manualHolidays" class="form-label">Feriados / Tolerância</label>
            <input type="date" name="manualHolidays[]" id="manualHolidays" class="form-control" multiple>
            <small class="text-muted">Segure Ctrl/Cmd para múltiplas datas.</small>
            @error('manualHolidays.*')<small class="text-danger">{{ $message }}</small>@enderror
          </div>

          <div class="mb-3">
            <label for="reason" class="form-label">Razão</label>
            <textarea name="reason" id="reason" rows="3" class="form-control">{{ $data->reason }}</textarea>
          </div>

          <div class="mb-3">
            <label for="supportDocument" class="form-label">Documento de Suporte</label>
            <input type="file" name="supportDocument" id="supportDocument" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
            @if($data->supportDocument)
              <p class="mt-2">
                Atual: <a href="{{ asset('storage/'.$data->supportDocument) }}" target="_blank">
                  {{ $data->originalFileName }}
                </a>
              </p>
            @endif
          </div>

          <div class="text-center">
            <button class="btn btn-success">
              <i class="bi bi-check-circle"></i> Atualizar Pedido
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  const startEl = document.getElementById('vacationStart'),
        typeEl  = document.getElementById('vacationType'),
        endEl   = document.getElementById('vacationEnd'),
        holEl   = document.getElementById('manualHolidays');

  // pré-seleciona feriados existentes
  @if($data->manualHolidays)
    const pre = @json($data->manualHolidays);
    pre.forEach(d=>{
      const opt = document.createElement('option');
      opt.value = d;
      opt.selected = true;
      holEl.appendChild(opt);
    });
  @endif

  function calcEnd() {
    if (!startEl.value || !typeEl.value) return;
    let needed = parseInt(typeEl.value),
        d = new Date(startEl.value), count = 0,
        holidays = [...holEl.selectedOptions].map(o=>new Date(o.value).toDateString());

    while (count < needed) {
      d.setDate(d.getDate()+1);
      if (d.getDay()===0||d.getDay()===6) continue;
      if (holidays.includes(d.toDateString())) continue;
      count++;
    }
    if (d.getDay()===6) d.setDate(d.getDate()+2);
    if (d.getDay()===0) d.setDate(d.getDate()+1);
    endEl.value = d.toISOString().slice(0,10);
  }

  startEl.addEventListener('change', calcEnd);
  typeEl.addEventListener('change', calcEnd);
  holEl.addEventListener('change', calcEnd);
</script>
@endpush
@endsection
