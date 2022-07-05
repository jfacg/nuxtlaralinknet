<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->string('equippatrimonio')->nullable()->unique();
            $table->string('equipnome')->nullable();
            $table->string('equipmarca')->nullable();
            $table->string('equipmac')->nullable();
            $table->string('equipgpon')->nullable();
            $table->string('equipsenha')->nullable();
            $table->string('equipstatus')->nullable();
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
        Schema::dropIfExists('equipamentos');
    }
}
