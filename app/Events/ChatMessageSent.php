<?php

// app/Events/ChatMessageSent.php

namespace App\Events;

use App\Models\ChatMessage;
use App\Models\Admin;
use App\Models\Employeee;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatMessage;

    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    public function broadcastOn()
    {
        return new Channel('chat-group.' . $this->chatMessage->chatGroupId);
    }

    public function broadcastWith()
    {
        $sender = $this->chatMessage->sender;
        // Nome do remetente
        $senderName = $sender->fullName 
                    ?? $sender->directorName 
                    ?? $sender->email 
                    ?? 'Usuário';
        // Escolhe pasta conforme papel
        if ($sender instanceof Admin) {
            if ($sender->role === 'director') {
                $file = $sender->directorPhoto ?? $sender->photo;
                $path = 'frontend/images/directors/';
            } elseif ($sender->role === 'department_head') {
                $file = $sender->photo;
                $path = 'frontend/images/departments/';
            } else {
                $file = null;
                $path = 'images/';
            }
        } else {
            // funcionário
            $file = $sender->avatar ?? $sender->photo ?? null;
            $path = 'frontend/images/employees/';
        }
        $photoUrl = $file
            ? asset("{$path}{$file}")
            : asset('images/default-avatar.png');

        return [
            'id'           => $this->chatMessage->id,
            'chatGroupId'  => $this->chatMessage->chatGroupId,
            'senderId'     => $this->chatMessage->senderId,
            'senderType'   => $this->chatMessage->senderType,
            'senderName'   => $senderName,
            'photoUrl'     => $photoUrl,
            'message'      => $this->chatMessage->message,
            'created_at'   => $this->chatMessage->created_at->toDateTimeString(),
        ];
    }
}
