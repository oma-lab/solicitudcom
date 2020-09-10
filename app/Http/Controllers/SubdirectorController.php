<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Adscripcion;
use App\Recomendacion;
use App\Solicitud;
use App\Carrera;
use App\Notificacion;
use App\Dictamen;
use App\Calendario;
use App\Temporal;
use App\User;

use Carbon\Carbon;
use App\Formato;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;

class SubdirectorController extends Controller{

    public function __construct(){
        $this->middleware('auth');//middleware para validar que el usuario este autenticado
        //middleware que valida que el subdirector solo tenga acceso a las funciones indicadas
        $this->middleware('subdirector', ['only' => ['calendario','editarUsuario','dictamen']]);
        //middleware que valida que el subdirector y administrador tengan acceso a las funciones indicadas
        $this->middleware('adminSubdirector', ['only' => ['recomendaciones','recomendacionesFinalizadas','editarRecomendacion','guardarRecomendacion','eliminarRecomendacion','generarRecomendacion','enviarRecomendacion']]);
    }


    //acceso a la funcion solo para el subdirector, validado en el constructor
    //funcion para mostrar las reuniones en un calendario
    public function calendario(){
        return view('layouts.calendario')->with('encabezado','layouts.encabezadosub');
    }

    //acceso a la funcion solo para el subdirector, validado en el constructor
    //funcion que retorna la vista para actualizar datos del usuario
    public function editarUsuario(){
        $usuario = Auth::user();
        if($usuario->esIntegrante()){
          $ads_carreras = Adscripcion::where('id',$usuario->adscripcion_id)->get();
        }else{
          $ads_carreras = Adscripcion::where('tipo','carrera')->get();
        }
        return view('auth.edit_usuario',compact('usuario','ads_carreras'))->with('encabezado','layouts.encabezadosub');
    }


    //acceso a la funcion para el subdirector y administrador, validado en el constructor
    //funcion que muestra al subdirector las recomednaciones pendientes de elaborar
    public function recomendaciones(Request $request){
        $nombre = $request->get('nombre');
        $numc = $request->get('numc');
        $roleid = $request->get('role_id');
        $id_carrera = $request->get('carrera_id');
        //recomendaciones pendientes de completar
        $recomendaciones = Recomendacion::where([['recomendacions.enviado',false],['recomendacions.respuesta','!=',null]])
                                        ->whereHas('solicitud.user', function($query) use ($nombre,$numc,$roleid,$id_carrera) {
                                              $query->nombre($nombre)
                                              ->identificador($numc)
                                              ->role($roleid)
                                              ->carrera($id_carrera);})
                                        ->paginate(10);
        $carreras = Carrera::all();//carreras que serviran para el filtrado
        //notificacion que indica que quedan recomendaciones pendientes
        Notificacion::where('tipo','recomendacion')->update(['num' => count($recomendaciones)]);
        return view('subdirector.recomendacionesPendientes',compact('recomendaciones','carreras'));
    }



    //acceso a la funcion para el subdirector y administrador, validado en el constructor
    //funcion para mostrar las recomendaciones que ya fueron elaboradas y enviadas
    public function recomendacionesFinalizadas(Request $request){
        $user = Auth::user();
        $nombre = $request->get('nombre');
        $numc = $request->get('numc');
        $roleid = $request->get('role_id');
        $id_carrera = $request->get('carrera_id');
        $carreras = Carrera::all();//carreras que serviran para el filtrado
            $recom = Recomendacion::where('recomendacions.enviado',true)
                                  ->whereHas('solicitud.user', function($query) use ($nombre,$numc,$roleid,$id_carrera) {
                                    $query->nombre($nombre)
                                    ->identificador($numc)
                                    ->role($roleid)
                                    ->carrera($id_carrera);})
                                  ->paginate(10);
            return view('subdirector.recomendacionesFinalizadas',compact('recom','carreras'));
    }



    //acceso a la funcion solo para el subdirector, validado en el constructor
    //funcion que muestra al usuario los dictamenes recibidos
    public function dictamen(Request $request){
        $nombre = $request->get('nombre');
        $numc = $request->get('numc');
        $roleid = $request->get('role_id');
        $id_carrera = $request->get('carrera_id');
        $dictamenes =Dictamen::whereIn('respuesta',['SI','NO'])
                             ->where('enviado','=',true)
                             ->whereHas('recomendacion.solicitud.user', function($query) use ($nombre,$numc,$roleid,$id_carrera) {
                                $query->nombre($nombre)
                                ->identificador($numc)
                                ->role($roleid)
                                ->carrera($id_carrera);})
                             ->paginate(10);
        $carreras = Carrera::all();
        return view('subdirector.dictamenes',compact('dictamenes','carreras'));
    }




