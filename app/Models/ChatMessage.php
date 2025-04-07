<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chatGroupId',
        'senderId',
        'senderType',
        'message',
    ];

    public function sender()
    {
        if ($this->senderType === 'admin') {
            return $this->belongsTo(Admin::class, 'senderId');
        }
        return $this->belongsTo(Employeee::class, 'senderId');
    }

    public function group()
    {
        return $this->belongsTo(ChatGroup::class, 'chatGroupId');
    }
}
