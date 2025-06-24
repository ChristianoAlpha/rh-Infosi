<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicleId');
            $table->enum('type', ['Preventive', 'Corrective']);
            $table->date('maintenanceDate');
            $table->decimal('cost', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('vehicleId')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance');
    }
}
