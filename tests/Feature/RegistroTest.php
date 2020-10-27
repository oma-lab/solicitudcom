<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\DatosPrueba;

class RegistroTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;
    

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');//registra datos de prueba, carreras,adscripciones,roles y asuntos
    }

    //prueba que la vista de registro se muestre
    public function test_vista_de_registro(){
        $response = $this->get('/register');
        //corrobora que los datos se pasen correctamente
        $response->assertViewHas('carreras');
        //corrobora que no ha ocurrio ningun problema
        $response->assertStatus(200);
    }

    //registrar usuario
    public function test_registrar_usuario(){
        //se registra el usuario con los datos de prueba
        $response = $this->post(route('register'), $this->usuario_correcto);
        //comprueba que el usaurio se ha creado
        $this->assertDatabaseHas('users', [
            'identificador' => $this->usuario_correcto['identificador']
        ]);
        //comprueba que se rediriga a la ruta correcta que es home
        $response->assertRedirect('/home');
        //corrobora que el usuario registrado se autentique
        $this->assertAuthenticated();
    }


    //registrar usuario con datos incorrectos
    public function test_registrar_usuario_incorrecto(){
        //se registra un usuario con datos incorrectos
        $response = $this->post(route('register'), $this->usuario_incorrecto);
        //assert que indica que hay errores, no se ingresa apellido_paterno y la confirmacion de carrera es incorrecto
        $response->assertSessionHasErrors('apellido_paterno','password');
        //usuario no autenticado
        $this->assertGuest();
    }
}
