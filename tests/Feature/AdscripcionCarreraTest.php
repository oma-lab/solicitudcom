<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Adscripcion;
use App\Carrera;
use Tests\DatosPrueba;

class AdscripcionCarreraTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->secretario = User::create($this->secretario);
    }

    public function test_ver_carreras_adscripciones(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('carrera.adscripcion'));
        $response->assertViewHas('carreras');
        $response->assertViewHas('adscripciones');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

    public function test_guardar_adscripcion(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('carrera.adscripcion'))
                         ->post(route('guardar.adscripcion'),['nombre_adscripcion' => 'Departamento de mantenimiento','tipo' => 'administrativo']);
        $this->assertAuthenticated();
        $this->assertDatabaseHas('adscripcions', [
            'nombre_adscripcion' => 'Departamento de mantenimiento', 
        ]);
        $response->assertRedirect(route('carrera.adscripcion'));
    }

    public function test_guardar_carrera(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('carrera.adscripcion'))
                         ->post(route('guardar.carrera'),['nombre' => 'Ingenieria ambiental']);
        $this->assertAuthenticated();
        $this->assertDatabaseHas('carreras', [
            'nombre' => 'Ingenieria ambiental', 
        ]);
        $response->assertRedirect(route('carrera.adscripcion'));
    }

    public function test_eliminar_adscripcion(){
        $this->adscripcion = Adscripcion::create($this->adscripcion);
        $this->assertDatabaseHas('adscripcions', [
            'nombre_adscripcion' => $this->adscripcion['nombre_adscripcion'], 
        ]);

        $response = $this->actingAs($this->secretario)
                         ->from(route('carrera.adscripcion'))
                         ->delete(route('eliminar.adscripcion',$this->adscripcion['id']));
        $this->assertAuthenticated();
        $this->assertDeleted('adscripcions', ['id' => $this->adscripcion['id']]);
        $response->assertRedirect(route('carrera.adscripcion'));
    }

    public function test_eliminar_carrera(){
        $this->carrera = Carrera::create($this->carrera);
        $this->assertDatabaseHas('carreras', [
            'nombre' => $this->carrera['nombre'], 
        ]);

        $response = $this->actingAs($this->secretario)
                         ->from(route('carrera.adscripcion'))
                         ->delete(route('eliminar.carrera',$this->carrera['id']));
        $this->assertAuthenticated();
        $this->assertDeleted('carreras', ['id' => $this->carrera['id']]);
        $response->assertRedirect(route('carrera.adscripcion'));
    }
}
