<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('cableCode')->nullable()->unique();
            $table->integer('clientIxc_id')->nullable()->unique();
            $table->string('partner')->nullable()->unique();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('box_id');

            $table->foreign('box_id')
                        ->references('id')
                        ->on('boxes')
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
        Schema::dropIfExists('ports');
    }
}
