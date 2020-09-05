<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecomendacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recomendacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('num_recomendacion')->nullable();
            $table->string('num_oficio')->nullable();
            $table->string('fecha')->nullable();
            $table->string('respuesta')->nullable();
            $table->string('condicion')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('motivos')->nullable();
            $table->string('folio_hoja')->nullable();
            $table->string('num_libro')->nullable();
            $table->string('archivo')->nullable();
            $table->boolean('enviado')->default(false);
            $table->unsignedBigInteger('id_solicitud')->nullable();
            $table->timestamps();

            $table->foreign('id_solicitud')->references('id')->on('solicituds')
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
        Schema::dropIfExists('recomendacions');
    }
}
