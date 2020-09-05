<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identificador');
            $table->string('tipo')->nullable();
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->unsignedBigInteger('citatorio_id')->nullable();
            $table->string('mensaje')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('observacion')->nullable();
            $table->integer('num')->default(0);
            $table->boolean('visto')->default(false);
            $table->timestamps();

            $table->foreign('identificador')->references('identificador')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('solicitud_id')->references('id')->on('solicituds')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('citatorio_id')->references('id')->on('citatorios')
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
        Schema::dropIfExists('notificacions');
    }
}
