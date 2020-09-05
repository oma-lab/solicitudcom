<?php

namespace App\Http\Controllers;

use App\Acta;
use App\Calendario;
use App\Solicitud;
use App\Recomendacion;
use App\ListaAsistencia;
use App\ListaUsuario;
use App\Invitado;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ActaController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');//middleware que valida que el usuario este autenticado
        $this->middleware('admin');//middleware que valida que el usuario sea administrador
    }
    

    //acceso a la funcion solo para el administrador, validado en el constructor
    public function index(){
        //ultimas 3 reuniones pasadas 
        $reunion=Calendario::whereDate('start','<=',hoy())->orderBy('start','desc')->take(3)->get();
        //actas registradas que podra ver el administrador
        $actas = Acta::orderBy('created_at','desc')->paginate(5);
        return view('Administrador.acta',compact('reunion','actas'));
    }



    //acceso a la funcion solo para el administrador, validado en el constructor
    public function create(Request $request){
        //reunión 
        $reunion=Calendario::find($request->calendario_id);
        //valida que el acta no exista para no ser generada de nuevo
        $act = Acta::where('calendario_id','=',$reunion->id)->first();
        if($act){
        return back()->with('Error','Acta ya existente con fecha introducida, imposible crear mas de 1 acta con la misma fecha');
        }
        //comprueba que exista una lista de asistencia con la fecha dada
        $lista = ListaAsistencia::where('calendario_id','=',$reunion->id)->first();      
        if(!$lista){
        return back()->with('Error','Lista de asistencia con la fecha '.fecha($reunion->start).' no encontrada');
        }
        //solicitudes realizadas para la reunion de la fecha dada
        $solicitudes = Solicitud::where('calendario_id','=',$reunion->id)->get();
        $fechauno= fechaLetra($solicitudes->min('created_at'));//fecha cuando se registro la primera solicitud
        $fechados= fechaLetra($solicitudes->min('created_at'));//fecha cuando se registro la ultima solicitud
        //Obtener todas las recomendaciones que se realizaron en la reunion con la fecha dada
        $recomendaciones = Recomendacion::join('solicituds','recomendacions.id_solicitud','=','solicituds.id')
                                        ->where('solicituds.calendario_id','=',$reunion->id)
                                        ->get();
        //usuarios presentes en la reunion, solo los que se marcaron como asistencia
        $asistentes = ListaUsuario::join('users','lista_usuarios.identificador','=','users.identificador')
                                  ->where('lista_usuarios.lista_id',$lista->id)
                                  ->where('lista_usuarios.observacion','ASISTENCIA')
                                  ->where('users.role_id','!=',8)
                                  ->get();
        //invitados que asistieron a la reunion
        $invitados = Invitado::where('lista_id','=',$lista->id)->get();
        //retornar la vista con los datos que requiere el acta para ser creada
        return view('Administrador.crearActa',compact('reunion','asistentes','recomendaciones','invitados','fechauno','fechados'));
        }

  
    //acceso a la funcion solo para el administrador, validado en el constructor    
    public function store(Request $request){
        //se crea el acta con los datos recibidos
        Acta::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'calendario_id' => $request->calendario_id,
        ]); 
        return redirect()->route('acta.index');
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    public function edit($id){
        //acta que se va a editar
        $acta = Acta::find($id);
        return view('Administrador.editarActa',compact('acta'));
    }

  
    //acceso a la funcion solo para el administrador, validado en el constructor
    public function update(Request $request,$id){
        $datosActa=request()->except('_token','_method','doc_firmado');
        if($request->hasFile('doc_firmado')){
            //si se sube el archivo se guarda
            $datosActa['acta_file']=$request->file('doc_firmado')->store('subidas','public');
        }
        //actualiza el acta con los datos recibidos
        Acta::where('id',$id)->update($datosActa);  
        return redirect()->route('acta.index');        
    }

    
    //acceso a la funcion solo para el administrador, validado en el constructor
    public function destroy($id){
        //eliminar acta
        Acta::destroy($id);
        return back()->with('Mensaje','Acta eliminada correctamente');
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    public function descargarActa($id){
        //datos del acta
        $acta = Acta::find($id);
        //nl2br respeta los saltos de linea que se dieron en el formulario
        $contenido= nl2br($acta->contenido);
        //lista de las personas que asistieron a la reunion
        $lista = ListaAsistencia::where('calendario_id','=',$acta->calendario_id)->first();
        $asistentes = ListaUsuario::where('lista_id','=',$lista->id)->where('observacion','=','ASISTENCIA')->get();
        //invitados que asistieron a la reunion
        $invitados = Invitado::where('lista_id','=',$lista->id)->get();
        //se genera el pdf con los datos del acta y se muestra
        $pdf = PDF::loadView('Administrador/actapdf',compact('acta','contenido','asistentes','invitados'))->setPaper(array(0,0,609.4488,878.74), 'portrait');
        return $pdf->stream('acta.pdf');
    }
}
