<?php

use Illuminate\Database\Seeder;

class DatabaseTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->call(CarreraSeeder::class);
        $this->call(AdscripcionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AsuntoSeeder::class);
        $this->call(CarreraDepartamentoSeeder::class);
        $this->call(FormatoSeeder::class);
        $this->call(ReunionSeeder::class);
    }
}
