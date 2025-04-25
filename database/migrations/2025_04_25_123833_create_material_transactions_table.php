<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('materialTransactions', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('materialId');
            $t->enum('transactionType',['in','out']);
            $t->integer('quantity');
            $t->unsignedBigInteger('departmentId');
            $t->unsignedBigInteger('createdBy');
            $t->text('note')->nullable();
            $t->timestamps();

            $t->foreign('materialId')->references('id')->on('materials')->onDelete('cascade');
            $t->foreign('departmentId')->references('id')->on('departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materialTransactions');
    }
}