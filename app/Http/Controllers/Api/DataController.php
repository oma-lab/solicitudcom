<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Solicitud;
use App\Notificacion;
use App\Dictamen;
use App\UserCarrera;
use App\UserAdscripcion;
use App\Observaciones;
use App\Citatorio;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade as PDF;
use iio\libmergepdf\Merger;


class DataController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');//middleware que valida que el usuario este autenticado
    }


    public function solicitud(){
        $identificador = Auth::user()->identificador;
        $solicitud = DB::table('solicituds')
                         ->leftJoin('recomendacions','solicituds.id','=','recomendacions.id_solicitud')
                         ->leftJoin('dictamens','recomendacions.id','=','dictamens.recomendacion_id')
                         ->select('solicituds.asunto','solicituds.enviado','solicituds.enviadocoor','recomendacions.respuesta','recomendacions.enviado as rec_enviado','dictamens.enviado as dic_enviado')
                         ->where('solicituds.identificador','=',$identificador)
                         ->first();
        return response()->json($solicitud);
    }


    public function citatorio(){
        $citatorio = Citatorio::join('calendarios','citatorios.calendario_id','=','calendarios.id')
                              ->join('notificacions','citatorios.id','=','notificacions.citatorio_id')
                              ->whereDate('calendarios.start','>=',hoy())
                              ->select('citatorios.id','citatorios.archivo as citatorio','calendarios.lugar','calendarios.start as dia','calendarios.hora','notificacions.visto')
                              ->first();
        return response()->json($citatorio);
    }


    public function solicitudes(){
        $identificador = Auth::user()->identificador;
        $permiso = UserCarrera::where('identificador','=',$identificador)->pluck('carrera_id');
        $permisodocente = UserAdscripcion::where('identificador','=',$identificador)->pluck('adscripcion_id');
        $solicitudes = Solicitud::join('users','solicituds.identificador','=','users.identificador')
                                ->leftJoin('carreras','users.carrera_id','=','carreras.id')
                                ->leftJoin('adscripcions','users.adscripcion_id','=','adscripcions.id')
                                ->leftJoin('recomendacions','solicituds.id','=','recomendacions.id_solicitud')
                                ->leftJoin('observaciones',function($join) use ($identificador){
                                    $join->on('observaciones.solicitud_id', '=', 'solicituds.id')
                                    ->where('observaciones.identificador', '=', $identificador);
                                })
                                ->select('solicituds.*','users.nombre','users.apellido_paterno','users.apellido_materno','carreras.nombre as nombre_carrera','adscripcions.nombre_adscripcion','observaciones.visto')
                                ->where('recomendacions.respuesta','=',null)                                
                                ->where(function ($query) use ($permiso,$permisodocente){
                                    $query->where('solicituds.enviadocoor','=',true)
                                          ->whereIn('users.carrera_id', $permiso)
                                          ->orWhere(function ($query) use ($permisodocente){
                                           $query->where('solicituds.enviado','=',true)
                                           ->whereIn('users.adscripcion_id',$permisodocente);});})
                                ->get();
        return response()->json(['solicitudes' => $solicitudes]);
    }


    public function notificaciones(){
        $identificador = Auth::user()->identificador;
        $notificaciones = Notificacion::where('identificador','=',$identificador)->where('visto',false)->get();
        return response()->json(['notificaciones' => $notificaciones]);
    }


    public function dictamenes(){
        $identificador = Auth::user()->identificador;
        $dictamens = Dictamen::join('recomendacions','dictamens.recomendacion_id','=','recomendacions.id')
                            ->join('solicituds','recomendacions.id_solicitud','=','solicituds.id')
                            ->select('dictamens.*','solicituds.asunto')
                            ->where([['solicituds.identificador','=',$identificador],['dictamens.enviado','=',true]])
                            ->get();
        return response()->json(['dictamenes' => $dictamens]);
    }


    public function verSolicitud($id){
        $solicitud=Solicitud::find($id);
        $documento = new Merger;
        $solicitud_firmada='storage/'.$solicitud->solicitud_firmada;
        $documento->addFile($solicitud_firmada);
        if($solicitud->evidencias){
            $evidencias='storage/'.$solicitud->evidencias;
            $documento->addFile($evidencias);
        }
        $salida = $documento->merge();
        echo $salida;
    }

    
    public function recibido(Request $request,$id){
        $identificador = Auth::user()->identificador;
        Observaciones::updateOrCreate(
            ['identificador' => $identificador, 'solicitud_id' => $id],
            ['descripcion' => 'Recibido','visto' => true]
        );
        return response()->json([],204);
    }

    
    public function citatorioVisto(Request $request,$id){
        Notificacion::where([['tipo','citatorio'],['citatorio_id',$id],['identificador',usuario()->identificador]])
                    ->update(['visto' => true]);
        return response()->json([],204);
    }


    
}
