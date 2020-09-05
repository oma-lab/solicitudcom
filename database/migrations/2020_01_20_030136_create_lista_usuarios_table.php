<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('lista_id');
            $table->string('identificador');
            $table->string('observacion');

            $table->foreign('lista_id')->references('id')->on('lista_asistencias')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('identificador')->references('identificador')->on('users')
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
        Schema::dropIfExists('lista_usuarios');
    }
}
