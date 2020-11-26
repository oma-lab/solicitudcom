<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Calendario;
use Tests\DatosPrueba;

class CalendarioTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;


    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->usuario_correcto = User::create($this->usuario_correcto);
        $this->secretario = User::create($this->secretario);
    }
    
    //aplica para solicitante,coordinador e integrantes
    public function test_mostrar_calendario(){
        $response = $this->actingAs($this->usuario_correcto)
                         ->get(route('usuario.calendario'));
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

    public function test_agregar_fecha(){
        $fecha = calculafecha('7 days');
        $response = $this->actingAs($this->secretario)
                         ->from(route('admin.calendario'))
                         ->post(route('guardar.fecha'),['title' => 'reunión de Comité Académico',
                                      'start' => $fecha]);
        $this->assertAuthenticated();
        $this->assertDatabaseHas('calendarios', [
            'start' => $fecha, 
        ]);
        $response->assertSuccessful();
    }

    public function test_eliminar_fecha(){
        $fecha = calculafecha('3 days');
        $calendario = Calendario::create(['title' => 'reunión de Comité Académico','start' => $fecha]);
        $this->assertDatabaseHas('calendarios',[
            'start' => $fecha, 
        ]);
        $response = $this->actingAs($this->secretario)
                         ->from(route('admin.calendario'))
                         ->delete(route('eliminar.fecha',$calendario['id']));
        $this->assertDeleted('calendarios', ['id' => $calendario['id']]);
        $response->assertSuccessful();
    }
}
