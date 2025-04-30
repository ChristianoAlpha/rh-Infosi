<?php

// database/migrations/2025_04_25_000000_create_materials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->enum('Category', ['infraestrutura','servicos_gerais']);
            $table->unsignedBigInteger('MaterialTypeId');
            $table->string('Name');
            $table->string('SerialNumber')->unique();
            $table->string('Model');
            $table->date('ManufactureDate');
            $table->string('SupplierName');
            $table->string('SupplierIdentifier');
            $table->date('EntryDate');
            $table->integer('CurrentStock')->default(0);
            $table->text('Notes')->nullable();
            $table->timestamps();

            $table->foreign('MaterialTypeId')
                  ->references('id')->on('material_types')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
