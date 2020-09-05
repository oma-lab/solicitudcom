<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Calendario;

class ReunionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('calendarios')->truncate();
        //fechas que usaremos para los Test
        //una reunion pasada
        Calendario::create(['title' => 'reunión de Comité Académico','start' => calculafecha('- 5 days')]);
        //reunion actual
        Calendario::create(['title' => 'reunión de Comité Académico','start' => hoy()]);
        //reunion proxima
        Calendario::create(['title' => 'reunión de Comité Académico','start' => calculafecha('5 days')]);
    }
}
