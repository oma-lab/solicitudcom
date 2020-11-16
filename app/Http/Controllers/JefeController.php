<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Adscripcion;
use App\UserCarrera;
use App\Carrera;
use App\UserAdscripcion;
use App\Solicitud;
use App\Observaciones;
use App\Notificacion;
use App\Citatorio;
use App\CarreraDepartamento;
use App\Dictamen;

class JefeController extends Controller{

    public function __construct(){
        $this->middleware('auth');//middleware para validar que el usuario este autenticado
        //middleware que valida que el jefe tenga acceso a las funciones indicadas
        $this->middleware('jefe', ['only' => ['dictamenes','calendario','editarUsuario','entregarDictamen']]);
        //middleware que valida que el jefe y subdirector tengan acceso a las funciones indicadas
        $this->middleware('subJefe', ['only' => ['solicitudesRecibidas']]);
    }



//acceso a la funcion para jefes y subdirector, validado en el constructor    
/*funcion que muestra al usaurio las solicitudes recibidas, las solicitudes pueden filtrase por
nombre,apellidos de solicitante, numero de control, RFC, carrera, rol(estudiante,docente), solicitudes 
recibidas y solicitudes vistas en reunion*/
public function solicitudesRecibidas(Request $request,$filtro){
    //datos para el filtrado
    $nombre = $request->get('nombre');
    $id_carrera = $request->get('carrera_id');
    $numc = $request->get('numc');
    $roleid = $request->get('role_id');

    $visto = ($request->get('visto')) ? true :null;
    
    $id_carreras=UserCarrera::where('identificador',usuario()->identificador)->pluck('carrera_id');
    $carreras = Carrera::whereIn('id',$id_carreras)->get();
    //toma los id de carreras de las cuales tiene permiso
    if(!$id_carrera){
      $id_carrera = $id_carreras;
    }else{
      $id_carrera = array($id_carrera);
    }
    $respuesta = ($filtro == 'pendientes') ? '=' : '!='; 
    $permisod = UserAdscripcion::where('identificador','=',usuario()->identificador)->pluck('adscripcion_id');


     //solicitudes de estudiantes y docentes que no han sido revisadas
    $solicitudes = Solicitud::join('users','solicituds.identificador','=','users.identificador')
                            ->leftJoin('recomendacions','solicituds.id','=','recomendacions.id_solicitud')
                            ->leftJoin('observaciones',function($join){
                              $join->on('observaciones.solicitud_id', '=', 'solicituds.id')
                              ->where('observaciones.identificador', '=', usuario()->identificador);
                            })
                            ->select('solicituds.*','observaciones.voto','observaciones.descripcion','observaciones.visto')
                            ->where('recomendacions.respuesta',$respuesta,null)
                            ->where(function ($query) use ($id_carrera,$permisod){
                               $query->where('solicituds.enviadocoor','=',true)
                                     ->whereIn('users.carrera_id', $id_carrera)
                                     ->orWhere(function ($query) use ($permisod){
                                      $query->where('solicituds.enviado','=',true)
                                      ->whereIn('users.adscripcion_id',$permisod);});})
                            ->whereHas('user', function($query) use ($nombre,$numc,$roleid) {
                                  $query->nombre($nombre)
                                        ->identificador($numc)
                                        ->role($roleid);})
                            ->when($filtro == 'pendientes', function($query) use ($visto){
                              $query->where('observaciones.visto',$visto);
                            })
                            ->paginate(5);
                            
      if($filtro == 'finalizadas'){
      //si se filtran las solicitudes por finalizadas(vistas en reunion) se retorna la vista
      return view('jefe.solicitudesTerminadas',compact('solicitudes','carreras'));
      }else{
      if(!$request->get('visto')){
      //si las solicitudes se filtran por recibidas(nuevas solicitudes) y que no han sido vistas
      //se hace un conteo esas solicitudes pendientes para notificar al usuario por si quedan solicitudes pendientes por revisar
      Notificacion::where([['identificador','=',usuario()->identificador],['tipo','=','solicitud']])->update(['num' => $solicitudes->total()]);
      }
      return view('jefe.solicitudesRecibidas',compact('solicitudes','carreras'));
      }
}

 
     
