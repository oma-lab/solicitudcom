<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('roles')->truncate();
        Role::create(['id' => 1, 'nombre_rol' => 'administrador']); //id => 1
        Role::create(['id' => 2, 'nombre_rol' => 'director']); //id => 2
        Role::create(['id' => 3, 'nombre_rol' => 'estudiante']); //id => 3
        Role::create(['id' => 4, 'nombre_rol' => 'docente']); //id => 4
        Role::create(['id' => 5, 'nombre_rol' => 'jefe']); //id => 5
        Role::create(['id' => 6, 'nombre_rol' => 'coordinador']); //id => 6
        Role::create(['id' => 7, 'nombre_rol' => 'integrante']); //id => 7
        Role::create(['id' => 8, 'nombre_rol' => 'subdirector']); //id => 8
        Role::create(['id' => 9, 'nombre_rol' => 'superusuario']); //id => 9
        Role::create(['id' => 10, 'nombre_rol' => 'depto']); //id => 10
        //
    }
}
