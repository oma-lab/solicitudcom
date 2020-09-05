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

class JefeSolicitudTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');//registra datos de prueba, carreras,adscripciones,roles y asuntos
        //Datos que deben estar registrados para realizar las funciones sobre las solicitudes
        $this->usuario_correcto = User::create($this->usuario_correcto);
        $this->coordinador = User::create($this->coordinador);
        $this->solicitud_enviada_coor = Solicitud::create($this->solicitud_enviada_coor);
        $this->observacion_coordinador = Observaciones::create($this->observacion_coordinador);
        $this->jefe = User::create($this->jefe);
    }



    public function test_verSolicitudes(){
        //corrobora que la ruta sea correcta y que se redirige bien
        $response = $this->actingAs($this->jefe)
                         ->get(route('jefe.solicitudes','pendientes'));
        $this->assertAuthenticated();//afirma que el jefe esta autenticado
        $response->assertViewHas('solicitudes');//las vista debe mostrar las solicitiudes
        $response->assertStatus(200);
        //comprueba que se haga el filtrado correctamente(finalizadas, nombre, carrera)
        $response = $this->get(route('jefe.solicitudes','finalizadas'),
                           ['nombre' => $this->usuario_correcto['nombre'], 
                            'carrera_id' => $this->usuario_correcto['carrera_id']]);
        $response->assertViewHas('solicitudes');
        $response->assertStatus(200);
        //afirma que las solicitudes se filtren por vistas 
        $response = $this->get(route('jefe.solicitudes','pendientes'),['visto' => true]);
        $response->assertViewHas('solicitudes');
        $response->assertStatus(200);
    }


    public function test_marcar_recibido(){
        //comprueba que el jefe se autentique y los datos se manden correctamente
        $response = $this->actingAs($this->jefe)
                         ->post(route('guardar.observacion'),
                               ['solicitud_id' => 1, 
                                'descripcion' => 'Si se acepta', 
                                'voto' => 'SI']);
        $this->assertAuthenticated();//verifica que el usuario si se haya autenticado
        //afirma que la solicitud se marque como visto y se guarden las observaciones hechas
        $this->assertDatabaseHas('observaciones', [
            'identificador' => $this->jefe['identificador'],
            'visto' => true,
        ]);
    }
}
