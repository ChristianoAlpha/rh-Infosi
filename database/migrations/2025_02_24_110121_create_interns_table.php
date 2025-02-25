<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternsTable extends Migration
{
    public function up()
    {
        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departmentId');
            $table->string('fullName');
            $table->string('photo')->nullable();
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

            // NOVOS CAMPOS para estagiário
            $table->date('internshipStart'); // Início do Estágio
            $table->date('internshipEnd')->nullable();   // Fim do Estágio
            $table->string('institution');   // Instituição de origem

            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('departmentId')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('positionId')->references('id')->on('positions');
            $table->foreign('specialtyId')->references('id')->on('specialties');
        });
    }

    public function down()
    {
        Schema::dropIfExists('interns');
    }
}
