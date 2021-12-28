<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watches', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('telefone');
            $table->string('cpf');
            $table->string('status');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')
                        ->references('id')
                        ->on('empresas');

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')
                        ->references('id')
                        ->on('users');
            

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
        Schema::dropIfExists('watches');
    }
}
