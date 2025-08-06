<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoistureActivitysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
{
    Schema::create('moisture_activitys', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('worm_bed_id');
        $table->text('observaciones')->nullable(); // máx. 500 caracteres
        $table->date('fecha')->useCurrent(); // autogenerada
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
        Schema::dropIfExists('moisture_activitys');
    }
}
