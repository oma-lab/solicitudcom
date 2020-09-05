<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Calendario;
use App\Solicitud;
use App\Observaciones;
use App\Recomendacion;
use App\Dictamen;
use Tests\DatosPrueba;

class CoordinadorDictamenTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;
    

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->usuario_correcto = User::create($this->usuario_correcto);
        $this->coordinador = User::create($this->coordinador);
        $this->solicitud_enviada_coor = Solicitud::create($this->solicitud_enviada_coor);
        $this->recomendacion_enviada = Recomendacion::create($this->recomendacion_enviada);
        $this->dictamen_enviado = Dictamen::create($this->dictamen_enviado);
    }
    

    public function test_ver_dictamenes(){
        //afirma que se rediriga al coordinador a la vista donde se muestran los dictamenes
        $response = $this->actingAs($this->coordinador)
                         ->get(route('coordinador.dictamenes'));
        $response->assertViewHas('dictamenes');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }
}
