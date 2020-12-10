<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Solicitud;
use App\Observaciones;
use App\UserCarrera;
use App\Notificacion;
use App\Calendario;
use App\Citatorio;
use App\User;
use App\UsersDictamenes;
use App\Acta;
use App\Dictamen;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NuevaSolicitud;
use Barryvdh\DomPDF\Facade as PDF;

class UsuariosController extends Controller{

    public function __construct(){
        $this->middleware('auth');//middleware para validar que el usuario este autenticado
        //middleware que da acceso a los integrantes de comite(jefes,subdirector,director,secretario)
        $this->middleware('integrante', ['only' => ['mostrarCitatorio','mostrarOrden','getHistorial','verSolicitudEvidencia','guardarObservacion','getObservaciones']]);
    }
    

    //acceso a la funcion para coordinador,jefes,subdirector,secretario y director, validado en el constructor
    //funcion que muestra el citatorio recibido
    public function mostrarCitatorio($id){
        $citatorio = Citatorio::findOrFail($id);
        $reunion = Calendario::find($citatorio->calendario_id);
        if($reunion->start < hoy()){
          //al momento de que los integrantes vean el citatorio se marca como visto
          Notificacion::where([['tipo','citatorio'],['citatorio_id',$id],['identificador',usuario()->identificador]])->update(['visto' => true]);
        }else{
          Notificacion::where([['tipo','citatorio'],['citatorio_id',$id],['identificador',usuario()->identificador]])->update(['num' => 2]);
        }
        return view('jefe.vercitatorio',compact('citatorio'));
    }

    public function mostrarOrden($id){
        $citatorio = Citatorio::findOrFail($id);
        $acta = Acta::where([['titulo','=','ordendia'],['calendario_id','=',$citatorio->calendario_id]])->first();
        $reunion = Calendario::find($citatorio->calendario_id);
        if($reunion->start < hoy()){
          //al momento de que los integrantes vean el orden del dia se elimina solo cuando la reunion ya paso
          Notificacion::where([['tipo','ordendia'],['citatorio_id',$id],['identificador',usuario()->identificador]])->delete();
        }
        return view('jefe.verorden',compact('acta'));
    }


     //acceso a la funcion para coordinador,jefes,subdirector,secretario y director, validado en el constructor
    //funcion para mostrar al usuario las solicitudes que ha hecho un usuario
    public function getHistorial(Request $request){
        if($request->ajax()){
            $identificador =$request->identificador;
            //solicitud actual que se omite
            $sol =$request->sol;
            //obtiene las solicitudes que tienen dictamenes que ha hecho el solicitante
            $solicitudes = Dictamen::join('recomendacions','dictamens.recomendacion_id','=','recomendacions.id')
                                   ->join('solicituds','recomendacions.id_solicitud','=','solicituds.id')
                                   ->select('dictamens.dictamen_firmado','solicituds.asunto as asunto')
                                   ->where('solicituds.identificador','=',$identificador)
                                   ->where('solicituds.id','!=',$sol)
                                   ->get();
            return response()->json($solicitudes);
        }
    }

    //acceso a la funcion para coordinador,jefes,subdirector,secretario y director, validado en el constructor
    //funcion que muestra al usuario la solicitud junto con las evidencias en pdf
    public function verSolicitudEvidencia($id){
        $solicitud=Solicitud::find($id);//se buscan los datos de la solicitud
        if(!$solicitud->solicitud_firmada){
            return back()->with('Error','Solicitud subida por el usuario no encontrada');
        }
        $nom = $solicitud->evidencias ? ''.$solicitud->solicitud_firmada.'-'.$solicitud->evidencias : $solicitud->solicitud_firmada;
        $nombres = explode("-", $nom);
        $titulo = "SOLICITUD-EVIDENCIAS";
        $pdf = PDF::loadView('solicitante.pdf', compact('nombres','titulo'))->setPaper('carta','portrait');
        return $pdf->stream('archivo.pdf');

    }


    //acceso a la funcion para coordinador,jefes,subdirector,secretario y director, validado en el constructor
    //funcion para guardar la observacion que hace un usuario a una solicitud
    public function guardarObservacion(Request $request){
        $iduser=usuario()->identificador;
        //se guarda la observacion que hace el usuario a la solicitud, en caso que ya exista entonces se modifica
        $observ = Observaciones::updateOrCreate(
            ['identificador' => $iduser, 'solicitud_id' => $request['solicitud_id']],
            ['descripcion' => $request['descripcion'], 'voto' => $request['voto'], 'visto' => true]
        );
        return back()->with('Mensaje','Cambios hechos correctamente');
    }




