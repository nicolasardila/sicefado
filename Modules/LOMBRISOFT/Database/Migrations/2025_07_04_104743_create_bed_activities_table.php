<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBedActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('bed_activities', function (Blueprint $table) {
            $table->id();

            // Relación con cama
            $table->foreignId('worm_bed_id')
                ->constrained('wormsBeds')
                ->onDelete('cascade');

            // Tipo de actividad
            $table->enum('tipo', ['mantenimiento', 'alimentacion', 'humedad', 'recoleccion', 'ph', 'temperatura']);

            // Campos generales
            $table->text('descripcion')->nullable();
            $table->date('fecha_actividad');
            $table->time('hora_actividad')->nullable();

            // Alimentación
            $table->integer('cantidad_alimento')->nullable();
            $table->string('tipo_alimento')->nullable();

            // Humedad
            $table->float('nivel_humedad')->nullable();

            // Recolección
            $table->string('tipo_recoleccion')->nullable();
            $table->integer('cantidad_recolectada')->nullable();

            // PH y temperatura
            $table->float('ph')->nullable();
            $table->float('temperatura')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bed_activities');
    }
}
