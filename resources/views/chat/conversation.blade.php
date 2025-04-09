@extends('layouts.chat-layout')

@section('content')
<h2 class="mb-4">Conversa: {{ $group->name }}</h2>

<div class="card">
  <div class="card-body chat-body" id="chatMessages">
    @foreach($messages as $m)
      @php
          $mine = ($m->senderId === auth()->id());
          // Determina o nome a ser exibido com base no senderType
          if ($m->senderType === 'admin') {
              $role = $m->sender->role ?? '';
              if (in_array($role, ['director', 'department_head'])) {
                  // Se o admin possui registro de funcionário, usa seu fullName
                  $name = ($m->sender->employee && !empty($m->sender->employee->fullName))
                           ? $m->sender->employee->fullName
                           : ($m->sender->directorName ?? $m->sender->email);
              } else {
                  $name = $m->sender->email;
              }
          } else {
              // Se for funcionário, use fullName ou, se não existir, email
              $name = $m->sender->fullName ?? $m->sender->email ?? 'Usuário';
          }
      @endphp

      <div class="mb-3 d-flex {{ $mine ? 'justify-content-end' : 'justify-content-start' }}">
        <div class="{{ $mine ? 'bubble-right' : 'bubble-left' }}">
          <strong>{{ $name }}</strong><br>
          <span>{{ $m->message }}</span><br>
          <small class="text-muted">{{ $m->created_at->format('H:i') }}</small>
        </div>
      </div>
    @endforeach
  </div>
  <div class="card-footer">
    <form id="chatForm" class="d-flex" autocomplete="off">
      @csrf
      <input type="hidden" name="chatGroupId" value="{{ $group->id }}">
      <input type="text" name="message" class="form-control me-2" placeholder="Digite sua mensagem..." required>
      <button type="submit" class="btn btn-success">
        <i class="fa fa-paper-plane"></i> Enviar
      </button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
  .chat-body {
    height: 500px;
    overflow-y: auto;
    background: #f9f9f9;
  }
  .bubble-left, .bubble-right {
    max-width: 60%;
    padding: 10px;
    border-radius: 15px;
    margin-bottom: 8px;
    word-break: break-word;
  }
  .bubble-left {
    background: #e2e2e2;
    color: #000;
  }
  .bubble-right {
    background: #007bff;
    color: #fff;
  }
</style>
@endpush

@push('scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>
<script>
  Pusher.logToConsole = false;
  window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '{{ env("PUSHER_APP_KEY") }}',
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
    forceTLS: true
  });

  const chatBox = document.getElementById('chatMessages');
  chatBox.scrollTop = chatBox.scrollHeight;

  window.Echo.channel('chat-group.{{ $group->id }}')
    .listen('NewChatMessageSent', (e) => {
      const mine = (e.senderId === {{ auth()->id() }});
      const bubbleClass = mine ? 'bubble-right' : 'bubble-left';
      const alignment   = mine ? 'justify-content-end' : 'justify-content-start';
      const time = new Date(e.created_at).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});

      const msgHtml = `
        <div class="mb-3 d-flex ${alignment}">
          <div class="${bubbleClass}">
            <strong>${e.senderName}</strong><br>
            <span>${e.message}</span><br>
            <small class="text-muted">${time}</small>
          </div>
        </div>
      `;
      chatBox.insertAdjacentHTML('beforeend', msgHtml);
      chatBox.scrollTop = chatBox.scrollHeight;
    });

  document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("{{ route('new-chat.sendMessage') }}", {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'ok') {
        this.message.value = '';
      }
    })
    .catch(err => console.error(err));
  });
</script>
@endpush
