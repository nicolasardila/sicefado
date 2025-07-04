<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialMovementsTable extends Migration
{
    /**
     * Ejecutar la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_movements', function (Blueprint $table) {
            $table->id(); // ID autoincremental

            $table->foreignId('material_id')
                ->constrained('materials')
                ->onDelete('cascade'); // Relación con materials

            $table->enum('tipo', ['entrada', 'salida']); // Tipo de movimiento

            $table->integer('cantidad'); // Cantidad movida (+ o - según tipo)

            $table->string('descripcion', 255)->nullable(); // Descripción opcional

            $table->timestamp('fecha_movimiento')->useCurrent(); // Fecha automática

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Revertir la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_movements');
    }
}
