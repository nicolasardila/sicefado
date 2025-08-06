<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceActivitysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
{
    Schema::create('maintenance_activitys', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('worm_bed_id');
        $table->enum('tipo', ['Limpieza', 'Reparación', 'Desinfección', 'Otros']);
        $table->text('descripcion'); // mínimo 20 caracteres, validado en el formulario
        $table->date('fecha')->useCurrent(); // autogenerada
        $table->json('herramientas')->nullable(); // guarda múltiples herramientas como JSON
        $table->foreign('worm_bed_id')->references('id')->on('wormsBeds')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_activitys');
    }
}
