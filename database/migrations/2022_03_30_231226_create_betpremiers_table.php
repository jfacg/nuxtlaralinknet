<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetpremiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('betpremiers', function (Blueprint $table) {
            $table->id();
            $table->string('liga');
            $table->date('data');
            $table->string('hora');
            $table->string('minuto');
            $table->string('placar');
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
        Schema::dropIfExists('betpremiers');
    }
}
