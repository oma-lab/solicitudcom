<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('formatos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('head1')->nullable();
            $table->string('head2')->nullable();
            $table->string('head3')->nullable();
            $table->string('headtext')->nullable();
            $table->string('body')->nullable();
            $table->string('pie1')->nullable();
            $table->string('pie2')->nullable();
            $table->string('pie3')->nullable();
            $table->string('pie4')->nullable();
            $table->string('pie5')->nullable();
            $table->string('pie6')->nullable();
            $table->string('pietext')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formatos');
    }
}
