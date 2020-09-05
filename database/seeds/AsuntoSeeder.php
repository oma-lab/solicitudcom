<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Asunto;

class AsuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('asuntos')->truncate();
        Asunto::create(['asunto' => 'prorroga para cursar 13 semestre','descripcion' => 'A continuación complete el asunto si lo considera necesario', 'ejemplo' => 'Prorroga para cursar semestre 13']);
        Asunto::create(['asunto' => 'cambio de Carrera','descripcion' => 'Describa el asunto de la solicitud', 'ejemplo' => 'Cambio de carrera de ingenieria civil a ingenieria en gestion empresarial']);
        Asunto::create(['asunto' => 'baja de carrera','descripcion' => 'Describa el asunto de la solicitud', 'ejemplo' => 'Baja de la carrera de ingenieria civil para poder reingresar a la carrera de ingenieria mecanica']);
        Asunto::create(['asunto' => 'prórroga para titulación','descripcion' => 'indique mediante que opción es la titulación']);
        Asunto::create(['asunto' => 'prórroga para concluir residencia profesional','descripcion' => 'indique el nombre del proyecto, la empresa donde se está realizando y el periodo']);
        Asunto::create(['asunto' => 'cancelación de residencia','descripcion' => 'indique el nombre del proyecto, el nombre de la empresa donde se está realizando y el periodo']);
        Asunto::create(['asunto' => 'autorización de proyecto para cursar residencia con la(s) materia(s)','descripcion' => 'indique el nombre de la(s) materia(s) con su clave y el tipo de curso(recurso,especial)']);
        Asunto::create(['asunto' => 'baja de la materia','descripcion' => 'Indique nombre de la materia y clave']);
        Asunto::create(['asunto' => 'cambio de grupo','descripcion' => 'Indique el nombre de la materia ,los grupos y los horarios']);
        Asunto::create(['asunto' => 'asignación de profesor para la materia','descripcion' => 'indique la materia con su clave,grupo y hora']);
        Asunto::create(['asunto' => 'revisión de calificación de la materia','descripcion' => 'Indique el nombre de la materia y clave']);
        Asunto::create(['asunto' => 'baja de semestre','descripcion' => 'indique el periodo del semestre']);
        Asunto::create(['asunto' => 'prorroga para concluir carrera','descripcion' => 'Indique el semestre y el periodo en el cual lo va a cursar']);
        Asunto::create(['asunto' => 'baja temporal','descripcion' => 'indique el periodo de la baja']);
        Asunto::create(['asunto' => 'baja Extra temporánea','descripcion' => 'indique el periodo']);
        //
    }
}
