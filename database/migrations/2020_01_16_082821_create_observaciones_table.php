<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identificador');
            $table->unsignedBigInteger('solicitud_id');
            $table->string('voto',2)->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('visto')->default(false);
            $table->timestamps();

            $table->foreign('identificador')->references('identificador')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('solicitud_id')->references('id')->on('solicituds')
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
        Schema::dropIfExists('observaciones');
    }
}
