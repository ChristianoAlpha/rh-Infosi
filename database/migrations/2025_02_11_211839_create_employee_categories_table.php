<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create("employee_categories", function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->text("description")->nullable(); // Adicionado o campo description
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("employee_categories");
    }
}


