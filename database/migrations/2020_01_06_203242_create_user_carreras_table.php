<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_carreras', function (Blueprint $table) {
            $table->string('identificador');
            $table->unsignedBigInteger('carrera_id');

            $table->foreign('identificador')->references('identificador')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('carrera_id')->references('id')->on('carreras')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_carreras');
    }
}
