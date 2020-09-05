<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('asunto')->nullable();
            $table->text('motivos_academicos')->nullable();
            $table->text('motivos_personales')->nullable();
            $table->text('otros_motivos')->nullable();
            $table->string('evidencias')->nullable();
            $table->string('solicitud_firmada')->nullable();
            //$table->string('resultado')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('fecha')->nullable();            
            $table->string('identificador');
            $table->string('semestre')->nullable();
            $table->boolean('enviado')->default(false);
            $table->boolean('enviadocoor')->default(false);
            $table->string('carrera_profesor')->nullable();
            $table->unsignedBigInteger('calendario_id')->nullable();
            $table->timestamps();

            $table->foreign('identificador')->references('identificador')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
        Schema::dropIfExists('solicituds');
    }
}
