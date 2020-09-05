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

class JefeDictamenTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;



    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->usuario_correcto = User::create($this->usuario_correcto);
        $this->coordinador = User::create($this->coordinador);
        $this->jefe = User::create($this->jefe);
        $this->subdirector = User::create($this->subdirector);
        $this->solicitud_enviada_coor = Solicitud::create($this->solicitud_enviada_coor);
        $this->observacion_coordinador = Observaciones::create($this->observacion_coordinador);
        $this->observacion_jefe = Observaciones::create($this->observacion_jefe);
        $this->recomendacion_enviada = Recomendacion::create($this->recomendacion_enviada);
        $this->dictamen_enviado = Dictamen::create($this->dictamen_enviado);
    }
  

    public function test_ver_dictamenes(){
        $response = $this->actingAs($this->jefe)
                         ->get(route('jefe.dictamenes','no_entregado'));
        $response->assertViewHas('dictamenes');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

    

    public function test_entregar_dictamen(){
        $response = $this->actingAs($this->jefe)
                         ->from(route('jefe.dictamenes','no_entregado'))
                         ->get(route('dictamen.entregado',$this->dictamen_enviado['id']));
        $this->assertAuthenticated();
        $response->assertRedirect(route('jefe.dictamenes','no_entregado'));
    }
}
