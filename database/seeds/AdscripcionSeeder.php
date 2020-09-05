<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Adscripcion;

class AdscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('adscripcions')->truncate();
        Adscripcion::create(['id' => 1, 'nombre_adscripcion' => 'Departamento de sistemas y computación', 'tipo' => 'carrera']);
        Adscripcion::create(['id' => 2, 'nombre_adscripcion' => 'Departamento de química', 'tipo' => 'carrera']);
        Adscripcion::create(['id' => 3, 'nombre_adscripcion' => 'Departamento de ingeniería eléctrica', 'tipo' => 'carrera']);
        Adscripcion::create(['id' => 4, 'nombre_adscripcion' => 'Departamento de ingeniería electrónica', 'tipo' => 'carrera']);
        Adscripcion::create(['id' => 5, 'nombre_adscripcion' => 'Departamento de metal-mecánica', 'tipo' => 'carrera']);
        Adscripcion::create(['id' => 6, 'nombre_adscripcion' => 'Departamento de ciencias de la tierra', 'tipo' => 'carrera']);
        Adscripcion::create(['id' => 7, 'nombre_adscripcion' => 'Departamento de ingeniería industrial', 'tipo' => 'carrera']);
        Adscripcion::create(['id' => 8, 'nombre_adscripcion' => 'Departamento de ciencias económico administrativas', 'tipo' => 'carrera']);
        Adscripcion::create(['id' => 9, 'nombre_adscripcion' => 'Dirección', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 10, 'nombre_adscripcion' => 'Subdirección académica', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 11, 'nombre_adscripcion' => 'División de estudios profesionales', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 12, 'nombre_adscripcion' => 'Departamento de desarrollo académico', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 13, 'nombre_adscripcion' => 'División de estudios de posgrado e investigación', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 14, 'nombre_adscripcion' => 'Departamento de recursos humanos', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 15, 'nombre_adscripcion' => 'Departamento de recursos financieros', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 16, 'nombre_adscripcion' => 'Departamento de recursos materiales', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 17, 'nombre_adscripcion' => 'Centro de cómputo', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 18, 'nombre_adscripcion' => 'Departamento de mantenimiento y equipo', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 19, 'nombre_adscripcion' => 'subdirección administrativa', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 20, 'nombre_adscripcion' => 'subdirección de planeación y vinculación', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 21, 'nombre_adscripcion' => 'Departamento de comunicación y difusión', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 22, 'nombre_adscripcion' => 'Departamento de planeación,programación y presupuestación', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 23, 'nombre_adscripcion' => 'Departamento de gestión tecnológica y vinculación', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 24, 'nombre_adscripcion' => 'Departamento de actividades extraescolares', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 25, 'nombre_adscripcion' => 'Departamento de servicios escolares', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 26, 'nombre_adscripcion' => 'Centro de información', 'tipo' => 'administrativo']);
        Adscripcion::create(['id' => 27, 'nombre_adscripcion' => 'Departamento de ciencias básicas', 'tipo' => 'administrativo']);
        

        //
    }
}
