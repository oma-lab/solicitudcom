<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\DatosPrueba;

class AdminFormatoTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;
    
    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->secretario = User::create($this->secretario);
    }
    

    public function test_vista_formato(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('formato'));
        $response->assertViewHas('datospdf');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

    public function test_vista_previa(){
        $response = $this->actingAs($this->secretario)
                         ->post(route('vistaprevia'),['headtext' => 'encabezado de la hoja membretada']);
        $response->assertSuccessful();
    }

    public function test_cambiar_formato(){
        Storage::fake('public');
        $imagen = UploadedFile::fake()->create('imagen.png', 1000);
        $response = $this->actingAs($this->secretario)
                         ->from(route('formato'))
                         ->post(route('cambiar.formato'),['img_subida' => $imagen,'img' => 'pie1']);

        Storage::disk('public')->assertExists('formato/'.$imagen->hashName());
        $response->assertRedirect(route('formato'));

    }

    public function test_eliminar_formato(){
        $this->assertDatabaseHas('formatos', [
            'id' => 1, 
        ]);
        $response = $this->actingAs($this->secretario)
                         ->from(route('formato'))
                         ->delete(route('eliminar.formato'),['img' => 'pie1']);
        $this->assertAuthenticated();
        $this->assertDatabaseMissing('formatos', [
            'pie1' => '',
        ]);
        $response->assertRedirect(route('formato'));
    }
    
    public function test_registrar_documento(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('solicitudes'))
                         ->get(route('registrar.documento'));
        $this->assertAuthenticated();
        $response->assertViewHas('carreras');
        $response->assertViewHas('adscripciones');
        $response->assertSuccessful();
    }
    
    public function test_generar_documento(){
        $this->assertDatabaseMissing('users', [
            'identificador' => '14160300',
        ]);
        $this->assertDatabaseMissing('solicituds', [
            'asunto' => 'prorroga para cursar el semestre 13', 'identificador' => '14160300',
        ]);
        $response = $this->actingAs($this->secretario)
                         ->from(route('registrar.documento'))
                         ->post(route('generar.documento'),
                                      ['identificador' => '14160300',
                                       'nombre' => 'pedro',
                                       'apellido_paterno' => 'ramirez',
                                       'apellido_materno' => 'lopez',
                                       'sexo' => 'H',
                                       'role_id' => 3,
                                       'carrera_id' => 1,
                                       'adscripcion_id' => null,
                                       'asunto' => 'prorroga para cursar el semestre 13',
                                       'motivos_academicos' => '',
                                       'motivos_personales' => '',
                                       'otros_motivos' => '',
                                       'fecha' => 2020-11-20,
                                       'semestre' => 12,
                                       'carrera_profesor' => null,
                                       'calendario_id' => 1,
                                       ]);
        $this->assertDatabaseHas('users', [
            'identificador' => '14160300',
        ]);
        $this->assertDatabaseHas('solicituds', [
            'asunto' => 'prorroga para cursar el semestre 13', 'identificador' => '14160300',
        ]);
        $response->assertSuccessful();
    }
}
