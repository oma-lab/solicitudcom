<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Calendario;
use App\Solicitud;
use App\Observaciones;
use Tests\DatosPrueba;

class SecretarioSolicitudTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    
    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->usuario_correcto = User::create($this->usuario_correcto);
        $this->coordinador = User::create($this->coordinador);
        $this->solicitud_enviada_coor = Solicitud::create($this->solicitud_enviada_coor);
        $this->observacion_coordinador = Observaciones::create($this->observacion_coordinador);
        $this->jefe = User::create($this->jefe);
        $this->observacion_jefe = Observaciones::create($this->observacion_jefe);
        $this->secretario = User::create($this->secretario);
    }


    public function test_ver_solicitudes(){
        //corrobora que se rediriga al secretario a la vista correcta
        $response = $this->actingAs($this->secretario)->get(route('solicitudes'));
        $this->assertAuthenticated();
        $response->assertViewHas('solicitudes');      
        $response->assertStatus(200);
    }

    public function test_dar_respuesta_solicitud(){
        //el secretario debe dar una respuesta a la solicitud
        $response = $this->actingAs($this->secretario)
                         ->from(route('solicitudes'))
                         ->patch(route('respuesta.solicitud',$this->solicitud_enviada_coor['id']),
                                      ['respuesta' => 'SI']);
        $this->assertAuthenticated();//afirma que el secretario esta autenticado
        //comprueba que se cree recomendacion al dar respuesta a la solicitud
        $this->assertDatabaseHas('recomendacions', [
            'id_solicitud' => $this->solicitud_enviada_coor['id'], 'respuesta' => 'SI',
        ]);
        $response->assertRedirect(route('solicitudes'));

    }

    
}
