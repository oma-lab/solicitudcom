<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserCarrera;
use App\Carrera;
use App\Solicitud;
use App\Dictamen;
use App\Notificacion;
use App\Adscripcion;
use App\Observaciones;
use App\Recomendacion;

class CoordinadorController extends Controller{

    public function __construct(){
        $this->middleware('auth');//middleware que valida que el usuario este autenticado
        $this->middleware('coordinador');//middleware que valida que el usuario sea coordinador
    }

    //acceso a la funcion solo para el coordinador, validado en el constructor
    /* funcion para mostrar al coordinador las solicitudes registradas, el coordinador
    puede filtrar las solicitudes por numero de control/RFC, nombre, carrera, solicitudes
    que ha visto y solicitudes que ya fueron vistas en reunion  */ 
    public function solicitudes(Request $request,$filtro){
        //datos para el filtrado
        $numc = $request->get('numc');
        $nombre = $request->get('nombre');
        $id = $request->get('carrera_id');
        $ide = usuario()->identificador;
        $visto = ($request->get('visto')) ? true : false;
        //toma los id de carreras de las cuales tiene permiso
        $permiso = UserCarrera::where('identificador','=',$ide)->pluck('carrera_id');
        $respuesta = ($filtro == 'pendientes') ? '=' : '!=';
        $carreras = Carrera::whereIn('id',$permiso)->get();

        $solicitudes = Solicitud::join('users','solicituds.identificador','=','users.identificador')
                                ->join('user_carreras','users.carrera_id','=','user_carreras.carrera_id')
                                ->leftJoin('recomendacions','solicituds.id','=','recomendacions.id_solicitud')
                                ->leftJoin('observaciones',function($join) use ($ide){
                                    $join->on('observaciones.solicitud_id', '=', 'solicituds.id')
                                    ->where('observaciones.identificador', '=', $ide);
                                })
                                ->select('solicituds.*','observaciones.voto','observaciones.descripcion','observaciones.visto')
                                ->where([['solicituds.enviado','=',true],['recomendacions.respuesta',$respuesta,null],['user_carreras.identificador','=',$ide]])
                                ->where('users.nombre','LIKE',"%$nombre%")
                                ->where('users.carrera_id','LIKE',"%$id%")
                                ->where('users.identificador','LIKE',"%$numc%")
                                ->when($filtro == 'pendientes', function($query) use ($visto){
                                    $query->where('solicituds.enviadocoor',$visto);
                                  })
                                ->paginate(5);

        if($filtro == 'finalizadas'){
            return view('coordinador.solicitudesFinalizadas',compact('solicitudes','carreras')); 
        }else{
        if(!$request->get('visto')){
            Notificacion::where([['identificador','=',usuario()->identificador],['tipo','=','solicitud']])->update(['num' => $solicitudes->total()]);    
        }
        return view('coordinador.solicitudesRecibidas',compact('solicitudes','carreras'));
        }
    }



    //acceso a la funcion solo para el coordinador, validado en el constructor
    //retorna la vista mostrando las fechas de las reuniones
    public function calendario(){
        return view('layouts.calendario')->with('encabezado','layouts.encabezadocoor');
    }




    //acceso a la funcion solo para el coordinador, validado en el constructor
    //funcion para mostrar los dictamenes recibidos
    public function dictamenes(Request $request){
        $nombre= $request->get('nombre');//filtrado por nombre
        $carreraid= $request->get('carrera_id');//filtrado por carrera
        $numc = $request->get('numc');//filtrado número de control               
        if(!$carreraid){
            //en caso de no filtrar por carrera se muestran de todas
            $carreras_id = UserCarrera::where('identificador','=',usuario()->identificador)->pluck('carrera_id');
        }else{
            //si manda un filtro de carrera
            $carreras_id =[$carreraid];
        }
        //variable que guarda las carreras por las cuales puede filtrar dependiendo de los permisos que tenga el usuario
        $carreras = Carrera::whereIn('id',$carreras_id)->get();
        //se hace el filtrado de los dictamenes recibidos
        $dictamenes = Dictamen::where('dictamens.enviado','=',true)
                              ->whereHas('recomendacion.solicitud.user', function($query) use ($nombre,$carreras_id,$numc){
                                  $query->nombre($nombre)
                                        ->identificador($numc)
                                        ->carreras($carreras_id);})
                              ->join('users_dictamenes',function($join){
                                  $join->on('users_dictamenes.dictamen_id', '=', 'dictamens.id')
                                  ->where('users_dictamenes.identificador', '=', usuario()->identificador);
                                })
                              ->select('dictamens.*','users_dictamenes.recibido')
                              ->paginate(5);
        //Notificacion::where([['identificador','=',usuario()->identificador],['tipo','=','newdictamen']])->update(['num' => 0]);
        return view('coordinador.dictamenes',compact('dictamenes','carreras'));
    }



    //acceso a la funcion solo para el coordinador, validado en el constructor
    //funcion para que el coordinador actualice sus datos
    public function editarUsuario(){
        $usuario = Auth::user();
        $ads_carreras = Adscripcion::where('id',$usuario->adscripcion_id)->get();
        return view('auth.edit_usuario',compact('usuario','ads_carreras'))->with('encabezado','layouts.encabezadocoor');
    }





    //acceso a la funcion solo para el coordinador, validado en el constructor
    /*funcion para cancelar una solicitud, el coordinador puede realizar
    observaciones para mandarlas al solicitante y pueda modificar*/
    public function cancelarSolicitud(Request $request){
        //observaciones que seran enviadas al usuario
        Observaciones::create([
            'identificador' => usuario()->identificador,
            'solicitud_id' => $request->id_sol,
            'descripcion' => $request->obs_est,
        ]);
        //la solicitud se marca como no enviada
        Solicitud::where('id',$request->id_sol)->update(['enviado' => false]);
        //se notifica al solicitante
        notificarSolicitante([
            'id_sol' => $request->id_sol,
            'tipo' => 'cancelado',
            'mensaje' => 'Solicitud rechazada',
            'descripcion' => 'Tu solicitud no pudo continuar, revisa las observaciones hechas por las cuales no procede, si necesitan cambios hazlos y envia nuevamente',
            'obs_coor' => $request->obs_est
        ]);
        return back()->with('Mensaje','Solicitud cancelada');
    }




    //acceso a la funcion solo para el coordinador, validado en el constructor
    /*funcion para que el coordinador envie las solicitudes que ya ha revisado, el coordinador
    da observaciones a la solicitud*/ 
    public function enviarSolicitud(Request $request,$id){
    //se guarda la observacion dada a la solicitud y se marca como visto
        Observaciones::create([
            'identificador' => Auth::user()->identificador,
            'solicitud_id' => $id,
            'descripcion' => $request['descripcion'],
            'visto' => true
        ]);
        //la solicitud se marca como enviado
        Solicitud::where('id',$id)->update(['enviadocoor' => true]);
        $sol= Solicitud::find($id);
        //se notifica a los integrantes de una nueva solicitud
        notificar([
            'carrera_id' => $sol->user->carrera_id,
            'roles' => [5,8],
            'tipo' => 'solicitud',
            'mensaje' => 'Nuevas Solicitudes',
            'descripcion' => 'Nuevas solicitudes registradas'
        ]);
        return back()->with('Mensaje','Solicitud enviada');

    }
}