    //acceso a la funcion para el subdirector y administrador, validado en el constructor
    //funcion que retorna la vista para poder realizar cambios a una recomendacion
    public function editarRecomendacion($id){
        $user = Auth::user();
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME, "es_MX.UTF-8");
        $recomendacion = Recomendacion::findOrFail($id);
        //se toma la fecha actual, para mostrar cuando se realizo la recomendacion
        $fecha = date('d')."/".strftime("%B")."/".date('Y');//14/enero/2020
        $fechasreuniones = Calendario::whereDate('start','<=',hoy())->take(5)->orderBy('start','desc')->get();
        return view('subdirector.editarRecomendacion',compact('recomendacion','fecha','fechasreuniones'));
    }

    


    //acceso a la funcion para el subdirector y administrador, validado en el constructor
    //funcion que guarda los cambios hechos a la recomendacion
    public function guardarRecomendacion(Request $request,$id){
        $datosRec=request()->except(['_token','_method','calendario_id','doc_firmado']);
        //si el usuario sube la recomendacion firmada entonces se guarda
        if($request->hasFile('doc_firmado')){
            $datosRec['archivo']=$request->file('doc_firmado')->store('subidas','public');
        }else{
            $request->validate(['num_oficio' => 'nullable|unique:recomendacions,num_oficio,'.$id,
                                'num_recomendacion' => 'nullable|unique:recomendacions,num_recomendacion,'.$id]);
            $rec = Recomendacion::find($id);
            Solicitud::where('id',$rec->id_solicitud)->update(['calendario_id' => $request['calendario_id']]);
        }
        Recomendacion::where('id',$id)->update($datosRec);
        return redirect()->route('recomendaciones')->with('Mensaje','Cambios realizados correctamente');
    }



    //acceso a la funcion para el subdirector y administrador, validado en el constructor
    //funcion para eliminar una recomendacion
    public function eliminarRecomendacion($id){
        $rec = Recomendacion::find($id);
        Recomendacion::destroy($id);
        Solicitud::destroy($rec->id_solicitud);
        return back()->with('Mensaje','Recomendación eliminado con exito');
    }





    //acceso a la funcion para el subdirector y administrador, validado en el constructor
    //funcion para enviar las recomendaciones elaboradas
    public function enviarRecomendacion($id){
        Recomendacion::where('id',$id)->update(['enviado' => true]);
        //al momento de enviar la recomendacion, se crea el dictamen haciendo referencia a la recomendacion
        Dictamen::create(['recomendacion_id' => $id]);
        //se crea notificacion de dictamenes pendientes para administrador y director 
        notificar([
            'roles' => [1,2],
            'tipo' => 'dictamen_pendiente',
            'mensaje' => 'Dictamenes Pendientes',
            'descripcion' => 'Tienes dictamenes pendientes que elaborar'
        ]); 

        return back()->with('Mensaje','Recomendación enviada');
    }



    //acceso a la funcion para el subdirector y administrador, validado en el constructor
    //funcion para generar la recomendacion en formato pdf
    public function generarRecomendacion($id){
        $director = User::where('role_id','=',2)->first(); //si no hay director registrado no se genera la recomendacion
        if(!$director){ return back()->with('Error','La recomendación no se puede generar debido a que no se tiene un director registrado.');}
        $presidente = User::where('role_id','=',8)->first(); //si no hay subdirector registrado no se genera la recomendacion
        if(!$presidente){ return back()->with('Error','La recomendación no se puede generar debido a que no se tiene un subdirector registrado.');}
        $secretario = User::where('role_id','=',1)->first();//si no hay secretario registrado no se genera la recomendacion
        if(!$secretario){ return back()->with('Error','La recomendación no se puede generar debido a que no se tiene un secretario técnico registrado.');}  
        $datoss = Recomendacion::findOrFail($id);
        //fecha de reunion
        setlocale(LC_TIME, "es_MX.UTF-8");
        $fechare= fechaLetraAnio($datoss->solicitud->calendario->start);
        //formato del documento
        $datospdf = Formato::findOrFail(1);
        $pdfs = PDF::loadView('subdirector.recomendacionpdf',compact('datoss','director','presidente','fechare','datospdf'))->setPaper('carta','portrait');
        return $pdfs->stream('recomendacion.pdf');
    }



}
