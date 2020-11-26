<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Asunto;
use Tests\DatosPrueba;

class AsuntoTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    
    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->secretario = User::create($this->secretario);
    }
    

    public function test_ver_asuntos(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('asuntos'));
        $response->assertViewHas('asuntos');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

    public function test_guardar_asunto(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('asuntos'))
                         ->post(route('guardar.asunto'),['asunto' => 'prorroga para concluir servicio social','descripcion' => 'especifique el tiempo']);
        $this->assertAuthenticated();
        $this->assertDatabaseHas('asuntos', [
            'asunto' => 'prorroga para concluir servicio social', 
        ]);
        $response->assertRedirect(route('asuntos'));
    }

    public function test_actualizar_asunto(){
        $this->asunto = Asunto::create($this->asunto);
        $this->assertDatabaseHas('asuntos', [
            'asunto' => $this->asunto['asunto'], 
        ]);

        $response = $this->actingAs($this->secretario)
                         ->from(route('asuntos'))
                         ->patch(route('actualizar.asunto',$this->asunto['id']),['asunto' => $this->asunto['asunto'], 'descripcion' => 'indique el periodo y las materias a cursar']);
        $this->assertAuthenticated();
        $this->assertDatabaseMissing('asuntos', [
            'descripcion' => $this->asunto['descripcion'], 
        ]);
        $response->assertRedirect(route('asuntos'));
    }

    public function test_eliminar_asunto(){
        $this->asunto = Asunto::create($this->asunto);
        $this->assertDatabaseHas('asuntos', [
            'asunto' => $this->asunto['asunto'], 
        ]);

        $response = $this->actingAs($this->secretario)
                         ->from(route('asuntos'))
                         ->delete(route('eliminar.asunto',$this->asunto['id']));
        $this->assertAuthenticated();
        $this->assertDeleted('asuntos', ['id' => $this->asunto['id']]);
        $response->assertRedirect(route('asuntos'));
    }
}
