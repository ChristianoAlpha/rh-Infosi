<?php 
// app/Events/NewChatMessageSent.php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatMessage;

    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    public function broadcastOn()
    {
        // O canal é específico para o grupo, garantindo que somente as partes envolvidas recebam a mensagem.
        return new Channel('chat-group.' . $this->chatMessage->chatGroupId);
    }

    public function broadcastWith()
    {
        $sender = $this->chatMessage->sender;

        if ($this->chatMessage->senderType === 'admin') {
            // Para administradores (diretores/chefes), tenta usar o nome vinculado via employee, se existir.
            $senderName = ($sender && method_exists($sender, 'employee') && $sender->employee)
                        ? ($sender->employee->fullName ?? $sender->email)
                        : $sender->email;
            // Se tiver foto definida, use; senão, use uma imagem padrão.
            $photoUrl = asset('images/admin-default.png');
        } else {
            // Se for funcionário, usamos os dados do próprio registro.
            $senderName = $sender ? ($sender->fullName ?? $sender->email) : 'Usuário';
            $photoUrl  = asset('images/employee-default.png');
        }

        return [
            'id'          => $this->chatMessage->id,
            'chatGroupId' => $this->chatMessage->chatGroupId,
            'senderId'    => $this->chatMessage->senderId,
            'senderType'  => $this->chatMessage->senderType,
            'senderName'  => $senderName,
            'photoUrl'    => $photoUrl,
            'message'     => $this->chatMessage->message,
            'created_at'  => $this->chatMessage->created_at->toDateTimeString(),
        ];
    }
}
