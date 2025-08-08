<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHarvestActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harvest_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bed_activity_id')
                ->constrained('bed_activities')
                ->onDelete('cascade');

            $table->string('tipo_recoleccion');
            $table->integer('cantidad_recolectada');
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
        Schema::dropIfExists('harvest_activities');
    }
}
