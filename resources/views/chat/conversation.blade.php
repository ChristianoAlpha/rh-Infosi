@extends('layouts.admin.layout')
@section('title','Conversa')
@section('content')
<div class="chat-window card my-4">
  <div class="card-header">
    <h4>{{ $group->name }}</h4>
  </div>
  <div class="card-body chat-body" id="chatMessages">
    @foreach($messages as $m)
      @php
        $mine   = $m->senderId === auth()->id();
        $snd    = $m->sender;
        $name   = $m->senderName ?? ($snd->fullName ?? $snd->directorName ?? $snd->email);
        $photo  = $m->photoUrl ?? asset('images/default-avatar.png');
      @endphp
      <div class="message {{ $mine ? 'sent':'received' }}">
        <div class="avatar"><img src="{{ $photo }}" alt="{{ $name }}"></div>
        <div class="bubble">
          <div class="bubble-header">{{ $name }}</div>
          <div class="bubble-text">{{ $m->message }}</div>
          <div class="bubble-time">{{ $m->created_at->format('H:i') }}</div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="card-footer">
    <form id="chatForm" class="d-flex">
      @csrf
      <input type="hidden" name="chatGroupId" value="{{ $group->id }}">
      <input type="text" name="message" class="form-control me-2" placeholder="Digite sua mensagem…" required>
      <button class="btn btn-primary">Enviar</button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
.chat-body {
  height: 400px; overflow-y: auto;
  display: flex; flex-direction: column;
}
.message { display: flex; margin: 8px; }
.message.sent { flex-direction: row-reverse; }
.avatar img {
  width: 36px; height: 36px; border-radius: 50%;
}
.bubble {
  max-width: 70%; padding: 6px 10px; border-radius: 12px;
  position: relative;
}
.sent .bubble {
  background: #0b93f6; color: #fff; border-bottom-right-radius: 0;
}
.received .bubble {
  background: #e5e5ea; color: #000; border-bottom-left-radius: 0;
}
.bubble-header { font-weight: bold; margin-bottom: 4px; }
.bubble-text { margin-bottom: 4px; }
.bubble-time {
  font-size: 0.7rem; color: rgba(0,0,0,0.45);
  text-align: right;
}
</style>
@endpush

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.iife.js"></script>
<script>
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

  // scroll inicial
  let chatBox = document.getElementById('chatMessages');
  chatBox.scrollTop = chatBox.scrollHeight;

  // auto atualização(live update)
  window.Echo.channel('chat-group.{{ $group->id }}')
    .listen('ChatMessageSent', e => {
      const mine = e.senderId === {{ auth()->id() }};
      const html = `
        <div class="message ${mine?'sent':'received'}">
          <div class="avatar">
            <img src="${e.photoUrl}" alt="${e.senderName}">
          </div>
          <div class="bubble">
            <div class="bubble-header">${e.senderName}</div>
            <div class="bubble-text">${e.message}</div>
            <div class="bubble-time">${new Date(e.created_at).toLocaleTimeString().slice(0,5)}</div>
          </div>
        </div>`;
      chatBox.insertAdjacentHTML('beforeend', html);
      chatBox.scrollTop = chatBox.scrollHeight;
    });

  // envio AJAX
  document.getElementById('chatForm').addEventListener('submit', function(e){
    e.preventDefault();
    fetch("{{ route('chat.sendMessage') }}", {
      method: 'POST',
      headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
      body: new FormData(this)
    }).then(_=> this.message.value = '');
  });
</script>
@endpush