    //acceso a la funcion solo para jefes, validado en el constructor
    /*funcion que muestra los dictamenes recibidos, los cuales se pueden filtrar por dictamenes que fueron 
    entregados, que aun no se entregan, rol(estudiante,docente), numero de control, RFC, nombre, apellidos,
    carrera y adscripcion*/
    public function dictamenes(Request $request,$f){
    $user = Auth::user();
    //Datos para el filtrado         
    $entregado = ($f == 'entregado') ?  true: false;//fltrado por entregado, no entregado
    $roleid = $request->get('role_id');// filtrado por rol, estudiante o docente
    $ide= $request->get('numc'); //filtrado por número de control o RFC
    $nombre= $request->get('nombre'); //filtrado por nombre o apellidos
    $carreraid= $request->get('carrera_id'); //filtrado por
    //valida que el usuario se jefe de divison de estudios o jefe de servicios escolares
    if($user->esIntegrante()){
      /*la validacion se realiza debido a que el jefe de division y jefe de servicios 
      reciben solicitudes de todas las carreras*/
      $carreras_id = Carrera::all()->pluck('id');
      $carreras = Carrera::whereIn('id',$carreras_id)->get();
      $adscrip = Adscripcion::where('tipo','=','carrera')->pluck('id'); 
    }else{
      //los jefes de departamento solo reciben solicitudes de su departamento 
    $carreras_id = CarreraDepartamento::where('adscripcion_id','=',$user->adscripcion_id)->pluck('carrera_id');
    $carreras = Carrera::whereIn('id',$carreras_id)->get();//para poder filtrar, se muestran en un select
    $adscrip = [$user->adscripcion_id]; 
    }
    
    if($carreraid){              
     $carreras_id =[$carreraid];
    }
      //filtrado de los dictamenes
      $dictamenes = Dictamen::join('recomendacions','dictamens.recomendacion_id','=','recomendacions.id')
                        ->join('solicituds','recomendacions.id_solicitud','=','solicituds.id')
                        ->join('users','solicituds.identificador','=','users.identificador')
                        ->join('users_dictamenes',function($join) use ($entregado){
                          $join->on('users_dictamenes.dictamen_id', '=', 'dictamens.id')
                          ->where('users_dictamenes.identificador', '=', usuario()->identificador)
                          ->where('users_dictamenes.recibido','=',$entregado);
                        })
                        ->select('dictamens.*')
                        ->where(function ($query) use ($carreras_id,$adscrip){
                          $query->whereIn('users.carrera_id',$carreras_id)
                                ->orWhereIn('users.adscripcion_id',$adscrip);
                        })
                        ->where(function ($query) use ($nombre){
                          $query->where('users.nombre','LIKE',"%$nombre%")
                                ->orWhere('users.apellido_paterno','LIKE',"%$nombre%")
                                ->orWhere('users.apellido_materno','LIKE',"%$nombre%");
                        })
                        ->where('users.identificador','LIKE',"%$ide%")
                        ->where('users.role_id','LIKE',"%$roleid%")
                        ->where('dictamens.enviado','=',true)
                        ->paginate(5);
              
      Notificacion::where([['identificador','=',$user->identificador],['tipo','=','newdictamen']])->update(['num' => 0]);
      if(!$entregado){
      return view('jefe.dictamenesRecibidos',compact('dictamenes','carreras'));
      }else{
        return view('jefe.dictamenesEntregados',compact('dictamenes','carreras'));
      }
  }



    //acceso a la funcion solo para jefes, validado en el constructor
    //funcion que retorna la vista del jefe mostrando las fechas de reunion registradas
    public function calendario(){
        return view('layouts.calendario')->with('encabezado','layouts.encabezadojefe');
    }


    //acceso a la funcion solo para jefes, validado en el constructor
    //funcion que retorna la vista para que el jefe pueda actualizar sus datos de usuario
    public function editarUsuario(){
        $usuario = Auth::user();
        $ads_carreras = Adscripcion::where('id',$usuario->adscripcion_id)->get();
        return view('auth.edit_usuario',compact('usuario','ads_carreras'))->with('encabezado','layouts.encabezadojefe');
    }


    //acceso a la funcion solo para jefes, validado en el constructor
    //funcion que marca a un dictamen como entregado cuando el jefe entrega el dictamen al solicitante
    public function entregarDictamen($id){
      Dictamen::where('id','=',$id)->update(['entregado' => true]);
      return back()->with('Mensaje','El dictamen se ha marcado como entregado');
    }
}
