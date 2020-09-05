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
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller{

    public function __construct(){
        $this->middleware('auth');//middleware para validar que el usuario este autenticado
        //middleware que da acceso a los integrantes de comite(jefes,subdirector,director,secretario)
        $this->middleware('integrante', ['only' => ['mostrarCitatorio','getHistorial','verSolicitudEvidencia','guardarObservacion','getObservaciones']]);
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
        //notificaciones para mostrar al usuario quien ha visto el citatorio
        $citrec= Notificacion::where([['tipo','citatorio'],['citatorio_id',$id]])->get();
        return view('jefe.vercitatorio',compact('citatorio','citrec'));
    }


     //acceso a la funcion para coordinador,jefes,subdirector,secretario y director, validado en el constructor
    //funcion para mostrar al usuario las solicitudes que ha hecho un usuario
    public function getHistorial(Request $request){
        if($request->ajax()){
            $identificador =$request->identificador;
            //solicitud actual que se omite
            $sol =$request->sol;
            //obtiene las solicitudes que ha hecho el solicitante en reuniones pasadas
            $solicitudes = Solicitud::where([['identificador','=',$identificador],['enviado','=',true],['id','!=',$sol]])->get();
            return response()->json($solicitudes);
        }
    }

    //acceso a la funcion para coordinador,jefes,subdirector,secretario y director, validado en el constructor
    //funcion que muestra al usuario la solicitud junto con las evidencias en pdf
    public function verSolicitudEvidencia($id){
        $usuario=Auth::user();
        $solicitud=Solicitud::find($id);//se buscan los datos de la solicitud
        if(!$solicitud->solicitud_firmada){
            return back()->with('Error','Solicitud subida por el usuario no encontrada');
        }
        //La solicitud firmada y las evidencias se unen en un solo documento
        $documento = new Merger;
        //primero se toma la solicitud firmada
        $solicitud_firmada='storage/'.$solicitud->solicitud_firmada;
        $documento->addFile($solicitud_firmada);
        //si la solicitud tiene evidencias se cargan
        if($solicitud->evidencias){
            $evidencias='storage/'.$solicitud->evidencias;
            $documento->addFile($evidencias);
        }
        $salida = $documento->merge();
        //muestra el pdf
        $nombreArchivo ="solicitud.pdf";
        header("Content-type:application/pdf");
        header("Content-disposition: inline; filename=$nombreArchivo");
        header("content-Transfer-Encoding:binary");
        header("Accept-Ranges:bytes");
        echo $salida;
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
        return back()->with('Mensaje','Solicitud enviada');
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
       $request->validate(['identificador' => 'required|unique:users,identificador,'.$id,
                           'email' => 'required|email|unique:users,email,'.$id]);
       User::where('id','=',$id)->update($datosest);
       return back()->with('Mensaje','Datos actualizados correctamente');
   }
    
}
