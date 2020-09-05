<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Calendario;
use App\Solicitud;
use Tests\DatosPrueba;

class CoordinadorSolicitudTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;
    

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');//registra datos de prueba, carreras,adscripciones,roles y asuntos
        $this->usuario_correcto = User::create($this->usuario_correcto);
        $this->solicitud_enviada = Solicitud::create($this->solicitud_enviada);
        $this->coordinador = User::create($this->coordinador);
    }


    public function test_mostrar_solicitudes(){
        //comprueba que se rediriga a la vista correcta con los datos correctos que debe enviar
        $response = $this->actingAs($this->coordinador)->get(route('coordinador.solicitudes','pendientes'));
        //coordinado autenticado
        $this->assertAuthenticated();
        $response->assertViewHas('solicitudes');//solicitudes recibidas
        $response->assertViewHas('carreras');//Carreras que se muestran para filtrar
        $response->assertStatus(200);
        //afirma que se pueda filtrar por solicitudes finalizadas y que filtre por nombre y carrera
        $response = $this->get(route('coordinador.solicitudes','finalizadas'),['nombre' => 'Daniel', 'carrera_id' => 1]);
        $response->assertViewHas('solicitudes');
        $response->assertStatus(200);
    }


    public function test_cancelar_solicitud(){
        //debe mostrar las solicitudes recibidas
        $response = $this->actingAs($this->coordinador)
                         ->get(route('coordinador.solicitudes','pendientes'));
        $this->assertAuthenticated();//coordinador autenticado
        $response->assertViewHas('solicitudes');
        $response = $this->post(route('solicitud.cancelar'),
                        ['id_sol' => $this->solicitud_enviada['id'],
                        'obs_est' => 'No cumple con lo requerido']);
        //Corrobora que la solicitud de haya cancelado
        $this->assertDatabaseHas('solicituds', [
            'enviado' => false,
        ]);
        //afirma que se hayan agregado observaciones
        $this->assertDatabaseHas('observaciones', [
            'descripcion' => 'No cumple con lo requerido',
        ]);
        $response->assertRedirect(route('coordinador.solicitudes','pendientes'));
    }


    public function test_enviar_solicitud(){
        //afirma que la solicitud se envie a los jefes
        $response = $this->actingAs($this->coordinador)
                         ->post(route('envio.solicitud',$this->solicitud_enviada['id']),
                         ['descripcion' => 'solicitud correcta']);
        $this->assertAuthenticated();
        //corrobora que la solicitud se marca como enviada por parte del coordinador
        $this->assertDatabaseHas('solicituds', [
            'enviadocoor' => true,
        ]);
        //la solciitud debe tener observaciones
        $this->assertDatabaseHas('observaciones', [
            'descripcion' => 'solicitud correcta',
        ]);
    }
}
