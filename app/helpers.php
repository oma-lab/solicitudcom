<?php

use App\User;
use Carbon\Carbon;
use App\Calendario;
use App\UserCarrera;
use App\UserAdscripcion;
use App\Notificacion;
use App\Solicitud;
use App\Citatorio;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegresarSolicitud;
use App\Mail\SolicitudVista;
use App\Mail\DictamenTerminado;
use App\Mail\EnviarCitatorio;


function usuario(){
    return auth()->user();
}
function identificador(){
    return auth()->user()->identificador;
}
function presidente(){
    return User::where('role_id','=',8)->first();
}
function secretario(){
    return User::where('role_id','=',1)->first();
}
function director(){
    return User::where('role_id','=',2)->first();
}
function jefeServicios(){
    return User::where('adscripcion_id','=',25)->first();
}
function jefeDivision(){
    return User::where('adscripcion_id','=',11)->first();
}
function jefeDesarrollo(){
    return User::where('adscripcion_id','=',12)->first();
}
function grado_nombre_puesto_presidente(){
    $pre = presidente();
    return $pre->grado." ".$pre->nombre_completo()." ".$pre->presidente()." del comité académico";
}
function nombre_puesto_presidente(){
    $pre = presidente();
    return $pre->el()." ".$pre->grado." ".$pre->nombre_completo().", en su calidad de ".$pre->presidente();
}
function subdirector_academico_presidente(){
    $sub = presidente();
    return ($sub->sexo == 'H') ? "Subdirector Académico.-Presidente de Comité Académico" : "Subdirectora Académica.-Presidenta de Comité Académico";
}
function semestre(){
    $numc=usuario()->identificador;
    $anio = (is_int($numc)) ? substr($numc,0,2) : substr(intval(preg_replace('/[^0-9]+/','',$numc),10),0,2);
    $sem = (date("y") - $anio) * 2;
    $sem = (date("n") > 6) ? ($sem + 1) : $sem;
    return $sem;
}

function proximaReunion(){
    return Calendario::whereDate('start','>=',Carbon::now()->format('Y-m-d'))->orderBy('start','asc')->first();
}




//--------------------FUNCIONES PARA PARSEAR FECHA Y HORA----------
function hoy(){
    return Carbon::now()->format('Y-m-d');
}
function fechabase($fecha){
    return Carbon::parse($fecha)->format('Y-m-d');
}
//acta
function fecha($fecha){
    //formato -->  20/01/2020
    return Carbon::parse($fecha)->format('d/m/Y');
}
function fechaLetra($fecha){
    setlocale(LC_TIME, "es_MX.UTF-8");
    //formato -->  20 de enero
    return Carbon::parse($fecha)->formatLocalized('%d de %B');
}
function fechaLetraAnio($fecha){
    setlocale(LC_TIME, "es_MX.UTF-8");
    //formato -->  20 de enero del 2020
    return Carbon::parse($fecha)->formatLocalized('%d de %B del %Y');
}
function hoyMesLetra(){
    setlocale(LC_TIME, "spanish"); 
    //formato 03/enero/2020
    return Carbon::now()->formatLocalized('%d/%B/%Y');
}
function hora(){
    $args = func_get_args();
    if(count($args) == 0){
        return Carbon::now()->format('H');
    }else{
        return Carbon::parse($args[0])->format('H:i');
    }
}
function anio(){
    return Carbon::now()->format('Y');
}

//funcion que calcula una fecha con un intervalo de dias pasados o proximos dias a partir de hoy
//por ejemplo reunion('5 days') retorna la fecha 5 dias despues de hoy
//reunion('- 5 days') ->fecha 5 dias antes de hoy
function calculafecha($intervalo){
    $fecha = hoy();
    $nueva_fecha = DateTime::createFromFormat('Y-m-d', $fecha);
    $nueva_fecha->add(DateInterval::createFromDateString($intervalo));
    return $nueva_fecha;
}





//-------------FUNCIONES PARA GENERAR UNA NOTIFICACION---------------------
//notificacion para solicitantes
function notificarSolicitante(array $datos){
    $solic = Solicitud::findOrFail($datos['id_sol']);
    Notificacion::create([
        'identificador' => $solic->identificador,
        'tipo' => $datos['tipo'],
        'solicitud_id' => $datos['id_sol'],
        'mensaje' => $datos['mensaje'],
        'descripcion' => $datos['descripcion'],
        'observacion' => $datos['obs_coor'],
        'num' => 1,
    ]);
    if($datos['tipo'] == "cancelado"){
        try{
        Mail::to($solic->user->email)->queue(new RegresarSolicitud($datos['obs_coor'],$solic));
        }catch(Exception $e){}
    }
    if($datos['tipo'] == "respuesta_solicitud"){
        try{
        Mail::to($solic->user->email)->queue(new SolicitudVista($solic));
        }catch(Exception $e){}
    }
    if($datos['tipo'] == "dictamen_enviado"){
        try{
        Mail::to($solic->user->email)->queue(new DictamenTerminado($solic));
        }catch(Exception $e){}
    }
    fcm()->to([$solic->user->token])
    ->notification([
       'title' => $datos['mensaje'],
       'body' => $datos['descripcion']
    ])->send();
}



//notificacion para coordinadores,jefes,subdirector,director y secretario
function notificar(array $datos){
    if($datos['tipo'] == "solicitud" || $datos['tipo'] == "dictamen_nuevo"){
        if(isset($datos['carrera_id'])){    
            $usuarios_enviar = UserCarrera::join('users','user_carreras.identificador','=','users.identificador')
                                          ->where('user_carreras.carrera_id',$datos['carrera_id'])
                                          ->whereIn('users.role_id',$datos['roles'])
                                          ->pluck('user_carreras.identificador');
        }
        if(isset($datos['adscripcion_id'])){
            $usuarios_enviar = UserAdscripcion::join('users','user_adscripcions.identificador','=','users.identificador')
                                              ->where('user_adscripcions.adscripcion_id',$datos['adscripcion_id'])
                                              ->whereIn('users.role_id',$datos['roles'])
                                              ->pluck('user_adscripcions.identificador');
        }                              
    }else{
        $usuarios_enviar = User::whereIn('role_id',$datos['roles'])->pluck('identificador');
    }        
    foreach($usuarios_enviar as $usuario){
    $citatorio_id = isset($datos['citatorio']) ? $datos['citatorio'] : null;    
    $notificacion = Notificacion::updateOrCreate(
               ['identificador' => $usuario, 'tipo' => $datos['tipo']],
               ['mensaje' => $datos['mensaje'], 'descripcion' => $datos['descripcion'], 'citatorio_id' => $citatorio_id, 'num' => 1]
    );
    }
    if($datos['tipo'] == "citatorio"){
        $citatorio = Citatorio::find($datos['citatorio']);
        $emails = User::whereIn('role_id',$datos['roles'])->pluck('email');
        $usuarios = User::whereIn('role_id',$datos['roles'])->pluck('token')->toArray();
        try{
        Mail::to($emails)->queue(new EnviarCitatorio($citatorio));
        }catch(Exception $e){}
        fcm()->to($usuarios)
        ->notification([
           'title' => $datos['mensaje'],
           'body' => $datos['descripcion']
        ])->send();
    }
}

