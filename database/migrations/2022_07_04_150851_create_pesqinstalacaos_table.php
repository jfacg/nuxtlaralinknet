<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesqinstalacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesqinstalacaos', function (Blueprint $table) {
            $table->id();

            $table->string('fase')->default('FASE-01');

            $table->string('cliente1')->nullable();
            $table->string('atendimentoTecnico1')->nullable();
            $table->string('reclamacaoTecnico1')->nullable();
            $table->string('instalacaoFisica1')->nullable();
            $table->string('reclamacaoInstalacao1')->nullable();
            $table->string('qualidadeInternet1')->nullable();
            $table->string('reclamacaoInternet1')->nullable();
            $table->string('equipamentoConectado1')->nullable();
            $table->string('reclamacaoEquipamento1')->nullable();
            $table->string('satisfacao1')->nullable();
            $table->string('status1')->nullable();
            $table->date('dataFase1')->nullable();

            $table->string('cliente2')->nullable();
            $table->string('qualidadeInternet2')->nullable();
            $table->string('reclamacaoInternet2')->nullable();
            $table->string('equipamentoConectado2')->nullable();
            $table->string('reclamacaoEquipamento2')->nullable();
            $table->string('reclamacao2')->nullable();
            $table->string('reclamacaoReclamacao2')->nullable();
            $table->string('satisfacao2')->nullable();
            $table->string('status2')->nullable();
            $table->date('dataFase2')->nullable();

            $table->string('cliente3')->nullable();
            $table->string('qualidadeInternet3')->nullable();
            $table->string('reclamacaoInternet3')->nullable();
            $table->string('equipamentoConectado3')->nullable();
            $table->string('reclamacaoEquipamento3')->nullable();
            $table->string('reclamacao3')->nullable();
            $table->string('reclamacaoReclamacao3')->nullable();
            $table->string('satisfacao3')->nullable();
            $table->string('status3')->nullable();
            $table->date('dataFase3')->nullable();


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
        Schema::dropIfExists('pesqinstalacaos');
    }
}
