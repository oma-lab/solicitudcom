<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dictamen;
use App\Recomendacion;
use App\Solicitud;
use App\Notificacion;
use App\Carrera;
use App\CarreraDepartamento;
use App\Adscripcion;
use App\User;
use App\Formato;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DirectorController extends Controller{

    public function __construct(){
        $this->middleware('auth');//middleware para validar que el usuario este autenticado
        //middleware que valida que el director solo tenga acceso a las funciones indicadas
        $this->middleware('director', ['only' => ['recomendaciones','calendario','editarUsuario']]);
        //middleware que valida que el director y administrador tengan acceso a las funciones indicadas
        $this->middleware('adminDirector', ['only' => ['dictamenes','editarDictamen','guardarDictamen','verDictamenpdf','enviarDictamen','entregarDictamen']]);
    }
    



    //acceso a la funcion solo para el director, validado en el constructor
    //funcion que retorna la vista donde se muestran las fechas de las reuniones
    public function calendario(){
        return view('layouts.calendario')->with('encabezado','layouts.encabezadoDirector');
    }


    //acceso a la funcion solo para el director, validado en el constructor
    //funcion para que el director actualice sus datos
    public function editarUsuario(){
        $usuario = Auth::user();
        if($usuario->esIntegrante()){
            $ads_carreras = Adscripcion::where('id',$usuario->adscripcion_id)->get();
          }else{
            $ads_carreras = Adscripcion::where('tipo','carrera')->get();
          }
        return view('auth.edit_usuario',compact('usuario','ads_carreras'))->with('encabezado','layouts.encabezadoDirector');
    }



    //acceso a la funcion para el director y administrador, validado en el constructor
    /*funcion que retoran la vista para que el director o administrador puedan ver los
    dictamenes pendientes de elaborar*/
    public function dictamenes(Request $request,$filtro){
        $nombre = $request->get('nombre');
        $numc = $request->get('numc');
        $roleid = $request->get('role_id');
        $id_carrera = $request->get('carrera_id');
        $enviado= false;
        $entregado = false;
        if($filtro == 'noentregado'){
            $enviado= true;           
        }
        if($filtro == 'terminados'){
            $enviado= true;
            $entregado = true;            
        }

        $dictamenes = Dictamen::where('enviado',$enviado)
                              ->where('entregadodepto',$entregado)
                              ->whereHas('recomendacion.solicitud.user', function($query) use ($nombre,$numc,$roleid,$id_carrera) {
                                $query->nombre($nombre)
                                ->identificador($numc)
                                ->role($roleid)
                                ->carrera($id_carrera);})
                               ->paginate(10);
                              
        $carreras = Carrera::all();

        if($filtro == 'pendientes'){
            Notificacion::where('tipo','dictamen_pendiente')->update(['num' => count($dictamenes)]);
            return view('director.dictamenesPendientes',compact('dictamenes','carreras'));
        }elseif($filtro == 'noentregado'){
            Notificacion::where('tipo','dictamen_entregar')->update(['num' => count($dictamenes)]);
            return view('director.dictamenesNoEntregados',compact('dictamenes','carreras'));
        }else{
            return view('director.dictamenesTerminados',compact('dictamenes','carreras'));
        }
    }


    //acceso a la funcion para el director y administrador, validado en el constructor
    //funcion que retorna la vista para modificar/completar los datos del dictamen
    public function editarDictamen($id){
        //Se busca el dictamen que va ser actualizado
        $dictamen = Dictamen::find($id);
        return view('director.editDictamen',compact('dictamen'));
    }



    //acceso a la funcion para el director y administrador, validado en el constructor
    //funcion para guardar el dictamen
    public function guardarDictamen(Request $request, $id){
        $datosDic=request()->except(['_token','_method','doc_firmado']);
        if($request->hasFile('doc_firmado')){
            //si se sube el archivo firmado se guarda
            $datosDic['dictamen_firmado']=$request->file('doc_firmado')->store('subidas','public');
        }else{
            //valida que el numero de oficio y el numero de dictamen no se repita
            $request->validate(['num_oficio' => 'nullable|unique:dictamens,num_oficio,'.$id,
                           'num_dictamen' => 'nullable|unique:dictamens,num_dictamen,'.$id]);
        }
        //se actualiza dictamen
        Dictamen::where('id','=',$id)->update($datosDic);
        return redirect()->route('director.dictamenes','pendientes')->with('Mensaje','Cambios realizados correctamente');
    }

    //acceso a la funcion para el director y administrador, validado en el constructor
    //funcion para eliminar un dictamen
    public function eliminarDictamen($id){
        $dic = Dictamen::find($id);
        Dictamen::destroy($id);
        Solicitud::destroy($dic->solicitud()->id);
        return back()->with('Mensaje','Dictamen eliminado con exito');
    }



    //acceso a la funcion para el director y administrador, validado en el constructor
    public function enviarDictamen($id){
        //acceso solo para el administrador y director, validado en el constructor
        $dic = Dictamen::findOrFail($id);
        //el dictamen se marca como enviado
        Dictamen::where('id','=',$id)->update(['enviado' => true]);
        //si el dictamen pertenece a un estudiante se notifica a jefes,coordinadores y subdirector,en caso contrario se notifica a jefes y subdirector
        $roles = $dic->usuario()->esEstudiante() ? [5,6,8] : [5,8];
        notificar([
            'carrera_id' => $dic->usuario()->carrera_id,
            'adscripcion_id' => $dic->usuario()->adscripcion_id,
            'roles' => $roles,
            'tipo' => 'dictamen_nuevo',
            'mensaje' => 'Nuevos Dictamenes',
            'descripcion' => 'Nuevos dictamenes recibidos'
        ]);
        //se notifica al director que tiene dictamenes pendientes por entregar
        notificar([
            'roles' => [1,2],
            'tipo' => 'dictamen_entregar',
            'mensaje' => 'Dictamenes por entregar',
            'descripcion' => 'Dictamenes pendientes por entregar a los departamentos de carrera'
        ]);
        return back()->with('Mensaje','Dictamen enviado');
    }



    //acceso a la funcion para el director y administrador, validado en el constructor
    //funcion que marca el dictamen como entregado en el departamento de carrera
    public function entregarDictamen(Request $request){
        //si se marca por lo menos un dictamen que ha sido entregado se realiza la operacion dentro del if 
        if($request->dictams){
        foreach($request->dictams as $dict){
            //Se actualiza el dictamen indicando que ya han sido entregados en el departamento de carrea
            Dictamen::where('id','=',$dict)->update(['entregadodepto' => true]);
            $dic = Dictamen::findOrFail($dict);
            //se crean las notificaciones para indicar al usuario que pueden recoger su dictamen
            notificarSolicitante([
               'id_sol' => $dic->solicitud()->id,
               'tipo' => 'dictamen_enviado',
               'mensaje' => 'Dictamen finalizado',
               'descripcion' => 'Tu dictamen ya tiene respuesta, puedes recogerlo con el jefe de departamento de tu carrera',
               'obs_coor' => ''
            ]);
        }
        }
        return back()->with('Mensaje','Dictamenes marcados como entregados');
    }







    //acceso a la funcion para el director y administrador, validado en el constructor
    //funcion que genera el dictamen en formato pdf
    public function verDictamenpdf($id){
        $director = User::where('role_id','=',2)->first(); //si no hay director registrado no se genera el dictamen
        if(!$director){ return back()->with('Error','El dictamen no se puede generar debido a que no se tiene un director registrado.');}
        $presidente = User::where('role_id','=',8)->first(); //si no hay subdirector registrado no se genera el dictamen
        if(!$presidente){ return back()->with('Error','El dictamen no se puede generar debido a que no se tiene un subdirector registrado.');}
        $secretario = User::where('role_id','=',1)->first();//si no hay secretario registrado no se genera el dictamen
        if(!$secretario){ return back()->with('Error','El dictamen no se puede generar debido a que no se tiene un secretario registrado.');}
        //se toman los datos del dictamen
        $dictamen = Dictamen::find($id);
        //formato del documento
        $datospdf = Formato::findOrFail(1);  
        //Se genera el dictamen   
        $pdfd = PDF::loadView('director.dictamenpdf',compact('dictamen','datospdf'))->setPaper('carta','portrait');
        return $pdfd->stream('dictamen.pdf');
    }
}
