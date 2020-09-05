<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_asistencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lista_archivo')->nullable();
            $table->unsignedBigInteger('calendario_id')->nullable();
            $table->timestamps();

            $table->foreign('calendario_id')->references('id')->on('calendarios')
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
        Schema::dropIfExists('lista_asistencias');
    }
}
