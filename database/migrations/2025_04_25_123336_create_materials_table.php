<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('SerialNumber')->unique();
            $table->enum('Category', ['infraestrutura','servicos_gerais']);
            $table->string('UnitOfMeasure');
            $table->string('SupplierName');
            $table->string('SupplierIdentifier');
            $table->date('EntryDate');
            $table->integer('CurrentStock')->default(0);
            $table->text('Notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
