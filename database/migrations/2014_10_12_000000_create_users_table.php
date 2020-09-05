<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identificador')->unique(); 
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->default("")->nullable();
            $table->char('sexo',1);
            $table->string('celular')->nullable();
            $table->string('telefono')->nullable();
            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->unsignedBigInteger('adscripcion_id')->nullable();   
            $table->integer('role_id')->nullable();
            $table->string('grado')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('token')->nullable();
            $table->rememberToken();
            $table->timestamps();

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
        Schema::dropIfExists('users');
    }
}
