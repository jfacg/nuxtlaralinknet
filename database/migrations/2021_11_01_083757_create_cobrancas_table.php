<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobrancas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('dataAbertura')->useCurrent();
            $table->dateTime('dataAgendamento')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('boletoixc_id');
            $table->text('mensagem');

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')
            ->references('id')
            ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobrancas');
    }
}
