<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Calendario;
use App\ListaAsistencia;
use App\ListaUsuario;
use App\Invitado;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\DatosPrueba;

class ListaAsistenciaTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    
    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->secretario = User::create($this->secretario);
        $this->lista_asistencia = ListaAsistencia::create($this->lista_asistencia);
        $this->jefe = User::create($this->jefe);
        $this->jefequimica = User::create($this->jefequimica);
        $this->subdirector = User::create($this->subdirector);
        $this->asistencia_subdirector = ListaUsuario::create($this->asistencia_subdirector);
        $this->asistencia_jefe = ListaUsuario::create($this->asistencia_jefe);
        $this->asistencia_jefequimica = ListaUsuario::create($this->asistencia_jefequimica);
        $this->asistencia_secretario = ListaUsuario::create($this->asistencia_secretario);
    }
    

    public function test_ver_listas(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('listaasistencia.index'));
        $response->assertViewHas('listas');
        $response->assertViewHas('integrantes');
        $response->assertViewHas('reuniones');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }


    public function test_registrar_lista(){
        //id= 2 =>reunion con fecha de hoy      
        $response = $this->actingAs($this->secretario)
                         ->from(route('listaasistencia.index'))
                         ->post(route('listaasistencia.store'),[
                             'calendario_id' => 2,
                             'identificador' => [$this->secretario['identificador'],$this->jefe['identificador'],$this->jefequimica['identificador'],$this->subdirector['identificador']],
                             'asistencia' => ['ASISTENCIA','FALTA','ASISTENCIA','ASISTENCIA'],
                             ]);

        $this->assertDatabaseHas('lista_asistencias', 
            ['calendario_id' => 2]);
        $response->assertRedirect(route('listaasistencia.index'));
    }

    

    public function test_editar_lista(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('listaasistencia.edit',$this->lista_asistencia['id']));
        $response->assertViewHas('lista');
        $response->assertViewHas('listausuario');
        $response->assertViewHas('invitados');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }




    public function test_actualizar_lista(){        
        $response = $this->actingAs($this->secretario)
                         ->from(route('listaasistencia.edit',$this->lista_asistencia['id']))
                         ->patch(route('listaasistencia.update',$this->lista_asistencia['id']),[
                             'identificador' => [$this->secretario['identificador']],
                             'asistencia' => ['ASISTENCIA'],
                         ]);
        $response->assertRedirect(route('listaasistencia.index'));
    }


    public function test_eliminar_lista(){
        //id= 1 =>reunion pasada con fecha de hace 5 dias
        //id= 2 =>reunion con fecha de hoy
        $this->assertDatabaseHas('lista_asistencias', [
            'calendario_id' => 1, 
        ]);
        $response = $this->actingAs($this->secretario)
                         ->from(route('listaasistencia.index'))
                         ->delete(route('listaasistencia.destroy',$this->lista_asistencia['id']));

        $this->assertDatabaseMissing('lista_asistencias', [
            'calendario_id' => 2, 
        ]);

    }

    
    public function test_generar_lista_pdf(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('listaasistencia.index'))
                         ->get(route('verLista',$this->lista_asistencia['id']));
        $response->assertSuccessful();
    }
    
}
