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
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\DatosPrueba;

class DirectorDictamenTest extends TestCase{
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
        $this->subdirector = User::create($this->subdirector);
        $this->secretario = User::create($this->secretario);
        $this->recomendacion_enviada = Recomendacion::create($this->recomendacion_enviada);
        $this->director = User::create($this->director);
        $this->dictamen = Dictamen::create($this->dictamen);
    }
    

    public function test_mostrar_dictamenes(){
        //afirma que la vista se muestre con los datos correctos
        $response = $this->actingAs($this->director)
                         ->get(route('director.dictamenes','pendientes'));
        $response->assertViewHas('dictamenes');
        $response->assertSuccessful();
        //comprueba que los filtrados se hagan, dictamenes no entregados y dictamenes terminados
        $response = $this->actingAs($this->director)
                         ->get(route('director.dictamenes','noentregado'));
        $response->assertViewHas('dictamenes');
        $response->assertSuccessful();
        $response = $this->actingAs($this->director)
                         ->get(route('director.dictamenes','terminado'));
        $response->assertViewHas('dictamenes');
        $response->assertSuccessful();
    }

    
    public function test_editar_dictamen(){
        $response = $this->actingAs($this->director)
                         ->get(route('editar.dictamen',$this->dictamen['id']));
        $response->assertViewHas('dictamen');
        $response->assertSuccessful();
    }


    public function test_guardar_dictamen(){
        $this->assertDatabaseHas('dictamens', [
            'respuesta' => $this->dictamen['respuesta'],            
        ]);
        $response = $this->actingAs($this->director)
                         ->from(route('director.dictamenes','pendientes'))
                         ->patch(route('guardar.dictamen',$this->dictamen['id']),['respuesta' => 'NO']);
        //comprueba que el cambio se haya echo, 
        $this->assertDatabaseMissing('dictamens', [
            'respuesta' => $this->dictamen['respuesta'], 
        ]);
        $response->assertRedirect(route('director.dictamenes','pendientes'));
        
    }

    
    public function test_ver_dictamen_pdf(){
        //comprueba que la vista se muestre
        $response = $this->actingAs($this->director)
                         ->get(route('dictamen.pdf',$this->dictamen['id']));
        $response->assertSuccessful();
    }
    

    public function test_enviar_dictamen(){  
        $this->assertDatabaseHas('dictamens', [
            'enviado' => $this->dictamen['enviado'],            
        ]);
        $response = $this->actingAs($this->director)
                         ->from(route('director.dictamenes','pendientes'))
                         ->get(route('enviar.dictamen',$this->dictamen['id']));
        //comprueba que el cambio se haya echo
        $this->assertDatabaseMissing('dictamens', [
            'enviado' => $this->dictamen['enviado'], 
        ]);
        $response->assertRedirect(route('director.dictamenes','pendientes'));

    }
    
    
}
