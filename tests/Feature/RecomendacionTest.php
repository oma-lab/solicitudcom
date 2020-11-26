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
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\DatosPrueba;

class RecomendacionTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;
       

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        //datos que deben estar registrados para poder realizar las funciones con las recomendaciones
        $this->usuario = User::create($this->usuario_correcto);
        $this->coordinador = User::create($this->coordinador);
        $this->solicitud = Solicitud::create($this->solicitud_enviada_coor);
        $this->observacion_coordinador = Observaciones::create($this->observacion_coordinador);
        $this->jefe = User::create($this->jefe);
        $this->observacion_jefe = Observaciones::create($this->observacion_jefe);
        $this->subdirector = User::create($this->subdirector);
        $this->recomendacion = Recomendacion::create($this->recomendacion);
    }
        

    public function test_ver_recomendaciones_pendientes(){
        //el subdirector debe autenticarse para acceder a la vista
        $response = $this->actingAs($this->subdirector)
                         ->get(route('recomendaciones'));
        $this->assertAuthenticated();
        //los datos que se pasan a la vista son las recomendaciones registradas
        $response->assertViewHas('recomendaciones');      
        $response->assertStatus(200);
    }

    public function test_ver_recomendaciones_finalizadas(){
        $response = $this->actingAs($this->subdirector)
                         ->get(route('recomendaciones.finalizadas'));
        $this->assertAuthenticated();
        $response->assertViewHas('recom');
        $response->assertViewHas('carreras');
        $response->assertStatus(200);
    }


    public function test_editar_recomendacion(){
        //para editar la recomendacion debe haber por lo menos una registrada
        $this->assertDatabaseHas('recomendacions', [
            'id' => $this->recomendacion['id'],
        ]);
        //se accede a la ruta pasandole el id de la recomendacion a editar
        $response = $this->actingAs($this->subdirector)
                         ->from(route('recomendaciones'))
                         ->get(route('editar.recomendacion',1));
        $this->assertAuthenticated();
        //para corrobar que redirige a la vista debe pasar los datos de la recomendacion
        $response->assertViewHas('recomendacion');
        $response->assertSuccessful();

    }

    public function test_guardar_cambios_recomendacion(){
        //se mandan los datos que seran actualizados en la recomendacion
        $response = $this->actingAs($this->subdirector)
                         ->from(route('recomendaciones'))
                         ->patch(route('guardar.recomendacion',1),[
                             'fecha' => '2020-06-19',
                             'num_oficio' => 'CA-00-256/20',
                             'num_recomendacion' => '571/20',
                             'respuesta' => 'SI',
                             'condicion' => 'condicion de prueba que se actualiza',
                             'motivos' => 'Considerando las evidencias presentadas por el estudiante y su avance académico en el programa educativo de ingeniería en sistemas'
                         ]);
        //un dato que se mando fue el cambio de condicion
        //se comprueba que se haya actualizado
        $this->assertDatabaseHas('recomendacions', [
            'id' => $this->recomendacion['id'], 'condicion' => 'condicion de prueba que se actualiza'
        ]);
        //debe de redirigir a la vista de las recomendaciones
        $response->assertRedirect(route('recomendaciones'));
    }



    public function test_subir_recomendacion_firmada(){
        //la recomendacion se sube en formato pdf
        //para ello se prueba con archivos ficticios
        Storage::fake('public');
        $file = UploadedFile::fake()->create('recomendacion.pdf', 1000);

        //a la ruta se le pasa el id de la recomendacion y el archivo a subir
        $response = $this->actingAs($this->subdirector)
                         ->from(route('recomendaciones'))
                         ->patch(route('guardar.recomendacion',$this->recomendacion['id']),
                         ['doc_firmado' => $file]);
      
        // afirma que el archivo fue almacenado
        Storage::disk('public')->assertExists('subidas/'.$file->hashName());
        $response->assertRedirect(route('recomendaciones'));
    }


    public function test_eliminar_recomendacion(){
        //recomendacion existente
        $this->assertDatabaseHas('recomendacions', [
            'id' => $this->recomendacion['id'],
        ]);

        //se pasa el id de la recomendacion a eliminar
        $response = $this->actingAs($this->subdirector)
                         ->from(route('recomendaciones'))
                         ->delete(route('eliminar.recomendacion', $this->recomendacion['id']));
        //asegura que la recomendacion se hay eliminado
        $this->assertDeleted('recomendacions', ['id' => $this->recomendacion['id']]);
        $response->assertRedirect(route('recomendaciones'));

    }


    public function test_generar_recomendacion_pdf(){
        //para que el pdf recomendacion se pueda generar se debe de haber registrado el secretario y el director
        $secretario = User::create($this->secretario);
        $director = User::create($this->director);
        //se comprueba que se genera la recomendacion pasando el id de la recomendacion
        $response = $this->actingAs($this->subdirector)
                         ->from(route('recomendaciones'))
                         ->get(route('generar.recomendacion',$this->recomendacion['id']));
        $response->assertSuccessful();
        
    }


    public function test_enviar_recomendacion(){
        //recomendacion no enviada
        $this->assertDatabaseHas('recomendacions', [
            'id' => $this->recomendacion['id'], 'enviado' => false
        ]);
        //se afirma que la recomendacion ha sido enviada
        $response = $this->actingAs($this->subdirector)
                         ->from(route('recomendaciones'))
                         ->get(route('enviar.recomendacion',1));
        //Corrobora que se envio
        $this->assertDatabaseHas('recomendacions', [
            'id' => $this->recomendacion['id'], 'enviado' => true
        ]);
        $response->assertRedirect(route('recomendaciones'));

    }
    

}
