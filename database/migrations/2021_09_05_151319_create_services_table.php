<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->dateTime('dataAbertura')->useCurrent();
            $table->dateTime('dataAgendamento')->nullable();
            $table->dateTime('dataVencimento')->nullable();
            $table->dateTime('dataExecucao')->nullable();
            $table->dateTime('dataFechamento')->nullable();
            $table->integer('vencimento');
            $table->double('valorInstalacao', 8, 2)->default(0);
            $table->string('pagamento');
            $table->text('observacao')->nullable();
            $table->text('plano');
            $table->double('valorPlano', 8, 2)->default(0);
            $table->string('status');
            $table->text('historico')->nullable();
            $table->text('contato')->nullable();
            $table->text('indicacao')->nullable();
            $table->string('boletodigital')->default('N');
            $table->string('boletogerado')->default('N');


            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('vendedor_id');
            $table->unsignedBigInteger('tecnico_id')->nullable();
            $table->unsignedBigInteger('cliente_id');

            $table->foreign('usuario_id')
                        ->references('id')
                        ->on('users');

            $table->foreign('vendedor_id')
                        ->references('id')
                        ->on('users');

            $table->foreign('tecnico_id')
                        ->references('id')
                        ->on('users');

            $table->foreign('cliente_id')
                        ->references('id')
                        ->on('clients')
                        ->onDelete('cascade');

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
        Schema::dropIfExists('services');
    }
}
