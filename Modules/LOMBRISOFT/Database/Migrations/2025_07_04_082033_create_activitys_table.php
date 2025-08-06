<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('activities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('worm_bed_id')
              ->constrained('wormsBeds')
              ->onDelete('cascade');

        $table->enum('tipo', ['mantenimiento', 'alimentacion', 'humedad', 'recoleccion']);
        $table->text('descripcion')->nullable();
        $table->date('fecha_actividad');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activitys');
    }
}
