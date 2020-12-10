<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Calendario;
use App\Solicitud;
use App\Observaciones;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $this->solicitud_por_secretario = Solicitud::create($this->solicitud_por_secretario);
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

    public function test_actualizar_solicitud(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('solicitudes'))
                         ->get(route('actualizar.solicitud',$this->solicitud_enviada_coor['id']));
        $this->assertAuthenticated();
        $response->assertViewHas('solicitud');      
        $response->assertStatus(200);
    }

    public function test_guardar_solicitud(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('actualizar.solicitud',$this->solicitud_enviada_coor['id']))
                         ->patch(route('guardar.solicitud',$this->solicitud_enviada_coor['id']),
                                      ['calendario_id' => $this->solicitud_enviada_coor['calendario_id'],
                                       'usuarios' => [$this->jefe['identificador']]]);
        $this->assertAuthenticated();
        $this->assertDatabaseHas('observaciones', [
            'solicitud_id' => $this->solicitud_enviada_coor['id'], 'identificador' => $this->jefe['identificador'],
        ]);
        $response->assertRedirect(route('solicitudes'));
    }

    public function test_subir_solicitud(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('subir.solicitud',$this->solicitud_por_secretario['id']));
        $this->assertAuthenticated();
        $response->assertSuccessful();
        $response->assertViewHas('solicitud');
    }
    
    public function test_guardar_solicitudpdf(){
        Storage::fake('public');
        $imagen = UploadedFile::fake()->create('imagen.png', 1000);
        $response = $this->actingAs($this->secretario)
                         ->from(route('subir.solicitud',$this->solicitud_por_secretario['id']))
                         ->post(route('solicitud.guardar',$this->solicitud_por_secretario['id']),['file' => [$imagen],]);

        $this->assertDatabaseMissing('solicituds', [
            'solicitud_id' => $this->solicitud_por_secretario['id'], 
            'solicitud_firmada' => null,
        ]);
        $response->assertRedirect(route('solicitudes'));
    }


    public function test_vista_posponer(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('vista.posponer'));
        $this->assertAuthenticated();
        $response->assertViewHas('reunion');
        $response->assertViewHas('solicitudes');      
        $response->assertStatus(200);
    }

    public function test_posponer(){
        $this->assertDatabaseHas('solicituds', [
            'id' => $this->solicitud_enviada_coor['id'],
            'calendario_id' => $this->solicitud_enviada_coor['calendario_id'],
        ]);
        $response = $this->actingAs($this->secretario)
                         ->from(route('vista.posponer'))
                         ->post(route('posponer'),['solicitudes' => [$this->solicitud_enviada_coor['id']],
                                                   'nueva_reunion' => 3]);
        $this->assertAuthenticated();
        $this->assertDatabaseMissing('solicituds', [
            'id' => $this->solicitud_enviada_coor['id'],
            'calendario_id' => $this->solicitud_enviada_coor['calendario_id'], 
        ]);
        $response->assertRedirect(route('vista.posponer'));
    }

    
}
