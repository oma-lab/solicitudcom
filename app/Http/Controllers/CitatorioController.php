<?php

namespace App\Http\Controllers;

use App\Citatorio;
use Illuminate\Http\Request;
use App\Calendario;
use Carbon\Carbon;
use App\User;
use App\Notificacion;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCitatorio;
use Illuminate\Support\Facades\Auth;
use App\Formato;
use Barryvdh\DomPDF\Facade as PDF;

class CitatorioController extends Controller{
    public function __construct(){
        $this->middleware('auth');//middleware que valida que el usuario este autenticado
        $this->middleware('admin');//middleware que valida que el usuario sea administrador
    }
    

    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion que retorna la vista donde se muestran los citatorios registrados y un formulario
    para crear un citatorio*/
    public function index(){
        //citatorios registrados, ordenandolos del mas reciente al mas antiguo
        $citatorios = Citatorio::orderBy('id','desc')->paginate(5);
        //jefes de departamento a los cuales se envio el citatorio
        $usuarios = User::whereIn('role_id',[5,8])->get();
        //reunion mas cercana, la cual sirve para generar el citatorio, no se podran realizar citatorios de los cuales la fecha de reunion ya ha pasado
        $reunion=Calendario::whereDate('start','>=',hoy())->orderBy('start','asc')->first();
        return view('Administrador.citatorio',compact('reunion','citatorios','usuarios'));
    }


    
    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion para registrar un nuevo citatorio*/
    public function store(Request $request){
        //se valida que el citatorio no se registre con una fecha de reunion ya existente
        $cit=Citatorio::where('calendario_id','=',$request->calendario_id)->first();
        if($cit){
            return redirect()->route('citatorio.index')->with('Error','Imposible crear citatorio, por que ya existe citatorio con la fecha indicada');
        }
        //si el citatorio no existe entonces se crea
        Citatorio::create([
            'fecha' => $request->fecha,
            'oficio' => $request->oficio,
            'calendario_id' => $request->calendario_id,
        ]);
        //si cambia el lugar y la hora de reunion entonces se actualizan los datos de reunion
        Calendario::where('id',$request->calendario_id)
                  ->update(['lugar' => $request->lugar, 'hora' => $request->hora]);

        return redirect()->route('citatorio.index')->with('Mensaje','Citatorio creado correctamente');
    }

    

    
    //acceso a la funcion solo para el administrador, validado en el constructor
    /**funcion para actualizar citatorio */
    public function update(Request $request,$id){
        //si guarda el archivo del citatorio en caso que lo suban
        if($request->hasFile('doc_firmado')){
            $cita=$request->file('doc_firmado')->store('subidas','public');
            Citatorio::where('id','=',$id)->update(['archivo' => $cita]);
        }else{
            $datosCitatorio = request()->except(['_token','_method','doc_firmado']);
            //se actualiza el citatorio con los datos recibidos
            Citatorio::where('id','=',$id)->update($datosCitatorio);
        }
        return redirect()->route('citatorio.index')->with('Mensaje','Citatorio subido correctamente,ahora puede enviar');
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    /** metodo para que el administrador pueda eliminar un citatorio*/
    public function destroy($id){
        Citatorio::destroy($id);
        return back()->with('Mensaje','Citatorio eliminado');
    }



    //acceso a la funcion solo para el administrador, validado en el constructor
    /**funcion que notifica a los integrantes sobre un nuevo citatorio*/
    public function enviar($id){
        $citatorio = Citatorio::find($id);
        //se valida que el citatorio no ha sido enviado y que ya se ha subido el citatorio firmado
        if(!$citatorio->archivo){return back()->with('Error','No es posible enviar,Falta citatorio firmado');}
        if($citatorio->enviado){return back()->with('Error','No es posible enviar de nuevo');}
        //se eliminan las notificaciones del ultimo citatorio enviado
        Notificacion::where('tipo','=','citatorio')->delete();
        //Se actualiza el citatorio que ya ha sido enviado
        $citatorio->update(['enviado' => true]);
        //se notifica a los jefes y subdirector sobre el nuevo citatorio
        notificar([
            'citatorio' => $id,
            'roles' => [5,8],
            'tipo' => 'citatorio',
            'mensaje' => 'Citatorio de reunión',
            'descripcion' => 'Tiene un nuevo citatorio de reunión, marque que ha sido recibido'
        ]);
        return back()->with('Mensaje','Citatorio enviado');
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    /** funcion para mostrar al secretario quien ha visto el citatorio */
    public function getCitatorio(Request $request){
        if($request->ajax()){
            $vistos=Notificacion::where([['tipo','=','citatorio'],['citatorio_id','=',$request->id]])->get();
            return response()->json($vistos);
        }
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    /** funcion para generar y mostrar el pdf del citatorio */
    public function citatorioPdf($id){
        //se cargan los datos del citatorio
        $citatorio = Citatorio::findOrFail($id);
        //fecha de reunion
        setlocale(LC_TIME, "es_MX.UTF-8"); //miercoles 20 de enero
        $fecha= Carbon::parse($citatorio->calendario->start)->formatLocalized('%A %d de %B');
        //formato del documento
        $datospdf = Formato::findOrFail(1);
        $pdf = PDF::loadView('Administrador.pdfcitatorio',compact('citatorio','fecha','datospdf'))->setPaper('carta','portrait');  
        return $pdf->stream('citatorio.pdf');
    }
}
