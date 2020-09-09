<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Formato;

class FormatoSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('formatos')->truncate();
        Formato::create(['head1' => 'formato/head1.png', 
                         'head2' => 'formato/head2.png', 
                         'headtext' => '"2020,Año de Leona Vicario, Benemérita Madre de la Patria"',
                         'body' => 'formato/body.png',
                         'pie1' => 'formato/pie1.png',
                         'pie6' => 'formato/pie6.png',
                        ]);
        //
    }
}
