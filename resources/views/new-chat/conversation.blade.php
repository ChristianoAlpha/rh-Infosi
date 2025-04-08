@extends('layouts.chat-layout')

@section('content')
<h2 class="mb-4">Conversa: {{ $group->name }}</h2>

<div class="card">
  <div class="card-body chat-body" id="chatMessages">
    @foreach($messages as $m)
      @php
        $mine   = ($m->senderId === auth()->id());
        $snd    = $m->sender; // Admin ou Employeee
        $senderName = method_exists($m, 'senderName') ? $m->senderName : '';
        $name   = $senderName ?: ($snd->fullName ?? $snd->email ?? 'Sem Nome');
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
      <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Enviar</button>
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
  .bubble-left,
  .bubble-right {
    max-width: 60%;
    padding: 10px;
    border-radius: 15px;
    background: #e2e2e2;
    position: relative;
    margin-bottom: 8px;
    word-break: break-word;
  }
  .bubble-left {
    background: #e2e2e2;
  }
  .bubble-right {
    background: #007bff;
    color: #fff;
  }
</style>
@endpush

@push('scripts')
<!-- Pusher e Laravel Echo -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>
<script>
  // Se estiver usando Pusher oficial, com as credenciais .env e config/broadcasting.php
  // define useTLS como true, e não defina wsHost nem wsPort se não estiver usando websockets local
  Pusher.logToConsole = false;
  window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '{{ env("PUSHER_APP_KEY") }}',
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
    forceTLS: true  // usando pusher.com
  });

  // Faz scroll inicial para o fim
  const chatBox = document.getElementById('chatMessages');
  chatBox.scrollTop = chatBox.scrollHeight;

  // Inscreve no canal do grupo
  window.Echo.channel('chat-group.{{ $group->id }}')
    .listen('ChatMessageSent', (e) => {
      const mine = (e.senderId === {{ auth()->id() }});
      const bubbleClass = mine ? 'bubble-right' : 'bubble-left';
      const alignment   = mine ? 'justify-content-end' : 'justify-content-start';
      const time        = new Date(e.created_at).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});

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

  // Ação de envio de formulário
  document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch("{{ route('new-chat.sendMessage') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: formData
    }).then(r => {
      this.message.value = '';
    }).catch(err => console.error(err));
  });
</script>
@endpush
