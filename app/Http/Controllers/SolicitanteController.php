<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Solicitud;
use App\Asunto;
use App\Calendario;
use App\Carrera;
use App\Adscripcion;
use App\User;
use Carbon\Carbon;
use App\Formato;
use App\Dictamen;
use App\Notificacion;
use App\Recomendacion;
use App\Observaciones;
use App\UserCarrera;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class SolicitanteController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');//middleware para validar que el usuario este autenticado
        //middleware que valida que el solicitante solo tenga acceso a las funciones indicadas
        $this->middleware('solicitante', ['only' => ['home', 'crearSolicitud', 'guardarSolicitud','editarSolicitud','updateSolicitud','dictamenes','calendario','editarUsuario','enviarSolicitud']]);
        //middleware que valida que el solicitante y el administrador tengan acceso a las funciones indicadas
        $this->middleware('adminSolicitante', ['only' => ['eliminarSolicitud']]);
    }


    //acceso a la funcion solo para el solicitante, validado en el constructor
    public function home(){
        //solicitudes que ha registrado el solicitante
        $soli = Solicitud::where('identificador','=',usuario()->identificador)->orderBy('created_at', 'desc')->get();            
        return view('solicitante.home',compact('soli'));
    }


    //acceso a la funcion solo para el solicitante, validado en el constructor
    //funcion que retorna un formulario para poder crear una solicitud
    public function crearSolicitud(){
        //valida que la solicitud se registre cuando existe una reunion 
        $prox=Calendario::whereDate('start','>=',Carbon::now()->format('Y-m-d'))->orderBy('start','asc')->first();
        if(!$prox){
           return back()->with('Error','No hay fecha proxima de reunión');
        }
        //valida que la solicitud no se registre el mismo dia de reunion
        $actual= Calendario::whereDate('start','=',Carbon::now()->format('Y-m-d'))->first();
        if($actual){
            return back()->with('Error','No puedes realizar solicitud el mismo dia de la reunión, espera a la próxima');
        }
        //no se pueden crear mas de una solicitud por reunion
        $solirecientes= Solicitud::where('calendario_id','=',$prox->id)->where('identificador','=',usuario()->identificador)->first();//solicitudes creadas despues de la ultima reunion
        if($solirecientes){
            return back()->with('Error','No puedes realizar otra solicitud, Solo puedes crear una solicitud por reunión');
        }
        $asuntos = Asunto::all();//se cargan los asuntos
        $carreras = Carrera::all();//carreras para que el docente especifique a que carrera imparte clases
        return view('solicitante.crearSolicitud',compact('asuntos','carreras'));
    }





    //acceso a la funcion solo para el solicitante, validado en el constructor
    //funcion que registra una solicitud
    public function guardarSolicitud(Request $request){
        $datosSolicitud=request()->except('_token');
        //se crea la solicitud con los datos recibidos
        $datosSolicitud['identificador']=usuario()->identificador;
        $datosSolicitud['calendario_id']=proximaReunion()->id;  
        Solicitud::create($datosSolicitud);
        return redirect()->route('home');
    }




    //acceso a la funcion solo para el solicitante, validado en el constructor
    //funcion que retorna vista para poder hacer cambios a la solicitud
    public function editarSolicitud($id){     
        $carreras = Carrera::all();
        $solicitud = Solicitud::where([['identificador','=',usuario()->identificador],['id','=',$id]])->firstOrFail();
        //Valida que la solicitud no ha sido enviada, la solicitud no se puede modificar despues de enviar
        if(!$solicitud->enviado){
            return view('solicitante.edit',compact('solicitud','carreras'));
        }else{
            return back()->with('Mensaje','No es posible Modificar');
        }
    }


    //acceso a la funcion solo para el solicitante, validado en el constructor
    //funcion que guarda los cambios que se realizan a una solicitud
    public function updateSolicitud(Request $request, Solicitud $solicitud){
        $datosSol=request()->except(['_token','_method','doc_firmado']);
        $solicitud = Solicitud::findOrFail($solicitud->id);
        if($request->hasFile('doc_firmado')){
            Storage::delete('public/'.$solicitud->solicitud_firmada);
            $datosSol['solicitud_firmada']=$request->file('doc_firmado')->store('solicitudes','public');
        }
        //se actualiza la solicitud con los datos recibidos
        $solicitud->update($datosSol);
        return redirect()->route('solicitante.home')->with('Mensaje','Formato modificado con exito');
    }


    //acceso a la funcion solo para el solicitante, validado en el constructor
    //funcion para generar la solicitud en formato pdf
    public function verSolicitud($id){
        //valida que el jefe de division y presidente de comité esten registrado, si no existen no se pueden genera la solicitud
        if(!presidente()){return back()->with('Error','No hay presidente de comité académico registrado');}
        $jefeDivision = User::where([['role_id','=',5],['adscripcion_id','=',11]])->first();
        if($jefeDivision){
        //se cargan los datos de la solicitud
        $solicitud = Solicitud::findOrFail($id);
        //se carga el formato del documento
        $datospdf = Formato::findOrFail(1);
        //datos del usuario autenticado
        $usuario=Auth::user();
        $suma = strlen($solicitud->asunto) + strlen($solicitud->motivos_academicos) + strlen($solicitud->motivos_personales) + strlen($solicitud->otros_motivos);
        $pdf = PDF::loadView('solicitante.pdfsolicitud',compact('solicitud','datospdf','usuario','suma'))->setPaper('carta','portrait');
        return $pdf->stream('solicitud.pdf');
        }else{
        return back()->with('Mensaje','La solicitud no se puede realizar debido a que no se tiene un jefe de división registrado.');
        }
    }

    public function verEvidencia($id){
        $solicitud = Solicitud::where([['id','=',$id],['identificador','=',Auth::user()->identificador]])->firstOrFail();
        $nombres = explode("-", $solicitud->evidencias);
        $titulo = "EVIDENCIAS";
        $pdf = PDF::loadView('solicitante.pdf', compact('nombres','titulo'))->setPaper('carta','portrait');
        return $pdf->stream('evidencias.pdf');
    }


    //acceso a la funcion solo para el solicitante, validado en el constructor
    //funcion para mostrar los dictamenes que ha recibido el solicitante
    public function dictamenes(){
        $user = Auth::user();
        //filtra los dictamenes que ha recibido el solicitante
        $ds = Dictamen::join('recomendacions','dictamens.recomendacion_id','=','recomendacions.id')
                      ->join('solicituds','recomendacions.id_solicitud','=','solicituds.id')
                      ->join('users','solicituds.identificador','=','users.identificador')
                      ->select('dictamens.*')
                      ->where([['users.identificador',$user->identificador],['dictamens.enviado',true]])
                      ->get();
        return view('solicitante.dictamenes',compact('ds'));
    }


    //acceso a la funcion solo para el solicitante, validado en el constructor
    //funcion para mostrar las fechas de reunion en un calendario
    public function calendario(){
        return view('layouts.calendario')->with('encabezado','layouts.encabezadoSolicitante');
    }


    //acceso a la funcion solo para el solicitante, validado en el constructor
    //funcion que retorna la vista para que el usuario pueda actualizar sus datos
    public function editarUsuario(){
        $usuario = Auth::user();
        if($usuario->esEstudiante()){
            $ads_carreras = Carrera::all();
        }elseif($usuario->esDocente()){
            $ads_carreras = Adscripcion::where('tipo','carrera')->get();
        }else{
            $ads_carreras = Adscripcion::where('id',$usuario->adscripcion_id)->get();
        }
        return view('auth.edit_usuario',compact('usuario','ads_carreras'))->with('encabezado','layouts.encabezadoSolicitante');
    }



    //acceso a la funcion solo para el solicitante, validado en el constructor
    //Funcion que se ejecuta cuando el solicitante envia su solicitud
    public function enviarSolicitud($id){
        $usuario=Auth::user();
        $sld = Solicitud::find($id);
        //valida que se suba la solicitud, tenga evidencias y que no hay sido enviado
        if(!$sld->solicitud_firmada){return back()->with('Error','No es posible Enviar, falta subir formato firmado con tus evidencias');}
        if($sld->enviado){return back()->with('Error','Enviado, solo es posible enviar una vez');}
        //actualiza la solicitud como enviado
        Solicitud::where('id',$id)->update(['enviado' => true]);
        //se elimina la notificacion en caso que su solicitud haya sido cancelada
        Notificacion::where('tipo','cancelado')->where('identificador',usuario()->identificador)->delete();
        Observaciones::where('solicitud_id',$id)->delete();
        //se guarda notificacion que notificara a los coordinadores y jefes sobre una nueva solicitud 
        //si el usuario es estudiante se envia al coordinador y secretario, en caso contrario se envia a jefes de departamento, subdirector y secretario
        if(!usuario()->esDepto()){
            $roles = usuario()->esEstudiante() ? [6,1] : [8,5,1];
            notificar([
                'carrera_id' => $usuario->carrera_id,
                'adscripcion_id' => $usuario->adscripcion_id,
                'roles' => $roles,
                'tipo' => 'solicitud',
                'mensaje' => 'Nuevas Solicitudes',
                'descripcion' => 'Nuevas solicitudes registradas'
            ]);
        }
        return back()->with('Mensaje','Tu solicitud se ha enviado, mantente pendiente en esta página , es posible que tu solicitud requiera cambios y tendrás que volver a enviar, te notificaremos cuando tu dictamen tenga una respuesta');
    }




    //acceso a la funcion para el solicitante y administrador, validado en el constructor
    /*funcion para que el estudiante puede eliminar su solicitud si no lo ha enviado, el 
    secretario podra eliminar una solicitud en caso que se cancele*/
    public function eliminarSolicitud($id){
        $solicitud = Solicitud::findOrFail($id);
        //valida que no se haya enviado
        if($solicitud->enviado && usuario()->esSolicitante()){
            return back()->with('Mensaje','No es posible Eliminar');
        }else{
            Storage::delete('public/'.$solicitud->solicitud_firmada);
            Solicitud::destroy($id);
            return back()->with('Mensaje','Formato eliminado con éxito');
        }
    }



}
