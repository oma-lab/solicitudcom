<?php

use Illuminate\Database\Seeder;
use App\Carrera;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('carreras')->truncate();
        Carrera::create(['nombre' => 'Ingeniería en sistemas computacionales']);
        Carrera::create(['nombre' => 'Ingeniería química']);
        Carrera::create(['nombre' => 'Ingeniería eléctrica']);
        Carrera::create(['nombre' => 'Ingeniería electrónica']);
        Carrera::create(['nombre' => 'Ingeniería mecánica']);
        Carrera::create(['nombre' => 'Ingeniería civil']);
        Carrera::create(['nombre' => 'Ingeniería industrial']);
        Carrera::create(['nombre' => 'Ingeniería en gestión empresarial']);
        Carrera::create(['nombre' => 'Licenciatura en administración']);
    }
}
