<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('users')->whereIn('id',[1,2])->delete();
        DB::table('oauth_clients')->truncate();
        DB::table('oauth_personal_access_clients')->truncate();        
        User::create(['identificador' => 'superusuario', 'nombre' => 'Super', 'apellido_paterno' => 'Super', 'apellido_materno' => 'Super', 'sexo' => 'H', 'role_id' => 9, 'password' => bcrypt('superpass10'), 'id' => 1]);
        User::create(['identificador' => 'secretario', 'nombre' => 'Secretario', 'apellido_paterno' => 'Secretario', 'apellido_materno' => 'Secretario', 'sexo' => 'H', 'adscripcion_id' => 3,'role_id' => 1, 'password' => bcrypt('secretariopass10'), 'id' => 2]);
        DB::table('oauth_clients')->insert(['id'=>1, 'name'=>'Comité Académico Personal Access Client', 'secret'=>'3mnL24keCpNcffmcID2bbpytXnsYmxlyjLztwyuV', 'redirect'=>'http://localhost', 'personal_access_client'=>1, 'password_client'=>0, 'revoked'=>0]);
        DB::table('oauth_clients')->insert(['id'=>2, 'name'=>'Comité Académico Password Grant Client', 'secret'=>'8MsFCQZUO5lDDbt47H7N3sRVjayx6IPJw06Hny3S', 'redirect'=>'http://localhost', 'personal_access_client'=>0, 'password_client'=>1, 'revoked'=>0]);
        DB::table('oauth_personal_access_clients')->insert(['id'=>1, 'client_id'=>1]);
        //
    }
}
