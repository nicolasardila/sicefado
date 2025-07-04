<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Ejecutar la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id(); // ID autoincremental

            $table->string('nombre', 100); // Nombre del material

            $table->boolean('estado')->default(true); // true = Disponible, false = No Disponible

            $table->unsignedInteger('cantidad')->default(0); // cantidad no negativa

            $table->timestamp('fecha_registro')->useCurrent(); // fecha automática al crear
        });
    }

    /**
     * Revertir la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
