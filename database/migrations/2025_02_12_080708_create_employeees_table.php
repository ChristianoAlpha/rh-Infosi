<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeesTable extends Migration
{
    public function up()
    {
        Schema::create('employeees', function (Blueprint $table) {
            $table->id();
            $table->string('employmentStatus')->default('active');
            // Agora allow null para diretores (não vinculados a departamento)
            $table->unsignedBigInteger('departmentId')->nullable();
            $table->string('fullName');
            $table->string('address');
            $table->string('mobile');
            $table->string('phone_code')->nullable();
            $table->string('fatherName');
            $table->string('motherName');
            $table->string('bi')->unique();
            $table->date('birth_date');
            $table->string('nationality');
            $table->enum('gender', ['Masculino', 'Feminino']);
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('positionId');
            $table->unsignedBigInteger('specialtyId');
            $table->unsignedBigInteger('employeeTypeId')->nullable();
            $table->timestamps();

            $table->foreign('departmentId')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('positionId')->references('id')->on('positions');
            $table->foreign('specialtyId')->references('id')->on('specialties');
            $table->foreign('employeeTypeId')->references('id')->on('employee_types');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employeees');
    }
}