    //acceso a la funcion para coordinador,jefes,subdirector,secretario y director, validado en el constructor
    //funcion para que el usuario pueda ver las observaciones hechas por los integrantes a una solicitud
    public function getObservaciones(Request $request){
        if($request->ajax()){
            $solicitud = $request->solicitud_id;
            //observaciones que se han hecho a una solicitud en especifica
            $observaciones = Observaciones::where('solicitud_id','=',$solicitud)
                                          ->join('users','observaciones.identificador','=','users.identificador')
                                          ->select('observaciones.*','users.nombre','users.apellido_paterno','users.apellido_materno')
                                          ->get();
            //conteo de votos que se han hecho
            $si = Observaciones::where('voto',"SI")->where('solicitud_id','=',$solicitud)->count();
            $no = Observaciones::where('voto','=',"NO")->where('solicitud_id','=',$solicitud)->count();
            return response()->json(['observaciones' => $observaciones, 'si' => $si, 'no' => $no]);
        }else{
            return redirect('/');
        }
    }



    //acceso a la funcion para usuarios autenticados, validado en el constructor
    //funcion para que el usuario vea una notificacion
    public function verNotificacion($id){
        $ide = usuario()->identificador;        
        $noti = Notificacion::where([['identificador','=',$ide],['id','=',$id]])->firstOrFail();
        if($noti->tipo != "cancelado"){
            //Si la notificacion no es de tipo cancelada entonces se elimina la notificacion al ser vista
            Notificacion::where([['identificador','=',$ide],['id','=',$id]])->delete();
        }
        //si la notificacion es de tipo dictamen_nuevo entonces muestra los dictamenes que recibieron los usuarios segun su rol
        if($noti->tipo == "dictamen_nuevo"){
            if(usuario()->esCoor()){
                return redirect()->route('coordinador.dictamenes');
            }elseif(usuario()->esJefe()){
                return redirect()->route('jefe.dictamenes','no_entregado');
            }else{
                return redirect()->route('sub.dictamenes');
            }
        }
        return view('solicitante.notificacion',compact('noti'));
    }



    //acceso a la funcion para usuarios autenticados, validado en el constructor
    //funcion para mostrar las notificaciones que recibe el usuario
    public function getNotificaciones(Request $request){
        if($request->ajax()){            
            $useridenti = Auth::user()->identificador;
            //notificaciones que no han sido vistas
            $notifications = Notificacion::where([['identificador','=',$useridenti],['visto','=',false],['num','>',0]])->get();
            return response()->json($notifications);
        }
    }



    //acceso a la funcion para usuarios autenticados, validado en el constructor
    //funcion para cargar las fechas de reunion en un calendario
    public function mostrarReuniones(){
        $fechas['calendario']=Calendario::all();
        return response()->json($fechas['calendario']);
    }


    //acceso a la funcion para usuarios autenticados, validado en el constructor
    //funcion para actualizar los datos de los usuarios
    public function actualizarUsuario(Request $request, $id){
        $datosest=request()->except(['_token','_method','password']);
       if($request['password']){
           //en caso que se requiera cambiar la contraseña
           $datosest['password'] = Hash::make($request['password']);     
       }

       $user = Auth::user();
       //el usuario autenticado puede cambiar sus datos
       //el administrador puede cambiar datos de cualquier usuario
       if(!$user->esAdmin()){
           $id = $user->id;
       }
       if($user->role_id != 9){
           $request->validate(['identificador' => 'required|unique:users,identificador,'.$id,
           'email' => 'required|email|unique:users,email,'.$id]);
       }
       User::where('id','=',$id)->update($datosest);
       return back()->with('Mensaje','Datos actualizados correctamente');
   }

   public function marcarDictamen(Request $request){
       if($request->ajax()){
           UsersDictamenes::where([
               ['identificador','=',$request->user],
               ['dictamen_id','=',$request->dic]
           ])->update(['recibido' => true]);
           return response()->json([],200);
       }
   }

   public function pruebaCorreo(){
       Mail::to('davidclash38563@gmail.com')->queue(new NuevaSolicitud());
       return "success";
   }
    
}
