<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTypesTable extends Migration
{
    public function up()
    {
        Schema::create('employee_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();         
            $table->text('description')->nullable();    
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_types');
    }
}
