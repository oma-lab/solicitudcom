<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Tests\DatosPrueba;

class LoginTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');//registra datos de prueba, carreras,adscripciones,roles y asuntos
    }


    //acceder a vista de login
    public function test_mostrar_vista_login(){
        $response = $this->get('/login');
        //valida que se diriga a la vista correcta
        $response->assertSee('Iniciar sesión');
        $response->assertStatus(200);
        //comprobar que la vista retornada desde el controlador es la que esperamos,en este caso esperamos que la vista sea auth.login
        $response->assertViewIs('auth.login');
    }


    //cuando el usuario inicia sesion
    public function test_login_correcto(){
        //el usuario debe estar registrado para acceder        
        $user = User::create($this->usuario_login);
        //se ingresa el identificador y su contraseña
        $response = $this->post('/login', [
            'identificador' => $user->identificador,
            'password' => 'password',
        ]);
        //indica que el usuario esta atenticado
        $this->assertAuthenticatedAs($user);
        //si el acceso es correcto lo redireccionar a la ruta home
        $response->assertRedirect(route('home'));
    }


    //cuando el usuario intenta iniciar sesion con datos incorrectos
    public function test_login_incorrecto(){
        //el usuario debe estar registrado para acceder    
        $user = User::create($this->usuario_login);
        $response = $this->post('/login', [
            'identificador' => 'incorrecto',
            'password' => 'password',
        ]);//no se envia ningun dato
        //hay error con los datos ingresados
        $response->assertSessionHasErrors('identificador');
        //cuando hay error el usuario no se autentica
        $this->assertGuest();
    }

}
