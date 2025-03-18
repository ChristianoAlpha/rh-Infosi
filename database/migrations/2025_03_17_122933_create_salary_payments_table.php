<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeId');
            $table->decimal('salaryAmount', 10, 2);
            $table->date('paymentDate')->nullable();
            $table->string('paymentStatus')->default('Pending');
            $table->text('paymentComment')->nullable();
            $table->timestamps();

            $table->foreign('employeeId')
                  ->references('id')
                  ->on('employeees') // conforme o nome da sua tabela
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_payments');
    }
}
