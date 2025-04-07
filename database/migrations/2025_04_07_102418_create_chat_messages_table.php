<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chatGroupId');
            // Armazena o id do remetente (pode ser de Admin ou Employeee)
            $table->unsignedBigInteger('senderId');
            // Para identificar de qual tipo é o remetente (admin ou employeee)
            $table->enum('senderType', ['admin', 'employeee']);
            $table->text('message');
            $table->timestamps();

            $table->foreign('chatGroupId')->references('id')->on('chat_groups')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
}
