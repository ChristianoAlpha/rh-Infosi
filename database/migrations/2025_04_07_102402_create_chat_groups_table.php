<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('chat_groups', function (Blueprint $table) {
            $table->id();
            // Nome do grupo (pode ser nulo em conversas individuais)
            $table->string('name')->nullable();
            // Tipo do grupo: directorGroup, departmentGroup ou individual
            $table->enum('groupType', ['directorGroup', 'departmentGroup', 'individual']);
            // Para grupos de departamento e conversas individuais, guarda o departamento
            $table->unsignedBigInteger('departmentId')->nullable();
            // Em conversas individuais, armazena o id do chefe (pertencente à tabela employeees ou admin)
            $table->unsignedBigInteger('headId')->nullable();
            $table->timestamps();

            // Se desejar, crie chave estrangeira para departmentId (ajuste conforme sua migration de departments)
            $table->foreign('departmentId')->references('id')->on('departments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_groups');
    }
}
