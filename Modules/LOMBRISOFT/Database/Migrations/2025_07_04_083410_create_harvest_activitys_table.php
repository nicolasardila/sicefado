<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHarvestActivitysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
{
    Schema::create('harvest_activitys', function (Blueprint $table) {
        $table->id();
        $table->enum('producto', ['Humus', 'Lixiviado']);
        $table->decimal('cantidad', 8, 2); // kg o litros
        $table->date('fecha')->useCurrent(); // autogenerada
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('harvest_activitys');
    }
}
