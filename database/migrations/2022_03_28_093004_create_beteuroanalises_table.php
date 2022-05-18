<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeteuroanalisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beteuroanalises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dicajogoe_id')->nullable();
            $table->foreign('dicajogoe_id')
                    ->references('id')
                    ->on('beteuros');
            $table->unsignedBigInteger('dicajogoc_id')->nullable();
            $table->foreign('dicajogoc_id')
                    ->references('id')
                    ->on('beteuros');
            $table->unsignedBigInteger('dicajogod_id')->nullable();
            $table->foreign('dicajogod_id')
                    ->references('id')
                    ->on('beteuros');
            
            $table->unsignedBigInteger('jogoe_id')->nullable();
            $table->foreign('jogoe_id')
                    ->references('id')
                    ->on('beteuros');
            $table->unsignedBigInteger('jogoc_id')->nullable();
            $table->foreign('jogoc_id')
                    ->references('id')
                    ->on('beteuros');
            $table->unsignedBigInteger('jogod_id')->nullable();
            $table->foreign('jogod_id')
                    ->references('id')
                    ->on('beteuros');

            $table->string('green')->nullable();;
            $table->string('status')->nullable();;

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
        Schema::dropIfExists('beteuroanalises');
    }
}