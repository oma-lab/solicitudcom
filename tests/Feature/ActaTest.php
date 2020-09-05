<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Calendario;
use App\ListaAsistencia;
use App\ListaUsuario;
use App\Invitado;
use App\Acta;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Solicitud;
use App\Recomendacion;
use Tests\DatosPrueba;

class ActaTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    
    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->secretario = User::create($this->secretario);
        $this->subdirector = User::create($this->subdirector);
        $this->jefe = User::create($this->jefe);
        $this->jefequimica = User::create($this->jefequimica);
        $this->lista_asistencia = ListaAsistencia::create($this->lista_asistencia);
        $this->asistencia_subdirector = ListaUsuario::create($this->asistencia_subdirector);
        $this->asistencia_jefe = ListaUsuario::create($this->asistencia_jefe);
        $this->asistencia_jefequimica = ListaUsuario::create($this->asistencia_jefequimica);
        $this->usuario_correcto = User::create($this->usuario_correcto);
        $this->solicitud_enviada_coor = Solicitud::create($this->solicitud_enviada_coor);
        $this->recomendacion = Recomendacion::create($this->recomendacion);
    }
    

    public function test_ver_actas(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('acta.index'));
        $response->assertViewHas('reunion');
        $response->assertViewHas('actas');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }



    public function test_crear_acta(){ 
        $response = $this->actingAs($this->secretario)
                         ->from(route('acta.index'))
                         ->get(route('acta.create',['calendario_id' => 1]));
        $this->assertAuthenticated();
        $response->assertViewHas('reunion');
        $response->assertViewHas('asistentes');
        $response->assertViewHas('recomendaciones');
        $response->assertViewHas('invitados');
        $response->assertViewHas('fechauno');
        $response->assertViewHas('fechados');
        $response->assertSuccessful();

    }


    public function test_registrar_acta(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('acta.create',['calendario_id' => 1]))
                         ->post(route('acta.store'),['titulo' => 'sagfas','contenido' => 'gadg','calendario_id' => 1]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('acta.index'));

    }


    public function test_editar_acta(){
        $this->acta = Acta::create($this->acta);
        $response = $this->actingAs($this->secretario)
                         ->get(route('acta.edit',1));
        $response->assertViewHas('acta');
        $response->assertSuccessful();
    }
    

    public function test_actualizar_acta(){
        $this->acta = Acta::create($this->acta);
        $this->assertDatabaseHas('actas', [
            'contenido' => 'CONTENIDO ACTA', 
        ]);

        $response = $this->actingAs($this->secretario)
                         ->from(route('acta.edit',1))
                         ->patch(route('acta.update',1),['contenido' => 'CAMBIOS CONTENIDO ACTA']);
        $this->assertAuthenticated();
        $this->assertDatabaseMissing('actas', [
            'contenido' => 'CONTENIDO ACTA', 
        ]);
        $response->assertRedirect(route('acta.index'));

    }



    public function test_eliminar_acta(){
        $this->acta = Acta::create($this->acta);
        $this->assertDatabaseHas('actas', [
            'contenido' => 'CONTENIDO ACTA', 
        ]);

        $response = $this->actingAs($this->secretario)
                         ->from(route('acta.index'))
                         ->delete(route('acta.destroy',1));
        $this->assertAuthenticated();
        $this->assertDeleted('actas', ['id' => $this->acta['id']]);
        $response->assertRedirect(route('acta.index'));

    }

    

    public function test_descargar_acta_pdf(){
        $this->acta = Acta::create($this->acta);
        $response = $this->actingAs($this->secretario)
                         ->from(route('acta.index'))
                         ->get(route('descargar.acta',$this->acta['id']));
        $response->assertSuccessful();

    }
    
}