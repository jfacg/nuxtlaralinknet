<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMudancaToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {

            $table->string('cep')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('antigoCep')->nullable();
            $table->string('antigoLogradouro')->nullable();
            $table->string('antigoNumero')->nullable();
            $table->string('antigoBairro')->nullable();
            $table->string('antigaCidade')->nullable();
            $table->string('antigaUf')->nullable();
            $table->string('clienteNome')->nullable();
            $table->string('clienteCpf')->nullable();
            $table->string('clienteIdIxc')->nullable();
            $table->string('clienteEmail')->nullable();
            $table->string('clienteContato')->nullable();
            $table->string('reclamante')->nullable();
            $table->text('relatoCliente')->nullable();

            $table->unsignedBigInteger('tipoReclamacao_id')->nullable();
            $table->foreign('tipoReclamacao_id')
                    ->references('id')
                    ->on('tipos');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
}
