<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Solicitud;
use App\Calendario;
use App\Notificacion;
use Tests\DatosPrueba;


class SolicitudSolicitanteTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba;

    private $solicitante;

    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');//registra datos de prueba, carreras,adscripciones,roles y asuntos
        //para que el solicitante pueda realizar los procesos sobre una solicitud debe estar registrado
        $this->solicitante = User::create($this->usuario_correcto);
        //comprueba que el usuario exista en la base de datos
        $this->assertDatabaseHas('users', [
            'identificador' => $this->usuario_correcto['identificador']
        ]);
        //Se elimina la reunion con fecha de hoy, esto debido a que el usuario no puede realizar una solicitud el mismo dia de reunión
        //1=> reunion pasada, 2=>reunion de hoy, 3=>reunion proxima
        Calendario::where('id',2)->delete();
    }
    
     
    public function test_ver_vista_solicitud(){
        //se autentica el usuario y corrobora que se rediriga a la vista para crear una solicitud
        $response = $this->actingAs($this->solicitante)
                         ->get(route('crear.solicitud'));
        //se verifica que el usuario se haya autenticado y lo rediriga a la vista correcta
        $this->assertAuthenticated();
        $response->assertSuccessful();
        //se comprueba que a la vista se le hayan pasado los asuntos que se muestran al usuario
        $response->assertViewHas('asuntos');
    }

    public function test_registrar_solicitud(){
        //el usuario autenticado registra la solicitud
        $response = $this->actingAs($this->solicitante)
                         ->post(route('registrar.solicitud'),
                             ['semestre' => '12',
                              'fecha' => '2020-06-17',
                              'asunto' => 'prueba asunto',
                              'motivos_academicos' => '',
                              'motivos_personales' => '',
                              'otros_motivos' => '']);
        //se corrobora que la solicitud se ha registrado
        $this->assertDatabaseHas('solicituds', [
            'asunto' => 'prueba asunto',            
        ]);
        //la vista a la cual se redirige debe ser home
        $response->assertRedirect('/home');        
    }
    

    public function test_editar_solicitud(){
        //la soicitud debio ser registrada anteriormente        
        $solicitud = Solicitud::create($this->solicitud);
        //comprueba que la solicitud exista en la base de datos
        $this->assertDatabaseHas('solicituds', [
            'id' => $solicitud['id'],            
        ]);
        //el usuario debe estar autenticado y lo debe dirigir a la vista para editar la solicitud
        $response = $this->actingAs($this->solicitante)
                         ->get(route('editar.solicitud',$solicitud['id']));
        //compruba que toda hay salido correcto
        $response->assertViewHas('solicitud');
        $response->assertSuccessful();
    }


    public function test_guardar_cambios_solicitud(){       
        //solicitud a la cual se realizaran los cambios
        $solicitud = Solicitud::create($this->solicitud);
        $this->assertDatabaseHas('solicituds', [
            'id' => $solicitud['id'],            
        ]);
        //para la prueba se cambia el asunto
        $response = $this->actingAs($this->solicitante)
                         ->patch(route('update.solicitud',$solicitud['id']),
                           ['semestre' => '12',
                            'fecha' => '2020-06-17',
                            'asunto' => 'prueba asunto cambio',
                            'motivos_academicos' => '',
                            'motivos_personales' => '',
                            'otros_motivos' => '']);
        //comprueba que el cambio se haya echo
        $this->assertDatabaseMissing('solicituds', [
            'asunto' => $solicitud['asunto'], 
        ]);
        //comprueba que se rediriga a la ruta correcta
        $response->assertRedirect(route('solicitante.home'));        
    }


    public function test_eliminar_solicitud(){
        //solicitud que sera eliminada
        $solicitud = Solicitud::create($this->solicitud);
        $this->assertDatabaseHas('solicituds', [
            'id' => $solicitud['id'],            
        ]);
        $response = $this->get('/solicitante');
        $response = $this->actingAs($this->solicitante)
                         ->delete(route('eliminar.solicitud',$solicitud['id']));
        //comprueba que la solicitud ha sido eliminada
        $this->assertDeleted('solicituds', ['id' => $solicitud['id']]);
        //comprueba que se rediriga a la ruta correcta despues de eliminar
        $response->assertRedirect(route('solicitante.home'));

    }

    public function test_enviar_solicitud(){       
        ///solicitud que sera enviada
        $soli = Solicitud::create($this->solicitud);
        $this->assertDatabaseHas('solicituds', [
            'id' => $soli['id'], 'enviado' => false,
        ]);
        $response = $this->actingAs($this->solicitante)
                         ->get(route('enviar.solicitud',$soli['id']));
        $this->assertDatabaseHas('solicituds', [
            'id' => $soli['id'], 'enviado' => true,
        ]);
    }

    public function test_ver_solicitudpdf(){
        $subdirector = User::create($this->subdirector);
        $jefedivision = User::create($this->jefe_division);
        $solicitud = Solicitud::create($this->solicitud);
        $response = $this->actingAs($this->solicitante)
                         ->from(route('solicitante.home'))
                         ->get(route('ver.solicitud',$solicitud['id']));
        $response->assertSuccessful();
    }

    public function test_ver_notificacion(){
        $solicitud = Solicitud::create($this->solicitud);
        $notificacion = ['identificador' => $this->solicitante['identificador'], 
                         'tipo' => 'cancelado',
                         'solicitud_id' => $solicitud['id'], 
                         'mensaje' => 'Solicitud cancelada',
                         'descripcion' => 'Tu solicitud no pudo continuar',
                         'observacion' => 'Falta especificar los motivos de tu solicitud',
                         'num' => 1];
        $notificacion = Notificacion::create($notificacion);
        $this->assertDatabaseHas('notificacions', [
            'identificador' => $this->solicitante['identificador'],
            'id' => $solicitud['id'],
        ]);
        $response = $this->actingAs($this->solicitante)
                         ->get(route('ver.notificacion',$notificacion['id']));
        $response->assertSeeText('OBSERVACIONES');
    }
}
