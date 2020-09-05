<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictamensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictamens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('recomendacion_id')->nullable();
            $table->string('num_oficio')->nullable();
            $table->string('num_dictamen')->nullable();
            $table->string('respuesta')->nullable();
            $table->text('anotaciones')->nullable();
            $table->string('fecha')->nullable();
            $table->string('dictamen_firmado')->nullable();
            $table->boolean('enviado')->default(false);
            $table->boolean('entregado')->default(false);
            $table->boolean('entregadodepto')->default(false);
            $table->timestamps();

            $table->foreign('recomendacion_id')->references('id')->on('recomendacions')
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
        Schema::dropIfExists('dictamens');
    }
}
