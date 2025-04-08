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
            $table->string('name')->nullable();
            // As opções agora incluem também "departmentHeadsGroup" para os chefes de departamento, conforme o novo fluxo.
            $table->enum('groupType', ['directorGroup', 'departmentGroup', 'departmentHeadsGroup', 'individual']);
            $table->unsignedBigInteger('departmentId')->nullable();
            $table->unsignedBigInteger('headId')->nullable();
            $table->timestamps();
            
            // Se desejar relacionar com a tabela departments:
            // $table->foreign('departmentId')->references('id')->on('departments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_groups');
    }
}
