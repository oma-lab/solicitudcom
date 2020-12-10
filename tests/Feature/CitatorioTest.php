<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Calendario;
use App\Citatorio;
use App\Acta;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\DatosPrueba;

class CitatorioTest extends TestCase{
    use RefreshDatabase;
    use DatosPrueba; 

    
    public function setUp() : void{
        parent::setUp();
        $this->seed('DatabaseTestSeeder');
        $this->secretario = User::create($this->secretario);
        $this->jefe = User::create($this->jefe);
        $this->citatorio = Citatorio::create($this->citatorio);
        $this->orden = Acta::create($this->orden);
        $this->orden_dia = Acta::create($this->orden_dia);

    }
    

    public function test_citatorios(){
        $response = $this->actingAs($this->secretario)
                         ->get(route('citatorio.index'));
        $response->assertViewHas('citatorios');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }


    public function test_registrar_citatorio(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('citatorio.index'))
                         ->post(route('citatorio.store'),['calendario_id' => $this->citatorio['calendario_id']]);
        $this->assertDatabaseHas('citatorios', [
            'oficio' => $this->citatorio['oficio'], 
        ]);
        $response->assertRedirect(route('citatorio.index'));
    }



    public function test_subir_citatorio_firmado(){
        Storage::fake('public');
        $archivo = UploadedFile::fake()->create('citatorio.pdf', 1000);
        $response = $this->actingAs($this->secretario)
                         ->from(route('citatorio.index'))
                         ->patch(route('citatorio.update',1),['doc_firmado' => $archivo]);

        Storage::disk('public')->assertExists('subidas/'.$archivo->hashName());
        $response->assertRedirect(route('citatorio.index'));
    }



    public function test_eliminar_citatorio(){
        $this->assertDatabaseHas('citatorios',[
            'id' => 1, 'oficio' => $this->citatorio['oficio'], 
        ]);
        $response = $this->actingAs($this->secretario)
                         ->from(route('citatorio.index'))
                         ->delete(route('citatorio.destroy',1));

        $this->assertDatabaseMissing('citatorios',[
            'id' => 1, 'oficio' => $this->citatorio['oficio'], 
        ]);

        $response->assertRedirect(route('citatorio.index'));
    }



    
    public function test_enviar_citatorio(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('citatorio.index'))
                         ->get(route('enviar.citatorio',1));

        $this->assertDatabaseMissing('citatorios',[
            'id' => 1, 'enviado' => true, 
        ]);
        Citatorio::where('id',$this->citatorio['id'])->update(['archivo' => 'citatorio.pdf']);
        $response = $this->actingAs($this->secretario)
                         ->from(route('citatorio.index'))
                         ->get(route('enviar.citatorio',1));

        $this->assertDatabaseHas('citatorios',[
            'id' => 1, 'enviado' => true, 
        ]);
        $response->assertRedirect(route('citatorio.index'));
    }



    public function generar_citatorio_pdf(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('citatorio.index'))
                         ->get(route('citatorio_pdf',1));
        $response->assertSuccessful();
    }


    public function test_subir_orden(){
        Storage::fake('public');
        $archivo = UploadedFile::fake()->create('orden.pdf', 3000);
        $response = $this->actingAs($this->secretario)
                         ->from(route('citatorio.index'))
                         ->patch(route('update.orden',$this->orden['id']),['doc_firmado' => $archivo]);

        Storage::disk('public')->assertExists('subidas/'.$archivo->hashName());
        $response->assertRedirect(route('citatorio.index'));
    }

    public function test_enviar_orden(){
        $response = $this->actingAs($this->secretario)
                         ->from(route('citatorio.index'))
                         ->get(route('enviar.orden',$this->orden_dia['calendario_id']));

        $this->assertDatabaseHas('notificacions',[
            'tipo' => 'ordendia', 
        ]);
        $response->assertRedirect(route('citatorio.index'));
    }

    public function test_mostrar_citatorio(){
        $response = $this->actingAs($this->jefe)
                         ->get(route('mostrar.citatorio',$this->citatorio['id']));
        $response->assertViewHas('citatorio');
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

    public function test_mostrar_orden(){
        $response = $this->actingAs($this->jefe)
                         ->get(route('mostrar.orden',$this->citatorio['id']));
        $this->assertAuthenticated();
        $response->assertSuccessful();
    }

}
