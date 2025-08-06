<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedingActivitysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
{
    Schema::create('feeding_activitys', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('worm_bed_id');
        $table->enum('tipo_alimento', ['Restos vegetales', 'Estiércol bovino', 'Pulpa de café', 'Otros']);
        $table->decimal('cantidad', 8, 2); // kg con 2 decimales
        $table->text('observaciones')->nullable(); // máx. 500 caracteres (controlado en validación)
        $table->timestamp('fecha_hora')->useCurrent(); // autogenerada
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
        Schema::dropIfExists('feeding_activitys');
    }
}
