<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adscripcion;
use App\Calendario;
use App\Recomendacion;
use App\Carrera;
use App\Notificacion;
use App\Formato;
use App\Solicitud;
use App\UserCarrera;
use App\Observaciones;
use App\UserAdscripcion;
use App\User;
use App\Role;
use App\Dictamen;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller{
    public function __construct(){
        $this->middleware('auth');//middleware que valida que el usuario este autenticado
        $this->middleware('admin');//middleware que valida que el usuario sea administrador
    }

     
    
    //acceso a la funcion solo para el administrador, validado en el constructor   
    /*funcion para mostrar al secretario las solicitudes registradas , puede filtrar
    las solicitudes por reunion y por carrera*/
    public function solicitudes(Request $request){
        $filtro = $request->get('filtrofecha');
        $filtrocarrera = $request->get('carrera_id');
        //se toman las ultimas dos reuniones pasadas y las dos mas proximas
        $pasadas = Calendario::whereDate('start','<',hoy())->orderBy('start','desc')->take(2)->get();
        $proximas = Calendario::whereDate('start','>=',hoy())->orderBy('start','asc')->take(2)->get()->reverse();
        //filtro para las solicitudes por fecha de reunion, si no se filtra se muestran las de la proxima reunion
        if(!$filtro){
            if(count($proximas) > 0){
                //si hay proxima reunion se filtrara por esa fecha
                $filtro = $proximas->last()->id;
            }else{
                //si no hay proxima se filtrara por la reunion pasada
                $filtro = (count($pasadas) > 0) ? $pasadas->first()->id : '';
            }
        }
        //solicitudes pendientes
        $solicitudes = Solicitud::join('users','solicituds.identificador','=','users.identificador')
                                ->leftJoin('recomendacions','solicituds.id','=','recomendacions.id_solicitud')
                                ->whereNull('recomendacions.respuesta')
                                ->where('solicituds.calendario_id',$filtro)
                                ->where('solicituds.enviado',true)
                                ->where(function($query) use($filtrocarrera){
                                    $query->where('users.carrera_id','LIKE',"%$filtrocarrera%")
                                          ->orWhereNull('users.carrera_id');
                                })
                                ->select('solicituds.*','recomendacions.observaciones')
                                ->paginate(5);
       $carreras = Carrera::all();
       //actualiza notificacion con el numero de solicitudes pendientes
       Notificacion::where([['identificador','=',usuario()->identificador],['tipo','=','solicitud']])->update(['num' => $solicitudes->total()]);
       return view('Administrador.home',compact('solicitudes','pasadas','proximas','filtro','carreras'));
    }




    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para que el secretario pueda ver las carreras y adscripciones registradas
    public function verAdscripciones(){
        $carreras= Carrera::all();
        $adscripciones= Adscripcion::all();
        return view('Administrador.carreras',compact('carreras','adscripciones'));
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para crear una nueva adscripcion
    public function guardarAdscripcion(Request $request){
        Adscripcion::create([
            'nombre_adscripcion' => $request->nombre_adscripcion,
            'tipo' => $request->tipo,
        ]);
        return back()->with('Mensaje','Adscripción registrada');
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para crear nueva carrera
    public function guardarCarrera(Request $request){
        Carrera::create([
            'nombre' => $request->nombre,
        ]);
        return back()->with('Mensaje','Carrera registrada');
    }

    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para eliminar una adscripcion
    public function eliminarAdscripcion($id){
        $solis = User::where('adscripcion_id',$id)->first();
        if($solis){
            return back()->with('Error','No puedes eliminar porque hay usuarios relacionados con esta adscripción');
        }else{
            Adscripcion::destroy($id);
            return back()->with('Mensaje','Adscripción eliminada');
        }
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para eliminar una carrera
    public function eliminarCarrera($id){
        $solis = User::where('carrera_id',$id)->first();
        if($solis){
            return back()->with('Error','No puedes eliminar porque hay usuarios relacionados con esta carrera');
        }else{
            Carrera::destroy($id);
            return back()->with('Mensaje','Carrera eliminada');
        }
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para mostrar las fechas de reunion registradas
    public function calendario(){
        return view('layouts.calendario')->with('encabezado','layouts.encabezadoAdmin');
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para guardar nueva fecha de reunion
    public function guardarFecha(Request $request){
        //metodo para registrar una fecha de reunion
        $datosEvento=request()->except(['_token','_method']);
        $datosEvento['color'] = $request['title'] == 'reunión de Comité Académico' ? 'green' : 'blue';
        Calendario::insert($datosEvento);
        print_r($datosEvento);
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para eliminar una fecha de reunion
    public function eliminarFecha($id){
        $fecha = Calendario::find($id);
        $solicitudes = Solicitud::where('calendario_id',$id)->count();
        //si la fecha de reunion ya tiene solicitudes registradas no se podra eliminar
        if($solicitudes > 0){
            $mensaje = "Error";            
        }else{
            Calendario::destroy($id);
            $mensaje = "Exito";
        }
        return response()->json($mensaje);
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion que retorna la vista para que el administrador pueda posponer una solicitud en 
    caso que la solicitud no se haya visto en la reunion acordada, tambien puede marcar las 
    solicitudes como vistas en caso de que algun integrante no las haya marcado como recibidas*/
    public function actualizarSolicitud($id){
        //se cargan los datos de la solicitud
        $solicitud = Solicitud::find($id);
        //se toma 5 reuniones mas proximas a la fecha actual, tomando pasadas y futuras 
        $proxima = Calendario::whereDate('start','>=',hoy())->orderBy('start','asc')->take(2)->get()->last();
        $proxima = ($proxima) ? $proxima->start : hoy();
        $reuniones = Calendario::whereDate('start','<=',$proxima)->orderBy('start','desc')->take(5)->get();
        if($solicitud->user->esEstudiante()){
        //si la solicitud pertenece a un estudiante, se toman las observaciones que hicieron los integrantes
        $obs = UserCarrera::observaciones($id,$solicitud->user->carrera_id)
                            ->select('user_carreras.*','observaciones.visto')
                            ->get();
        }else{
        //si la solicitud pertenece a un docente
        $obs = UserAdscripcion::observaciones($id,$solicitud->user->adscripcion_id)
                                ->select('user_adscripcions.*','observaciones.visto')
                                ->get();
        }        
        return view('Administrador.editsolic',compact('solicitud','reuniones','obs'));
    }



    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion que guarda la fecha de reunion en donde sera evaluada la solicitud y marca la solicitud como vista por los integrantes
    el dia de reunion en caso de que no hayan sido marcadas como vistas anteriormente*/
    public function guardarSolicitud(Request $request,$id){
        //se actualiza el dia de reunion en la solicitud
        Solicitud::where('id',$id)->update(['calendario_id' => $request->calendario_id]);
        //si el secretario marca la solicitud como vista por un integrante entonces guarda el registro que si lo vio
        if($request->has('usuarios')){
        foreach($request->usuarios as $usuario){
        Observaciones::updateOrCreate(
            ['identificador' => $usuario, 'solicitud_id' => $id],
            ['visto' => true]
        );
        }
        }
        return redirect()->route('solicitudes');
    }




    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion que retorna la vista que muestra al secretario la hoja membretada de los documentos que se elaboran,
    tambien podra cambiar el formato*/
    public function formato(){
        //se cargan los valores del formato actual
        $datospdf = Formato::findOrFail(1);  
        return view('Administrador.documentos.formato',compact('datospdf'));
    }




    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion que le muestra al secretario un ejemplo de como se veria el formato en un documento pdf
    public function vistaPrevia(Request $request){
        //formato del nuevo documento
        Formato::where('id',1)->update(['headtext' => $request->headtext]); 
        $datospdf = Formato::findOrFail(1);  
        //vista previa, solo hoja membretada     
        $pdf = PDF::loadView('layouts.formato.membreto',compact('datospdf'))->setPaper('carta','portrait');  
        return $pdf->stream('solicitud.pdf');
      }
    
    
    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion que cambia una imagen del formato de la hoja membretada
    public function cambiarFormato(Request $request){
        //si se cambia una imagen entonces se guarda
        if($request->hasFile('img_subida')){
        $dirimg=$request->file('img_subida')->store('formato','public');
        $datoFormato=request()->except(['_token','_method','img_subida','img']);
        $datoFormato[$request->img] = $dirimg;  
        Formato::where('id',1)->update($datoFormato);
        }
        return back();
    }
    
    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para eliminar una imagen del formato de la hoja membretada
    public function eliminarFormato(Request $request){
        $datoFormato=request()->except(['_token','_method','img']);
        $datoFormato[$request->img] = null;        
        Formato::where('id',1)->update($datoFormato);
        return back();
    }



    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion para guardar la respuesta de la solicitud que se da en la reunion por parte del administrador*/
    public function respuestaSolicitud(Request $request, $id){
        //se cargan los datos de la solicitud
        $solicitud =Solicitud::find($id);
        //se comprueba que la solicitud obtenga una respuesta el dia de reunion, no puede ser antes
        if($solicitud->calendario->start > hoy()){
            return back()->with('Error','No puedes generar recomendación antes de reunión');
        }
        if($request->respuesta){
        Recomendacion::updateOrCreate(
            ['id_solicitud' => $id],
            ['respuesta' => $request->respuesta, 'observaciones' => $request->observaciones]
        );
        //si la solicitud obtiene respuesta se notifica al usuario
        notificarSolicitante([
            'id_sol' => $id,'tipo' => 'respuesta_solicitud',
            'mensaje' => 'Inf. sobre solicitud','obs_coor' => '',
            'descripcion' => 'Tu solicitud ya ha sido revisada en la reunión de Comité Académico,mantente atent@ en esta paginá para conocer el proceso de tu solicitud y saber cuando tu dictamen obtenga una respuesta'
        ]);
        //se notifica al secretario y al subdirector
        notificar([
            'roles' => [1,8],'tipo' => 'recomendacion',
            'mensaje' => 'Recomendaciones pendientes',
            'descripcion' => 'Tienes recomendaciones pendientes que realizar'
        ]);
        return back()->with('Mensaje','Nueva recomendación generada');
        }
        return back();
    }



    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion para guardar los permisos que tienen los integrantes de las solicitudes que reciben por carrera y por adscripcion*/
    public function cambiarPermisos(Request $request){
        //usuario al que se le asignaran los permisos    
        $identificador=User::find($request->iduser)->identificador;
        //si los permisos ya habian sido dados antes, se eliminan y agregan los nuevos
        UserCarrera::where('identificador','=',$identificador)->delete();
        UserAdscripcion::where('identificador','=',$identificador)->delete();
        //carreras de las cuales recibira solicitudes
        $carreras=$request->multiple;
        if($request->multiple){
            foreach($carreras as $carrera){
                $uc = new UserCarrera;
                $uc->identificador=$identificador;
                $uc->carrera_id=$carrera;
                $uc->save();
            }
        }
        //adscripciones de las cuales recibira solicitudes
        $adscripciones=$request->multipled;
        if($request->multipled){
            foreach($adscripciones as $adsc){
                $uc = new UserAdscripcion;
                $uc->identificador=$identificador;
                $uc->adscripcion_id=$adsc;
                $uc->save();
            }
        }
        //se actualiza el rol en caso que lo cambie el administrador
        User::where('identificador',$identificador)->update(['role_id' => $request->role_id]);
        return back()->with('Mensaje','Cambios realizados correctamente');
    }




    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para mostrar al admistrador los permisos que tienen los integrantes sobre las solicitudes que reciben
    public function getCarreras(Request $request){
        if($request->ajax()){
            //se busca el usuario al que quiere ver
            $usu = User::find($request->usuario_id);
            //busca las carreras de las cuales recibe solicitudes el usuario
            $carreras = UserCarrera::where('identificador',$usu->identificador)->get();
            //adscripciones de las cuales recibe solicitudes
            $adscripciones = UserAdscripcion::where('identificador',$usu->identificador)->get();            
            return response()->json(['carreras' => $carreras, 'adscripciones' => $adscripciones, 'usuario' => $usu]);
        }
    }




    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion que retorna la vista donde el administrador puede ver los usuarios registrados, se puede
    filtrar por nombre, carrera, adscripcion y el tipo de usuario*/
    public function usuarios(Request $request,$rol){
        //datos para el filtrado
        $nombre = $request->get('nombre');
        $id = $request->get('carrera_id');
        $id = $request->get('adscripcion_id');
        //carrera por las cual puede filtrar
        $carreras = Carrera::all();
        $adscripciones = Adscripcion::where('tipo','carrera')->get();
        //roles que se muestran por si el administador quiere para cambiar el rol de un usuario
        $roles = Role::whereIn('id',[1,2,4,5,6,8])->get();
        //filtrar por el tipo de usuario
        if($rol == "integrante"){
            //Cuando se filtre por integrante se muestran los jefes,directo,subdirector y administrador
            $filtro = [1,2,5,8];
        }else{
            $filtro = Role::where('nombre_rol',$rol)->pluck('id');
        }
        $usuarios = User::whereIn('role_id',$filtro)
            ->nombre($nombre)
            ->carrera($id)
            ->adscripcion($id)
            ->paginate(5);
        return view('Administrador.usuarios',compact('usuarios','carreras','rol','adscripciones','roles'));    
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion que retorna la vista que tiene un formulario para actualizar los datos de un usuario*/
    public function editarUsuario($id){
        $usuario = User::find($id);
        if($usuario->esEstudiante()){
           $ads_carreras = Carrera::all();
        }else{
           $ads_carreras = Adscripcion::all();
        }
        return view('auth.edit_usuario',compact('usuario','ads_carreras'))->with('encabezado','layouts.encabezadoAdmin');
    }

    //acceso a la funcion solo para el administrador, validado en el constructor
    public function eliminarUsuario($id){
        User::destroy($id);
        return back()->with('Mensaje','Usuario eliminado correctamente');
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion que retorna la vista para registrar una solicitud,recomendacion o dictamen sin un registro previo de un usuario
    public function registrarDocumento(){
        $carreras = Carrera::all();
        $adscripciones = Adscripcion::where('tipo','carrera')->get();
        //se toman las ultimas dos reuniones pasadas y las dos mas proximas
        $pasadas = Calendario::whereDate('start','<',hoy())->orderBy('start','desc')->take(2)->get();
        $proximas = Calendario::whereDate('start','>=',hoy())->orderBy('start','asc')->take(2)->get()->reverse();
        return view('Administrador.generarDocumento',compact('carreras','adscripciones','pasadas','proximas'));
    }

    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion que guarda una solicitud,recomednacion o dictamen
    public function generarDocumento(Request $request){
        //si el usuario no existe en la base entonces se crea
        $usuario = User::updateOrCreate(
            ['identificador' => $request->identificador],
            ['nombre' => $request->nombre, 'apellido_paterno' => $request->apellido_paterno, 
             'apellido_materno' => $request->apellido_materno, 'sexo' => $request->sexo,
             'role_id' => $request->role_id, 'carrera_id' => $request->carrera_id, 
             'adscripcion_id' => $request->adscripcion_id,'password' => Hash::make('identificador')
             ]);
        $solicitud = Solicitud::create(
            ['asunto' => $request->asunto, 'motivos_academicos' => $request->motivos_academico, 'motivos_personales' => $request->motivos_personales, 
             'otros_motivos' => $request->otros_motivos, 'fecha' => $request->fecha, 'identificador' => $request->identificador, 'semestre' => $request->semestre, 
             'enviado' => true, 'enviadocoor' => true, 'carrera_profesor' => $request->carrera_profesor, 'calendario_id' => $request->calendario_id
             ]);

        //se genera el documento segun se especifique
        if($request->tipo_doc == 'solicitud'){
            $datospdf = Formato::findOrFail(1);
            $pdf = PDF::loadView('solicitante.pdfsolicitud',compact('solicitud','datospdf','usuario'))->setPaper('carta','portrait');
            return $pdf->download('solicitud.pdf');
        }

        if($request->tipo_doc == "recomendacion"){
            $recomendacion = Recomendacion::create(['num_recomendacion' => $request->num_recomendacion, 'num_oficio' => $request->num_oficio, 'fecha' => $request->fecha, 'respuesta' => $request->respuesta_rec, 'condicion' => $request->condicion, 'motivos' => $request->motivos, 'id_solicitud' => $solicitud->id]);
            return redirect()->route('recomendaciones')->with('Mensaje','Nueva recomendación registrada');
        }

        if($request->tipo_doc == "dictamen"){
            $recomendacion = Recomendacion::create(['id_solicitud' => $solicitud->id, 'respuesta' => $request->respuesta_dic, 'enviado' => true]);
            Dictamen::create(['recomendacion_id' => $recomendacion->id, 'num_oficio' => $request->num_oficio_dic, 'num_dictamen' => $request->num_dictamen, 'respuesta' => $request->respuesta_dic, 'anotaciones' => $request->anotaciones, 'fecha' => $request->fecha]);
            return redirect()->route('director.dictamenes','pendientes')->with('Mensaje','Nuevo dictamen registrado');;
        }
    }
   
}
