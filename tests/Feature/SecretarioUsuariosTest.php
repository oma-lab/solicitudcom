<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Tests\DatosPrueba;

class SecretarioUsuariosTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');

        $this->secretario = User::create($this->secretario);
        $this->coordinador = User::create($this->coordinador);
        $this->jefe = User::create($this->jefe);

    }

    public function test_ver_usuarios(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('usuarios','integrante'));
        $response->assertViewHas('usuarios');
        $response->assertViewHas('adscripciones');
        $response->assertViewHas('carreras');   
        $response->assertStatus(200); 
    }

    public function test_editar_usuario(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('usuarios.edit',$this->coordinador['id']));
        $response->assertViewHas('usuario');
        $response->assertViewHas('ads_carreras');
        $response->assertSuccessful();
    }
    
    public function test_eliminar_usuario(){
        $this->assertDatabaseHas('users', [
            'id' => $this->coordinador['id'],
        ]);

        $response = $this->actingAs($this->secretario)
                         ->from(route('usuarios','coordinador'))
                         ->delete(route('usuarios.eliminar', $this->coordinador['id']));
        $this->assertDeleted('users', ['id' => $this->coordinador['id']]);
        $response->assertRedirect(route('usuarios','coordinador'));
    }

    public function test_cambiar_permisos(){
        $this->assertDatabaseHas('users', [
            'id' => $this->jefe['id'],            
        ]);
        $response = $this->actingAs($this->secretario)
                         ->from(route('usuarios','integrante'))
                         ->post(route('permisos'),
                           ['iduser' => $this->jefe['id'],
                            'multiple' => [1],//1 es el id de la carrera de sistemas
                            'multipled' => [1],// 1 es el id de la adscripcion del depto de sistemas
                            'role_id' => $this->jefe['role_id']]);

        $this->assertDatabaseHas('user_carreras', [
            'identificador' => $this->jefe['identificador'],
            'carrera_id' => 1,
        ]);
        $this->assertDatabaseHas('user_adscripcions', [
            'identificador' => $this->jefe['identificador'],
            'adscripcion_id' => 1,
        ]);
        $response->assertRedirect(route('usuarios','integrante'));  
    }
}
