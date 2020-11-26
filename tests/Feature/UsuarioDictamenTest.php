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

class UsuarioDictamenTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->usuario_correcto = User::create($this->usuario_correcto);
        $this->coordinador = User::create($this->coordinador);
        $this->subdirector = User::create($this->subdirector);
        $this->solicitud_enviada_coor = Solicitud::create($this->solicitud_enviada_coor);
        $this->recomendacion_enviada = Recomendacion::create($this->recomendacion_enviada);
        $this->dictamen_enviado = Dictamen::create($this->dictamen_enviado);
    }
    

    public function test_solicitante_ver_dictamen(){
        $response = $this->actingAs($this->usuario_correcto)
                         ->get(route('dictamenes'));
        $response->assertViewHas('ds');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

    public function test_subdirector_ver_dictamenes(){
        $response = $this->actingAs($this->subdirector)
                         ->get(route('sub.dictamenes'));
        $response->assertViewHas('dictamenes');
        $response->assertViewHas('carreras');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }
}
