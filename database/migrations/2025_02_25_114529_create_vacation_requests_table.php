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
            
            // Ex: "15 dias", "30 dias", "22 dias úteis", "11 dias úteis"
            $table->string('vacationType'); 
    
            $table->date('vacationStart');
            $table->date('vacationEnd');
            
            $table->text('reason')->nullable();
            
            // Upload de documento/imagem
            $table->string('supportDocument')->nullable(); 
            $table->string('originalFileName')->nullable();  

            $table->string('approvalStatus')->default('Pendente'); 
            $table->string('approvalComment')->nullable();
            
            $table->timestamps();

            $table->foreign('employeeId')
                  ->references('id')
                  ->on('employeees')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacation_requests');
    }
}
