<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->text('description')->nullable();
            //numero de serie de cada material
            $t->string('code')->unique();
            //codigo de barras
            $t->string('barcode')->nullable();
            //codigo de barras
            $t->string('serie')->nullable();
            $t->string('origin')->nullable();
            $t->string('manufacturingDate')->nullable();
            $t->string('entryDate')->nullable();
            $t->string('departureDate')->nullable();
            $t->enum('category',['infraestrutura','servicos_gerais']);
            $t->integer('currentStock')->default(0);
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}