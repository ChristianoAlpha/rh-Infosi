<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('material_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('MaterialId')
                  ->constrained('materials')
                  ->cascadeOnDelete(); // fk para materials.id
            $table->enum('TransactionType',['in','out']);
            $table->date('TransactionDate');
            $table->integer('Quantity');
            $table->string('SupplierName')->nullable();
            $table->string('SupplierIdentifier')->nullable();
            $table->foreignId('DepartmentId')
                  ->constrained('departments');
            $table->foreignId('CreatedBy')
                  ->constrained('users');
            $table->text('Notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_transactions');
    }
}
