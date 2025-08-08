<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedingActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeding_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bed_activity_id')
                ->constrained('bed_activities')
                ->onDelete('cascade');

            $table->integer('cantidad_alimento');
            $table->string('tipo_alimento');
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
        Schema::dropIfExists('feeding_activities');
    }
}
