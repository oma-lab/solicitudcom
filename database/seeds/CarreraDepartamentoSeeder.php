<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\CarreraDepartamento;
use Illuminate\Database\Schema;

class CarreraDepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('carrera_departamentos')->truncate();
        CarreraDepartamento::create(['carrera_id' => 1,'adscripcion_id' => 1]);
        CarreraDepartamento::create(['carrera_id' => 2,'adscripcion_id' => 2]);
        CarreraDepartamento::create(['carrera_id' => 3,'adscripcion_id' => 3]);
        CarreraDepartamento::create(['carrera_id' => 4,'adscripcion_id' => 4]);
        CarreraDepartamento::create(['carrera_id' => 5,'adscripcion_id' => 5]);
        CarreraDepartamento::create(['carrera_id' => 6,'adscripcion_id' => 6]);
        CarreraDepartamento::create(['carrera_id' => 7,'adscripcion_id' => 7]);
        CarreraDepartamento::create(['carrera_id' => 8,'adscripcion_id' => 8]);
        CarreraDepartamento::create(['carrera_id' => 9,'adscripcion_id' => 8]);
        //
    }
}
