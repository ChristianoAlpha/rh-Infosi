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
            $table->unsignedBigInteger('departmentId');
            $table->enum('vacationType', ['15 dias', '30 dias', '22 dias úteis', '11 dias úteis']);
            $table->date('vacationStart');
            $table->date('vacationEnd');
            $table->timestamps();

            $table->foreign('employeeId')->references('id')->on('employeees')->onDelete('cascade');
            $table->foreign('departmentId')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacation_requests');
    }
}
