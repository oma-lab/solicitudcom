<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreraDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrera_departamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('carrera_id');
            $table->unsignedBigInteger('adscripcion_id');

            $table->foreign('carrera_id')->references('id')->on('carreras')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('adscripcion_id')->references('id')->on('adscripcions')
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
        Schema::dropIfExists('carrera_departamentos');
    }
}
