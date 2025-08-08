<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoistureActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moisture_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bed_activity_id')
                ->constrained('bed_activities')
                ->onDelete('cascade');

            $table->float('nivel_humedad');
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
        Schema::dropIfExists('moisture_activities');
    }
}
