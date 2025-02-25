<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departmentId'); // Alterado de integer()
            $table->string('fullName');
            $table->string('address');
            $table->string('mobile');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('bi')->unique();
            $table->date('birth_date');
            $table->string('nationality');
            $table->enum('gender', ['Masculino', 'Feminino']);
            $table->string('email')->unique();
            $table->unsignedBigInteger('positionId');
            $table->unsignedBigInteger('specialtyId');
            
        // Chaves estrangeiras
        $table->foreign('positionId')->references('id')->on('positions');
        $table->foreign('specialtyId')->references('id')->on('specialties');
            $table->timestamps();
            
            // Adicionar chave estrangeira
            $table->foreign('departmentId')
                  ->references('id')
                  ->on('departments')
                  ->onDelete('cascade'); // Opcional
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeees');
    }
}
