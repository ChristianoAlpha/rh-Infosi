@extends('layouts.admin.layout')
@section('title', 'Novo Pedido de Férias')
@section('content')
<div class="card mb-4 shadow">
  <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
    <span><i class="fas fa-umbrella-beach me-2"></i>Novo Pedido de Férias</span>
    <a href="{{ route('vacationRequest.index') }}" class="btn btn-outline-light btn-sm">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  </div>
  <div class="card-body">
    <h5>Seus Dados:</h5>
    <p><strong>Nome:</strong> {{ $employee->fullName }}</p>
    <p><strong>Departamento:</strong> {{ $employee->department->title ?? '-' }}</p>

    <form method="POST" action="{{ route('vacationRequest.store') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="employeeId" value="{{ $employee->id }}">

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label for="vacationType" class="form-label">Tipo de Férias</label>
          <select name="vacationType" id="vacationType" class="form-select" required>
            <option value="">-- Selecione --</option>
            @foreach($vacationTypes as $vt)
              <option value="{{ $vt }}" {{ old('vacationType')==$vt?'selected':'' }}>
                {{ $vt }}
              </option>
            @endforeach
          </select>
          @error('vacationType')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-6">
          <label for="supportDocument" class="form-label">Documento de Suporte</label>
          <input type="file" name="supportDocument" id="supportDocument" class="form-control"
                 accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
        </div>
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label for="vacationStart" class="form-label">Data de Início</label>
          <input type="date" name="vacationStart" id="vacationStart"
                 class="form-control" value="{{ old('vacationStart') }}" required>
          @error('vacationStart')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-6">
          <label for="vacationEnd" class="form-label">Data de Fim</label>
          <input type="date" name="vacationEnd" id="vacationEnd"
                 class="form-control" readonly required>
          @error('vacationEnd')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Data de Feriados</label>
        <div id="holidaysContainer">
          <div class="holiday-field d-flex mb-2">
            <input type="date" name="manualHolidays[]" class="form-control holiday-input">
            <button type="button" class="btn btn-outline-danger btn-sm ms-2 remove-holiday">–</button>
          </div>
        </div>
        <button type="button" id="addHoliday" class="btn btn-outline-secondary btn-sm">
          + Adicionar Data
        </button>
        @error('manualHolidays.*')<small class="text-danger d-block">{{ $message }}</small>@enderror
      </div>

      <div class="mb-3">
        <label for="reason" class="form-label">Razão</label>
        <textarea name="reason" id="reason" rows="4" class="form-control">{{ old('reason') }}</textarea>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle"></i> Enviar Pedido
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  // copiamos o mesmo JS do create.blade.php, para ter a funcionalidade de cálculo de data de fim
  const startEl = document.getElementById('vacationStart'),
        typeEl  = document.getElementById('vacationType'),
        endEl   = document.getElementById('vacationEnd'),
        holCont = document.getElementById('holidaysContainer'),
        addBtn  = document.getElementById('addHoliday');

  function calcEnd() {
    if (!startEl.value||!typeEl.value) return;
    let needed=parseInt(typeEl.value), d=new Date(startEl.value), count=0,
        holidays=Array.from(document.querySelectorAll('.holiday-input'))
          .map(i=>i.value).filter(v=>v)
          .map(v=>new Date(v).toDateString());
    while(count<needed){
      d.setDate(d.getDate()+1);
      if(d.getDay()===0||d.getDay()===6) continue;
      if(holidays.includes(d.toDateString())) continue;
      count++;
    }
    if(d.getDay()===6) d.setDate(d.getDate()+2);
    if(d.getDay()===0) d.setDate(d.getDate()+1);
    endEl.value=d.toISOString().slice(0,10);
  }

  function addHolidayField(v='') {
    const w=document.createElement('div');
    w.className='holiday-field d-flex mb-2';
    w.innerHTML=`
      <input type="date" name="manualHolidays[]" class="form-control holiday-input" value="${v}">
      <button type="button" class="btn btn-outline-danger btn-sm ms-2 remove-holiday">–</button>`;
    holCont.append(w);
    w.querySelector('.holiday-input').addEventListener('change',calcEnd);
    w.querySelector('.remove-holiday').addEventListener('click',()=>{w.remove();calcEnd();});
  }

  document.querySelectorAll('.holiday-input').forEach(i=>i.addEventListener('change',calcEnd));
  addBtn.addEventListener('click',()=>addHolidayField());
  startEl.addEventListener('change',calcEnd);
  typeEl.addEventListener('change',calcEnd);
</script>
@endpush
@endsection
