<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        // $this->call(UsersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(CarreraSeeder::class);
        $this->call(AdscripcionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AsuntoSeeder::class);
        $this->call(CarreraDepartamentoSeeder::class);
        $this->call(FormatoSeeder::class);
        $this->call(UsuarioSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
