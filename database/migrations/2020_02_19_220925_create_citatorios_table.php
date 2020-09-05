<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citatorios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->string('oficio',15);
            $table->string('archivo')->nullable();
            $table->boolean('enviado')->default(false);
            $table->unsignedBigInteger('calendario_id');
            

            $table->foreign('calendario_id')->references('id')->on('calendarios')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citatorios');
    }
}
