<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersDictamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_dictamenes', function (Blueprint $table) {
            $table->string('identificador');
            $table->unsignedBigInteger('dictamen_id');
            $table->boolean('recibido')->default(false);
            $table->string('label')->nullable();
            $table->foreign('identificador')->references('identificador')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('dictamen_id')->references('id')->on('dictamens')
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
        Schema::dropIfExists('users_dictamenes');
    }
}
