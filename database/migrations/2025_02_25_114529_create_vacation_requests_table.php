<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('vacation_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeId');
            $table->string('vacationType'); // Ex: "15 dias", "30 dias", "22 dias úteis", "11 dias úteis"
            $table->date('vacationStart');
            $table->date('vacationEnd');
            $table->text('reason')->nullable();
            $table->string('supportDocument')->nullable(); // Para upload de documento/imagem
            $table->string('originalFileName')->nullable();  // Para salvar o nome original do arquivo
            $table->string('status')->default('Pendente'); // Novo campo de status: Pendente, Aprovado, Recusado
            $table->timestamps();

            $table->foreign('employeeId')->references('id')->on('employeees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacation_requests');
    }
}
