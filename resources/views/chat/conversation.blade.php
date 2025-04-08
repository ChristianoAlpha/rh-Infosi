@extends('layouts.admin.layout')

@section('title', 'Conversa')
@section('content')
<div class="chat-container card my-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4>{{ $group->name }}</h4>
  </div>
  <div class="card-body p-0">

    <!-- Input de mensagem no topo -->
    <div class="chat-input p-3 border-bottom">
      <form id="chatForm" class="d-flex align-items-center">
        @csrf
        <input type="hidden" name="chatGroupId" value="{{ $group->id }}">
        <input type="text" name="message" class="form-control me-2" placeholder="Digite sua mensagem…" required>
        <button class="btn btn-primary" type="submit">
          <i class="fas fa-paper-plane"></i>
        </button>
      </form>
    </div>

    <!-- Área de mensagens -->
    <div class="chat-messages p-3" id="chatMessages">
      @foreach($messages as $m)
        @php
          $mine   = $m->senderId === auth()->id();
          $snd    = $m->sender;
          $name   = $m->senderName ?? ($snd->fullName ?? $snd->directorName ?? $snd->email);
          $photo  = $m->photoUrl ?? asset('images/default-avatar.png');
        @endphp
        <div class="message-item {{ $mine ? 'sent' : 'received' }}">
          <div class="avatar">
            <img src="{{ $photo }}" alt="{{ $name }}">
          </div>
          <div class="message-bubble">
            <div class="message-header">{{ $name }}</div>
            <div class="message-text">{{ $m->message }}</div>
            <div class="message-time">{{ \Carbon\Carbon::parse($m->created_at)->format('H:i') }}</div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>

  /* Container principal do chat */
  .chat-container {
    max-width: 800px;
    margin: 0 auto;
  }

  /* Input de mensagem – fixa no topo da área de conversa */
  .chat-input {
    background: #f7f7f7;
  }

  /* Área de mensagens com scroll */
  .chat-messages {
    height: 400px;
    overflow-y: auto;
    background: #fff;
  }

  /* Itens de mensagem */
  .message-item {
    display: flex;
    margin-bottom: 15px;
  }
  .message-item.sent {
    flex-direction: row-reverse;
    text-align: right;
  }
  
  /* Avatar da mensagem */
  .message-item .avatar {
    width: 40px;
    margin: 0 10px;
  }
  .message-item .avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
  }
  /* Bolha de mensagem */
  .message-bubble {
    max-width: 70%;
    padding: 10px;
    border-radius: 12px;
    position: relative;
    box-shadow: 0 2px 3px rgba(0,0,0,0.1);
  }
  .message-item.sent .message-bubble {
    background: #0b93f6;
    color: #fff;
    border-bottom-right-radius: 0;
  }
  .message-item.received .message-bubble {
    background: #e5e5ea;
    color: #000;
    border-bottom-left-radius: 0;
  }
  /* Cabeçalho com nome */
  .message-header {
    font-weight: bold;
    margin-bottom: 5px;
  }
  /* Texto da mensagem */
  .message-text {
    margin-bottom: 5px;
    word-wrap: break-word;
  }
  /* Timestamp discreto */
  .message-time {
    font-size: 0.8rem;
    color: rgba(0,0,0,0.6);
    text-align: right;
  }
</style>
@endpush

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>
<script>
  // Configuração do Laravel Echo
  Pusher.logToConsole = false;
  window.Echo = new Echo({
      broadcaster: 'pusher',
      key: '{{ env("PUSHER_APP_KEY") }}',
      cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
      wsHost: window.location.hostname,
      wsPort: 6001,
      forceTLS: false,
      disableStats: true,
  });

  // Atualiza o scroll para o final da área de mensagens
  const chatBox = document.getElementById('chatMessages');
  chatBox.scrollTop = chatBox.scrollHeight;

  // Escuta o canal do grupo e insere novas mensagens
  window.Echo.channel('chat-group.{{ $group->id }}')
    .listen('ChatMessageSent', e => {
      const mine = e.senderId === {{ auth()->id() }};
      const messageHTML = `
        <div class="message-item ${mine ? 'sent' : 'received'}">
          <div class="avatar">
            <img src="${e.photoUrl}" alt="${e.senderName}">
          </div>
          <div class="message-bubble">
            <div class="message-header">${e.senderName}</div>
            <div class="message-text">${e.message}</div>
            <div class="message-time">${new Date(e.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
          </div>
        </div>`;
      document.getElementById('chatMessages').insertAdjacentHTML('beforeend', messageHTML);
      chatBox.scrollTop = chatBox.scrollHeight;
    });

  // Envio AJAX do formulário de mensagem
  document.getElementById('chatForm').addEventListener('submit', function(e){
    e.preventDefault();
    fetch("{{ route('chat.sendMessage') }}", {
      method: 'POST',
      headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
      body: new FormData(this)
    }).then(() => {
      this.message.value = '';
    });
  });
</script>
@endpush
