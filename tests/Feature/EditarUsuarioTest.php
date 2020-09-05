<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Tests\DatosPrueba;

class EditarUsuarioTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;



    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->usuario_correcto = User::create($this->usuario_correcto);
    }
    
    
    public function test_vista_editar_usuario(){
        $response = $this->actingAs($this->usuario_correcto)
                         ->get(route('solicitante.editar',1));
        $response->assertViewHas('usuario');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

    
    public function test_actualizar_usuario(){
        $this->assertDatabaseHas('users', [
            'password' => $this->usuario_correcto['password'],            
        ]);
        $response = $this->actingAs($this->usuario_correcto)
                         ->from(route('solicitante.home'))
                         ->patch(route('usuario.actualizar',1),
                            ['identificador' => $this->usuario_correcto['password'],
                             'email' => $this->usuario_correcto['email'],
                             'password' => 'nuevopassword']);
        $this->assertDatabaseMissing('users', [
            'password' => $this->usuario_correcto['password'], 
        ]);
        $response->assertRedirect(route('solicitante.home'));
    }


}
