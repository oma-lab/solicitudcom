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
use App\Acta;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class CitatorioController extends Controller{
    public function __construct(){
        $this->middleware('auth');//middleware que valida que el usuario este autenticado
        $this->middleware('admin');//middleware que valida que el usuario sea administrador
    }
    

    //acceso a la funcion solo para el administrador, validado en el constructor
    /*funcion que retorna la vista donde se muestran los citatorios registrados y un formulario
    para crear un citatorio*/
    public function index(Request $request){
        //citatorios registrados, ordenandolos del mas reciente al mas antiguo
        $reunion = $request->get('fechareunion');//filtrado por fecha
        $citatorios = Citatorio::join('actas',function($join){
                                $join->on('actas.calendario_id', '=', 'citatorios.calendario_id')
                                ->where('actas.titulo', '=', 'ordendia');
                                })
                                ->join('calendarios','citatorios.calendario_id','calendarios.id')
                                ->select('citatorios.*','actas.acta_file')
                                ->when($reunion,function($query) use ($reunion){
                                    $query->whereDate('calendarios.start',$reunion);
                                })
                                ->orderBy('citatorios.id','desc')->paginate(5);
        //jefes de departamento a los cuales se envio el citatorio
        $usuarios = User::whereIn('role_id',[5,8])->get();
        //se toman las ultimas 4 reuniones pasadas y la mas proxima
        $pasadas = Calendario::whereDate('start','<',hoy())->orderBy('start','desc')->take(4)->get();
        $proxima = Calendario::whereDate('start','>=',hoy())->orderBy('start','asc')->first();
        return view('Administrador.citatorio',compact('citatorios','usuarios','pasadas','proxima'));
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
        $citatorio = Citatorio::create([
            'fecha' => $request->fecha,
            'oficio' => $request->oficio,
            'calendario_id' => $request->calendario_id,
        ]);
        //si cambia el lugar y la hora de reunion entonces se actualizan los datos de reunion
        Calendario::where('id',$request->calendario_id)
                  ->update(['lugar' => $request->lugar, 'hora' => $request->hora]);

        $ordends = $request->ordens;
        $orden_dia = implode("--", $ordends);
        //fecha de reunion
        setlocale(LC_TIME, "es_MX.UTF-8"); //miercoles 20 de enero
        $fecha= Carbon::parse($citatorio->calendario->start)->formatLocalized('%A %d de %B');
        //formato del documento
        $datospdf = Formato::findOrFail(1);

        $ordenpdf = PDF::loadView('Administrador.pdforden',compact('citatorio','ordends','fecha','datospdf'))->setPaper('carta','portrait');
        $nombrearchivo='subidas/orden'.$citatorio->id.'.pdf';
        $ordenpdf->save(storage_path('app/public/'.$nombrearchivo));
        Acta::create([
            'titulo' => 'ordendia',
            'contenido' => $orden_dia,
            'calendario_id' => $request->calendario_id,
        ]); 

        return redirect()->route('citatorio.index')->with('Mensaje','Citatorio creado correctamente');
    }

    

    
    //acceso a la funcion solo para el administrador, validado en el constructor
    /**funcion para actualizar citatorio */
    public function update(Request $request,$id){
        //si guarda el archivo del citatorio en caso que lo suban
        if($request->hasFile('doc_firmado')){
            $citatorio = Citatorio::findOrFail($id);
            Storage::delete('public/'.$citatorio->archivo);
            $citatorio->archivo = $request->file('doc_firmado')->store('subidas','public');
            $citatorio->save();
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
        $cita = Citatorio::find($id);
        $acta = Acta::where([['titulo','=','ordendia'],['calendario_id','=',$cita->calendario_id]])->first();
        $acta->delete();
        $cita->delete();
        Storage::delete('public/subidas/orden'.$cita->id.'.pdf');
        Storage::delete('public/'.$cita->archivo);
        Storage::delete('public/'.$acta->acta_file);
        return back()->with('Mensaje','Citatorio y Orden del dia eliminado');
    }



    //acceso a la funcion solo para el administrador, validado en el constructor
    /**funcion que notifica a los integrantes sobre un nuevo citatorio*/
    public function enviar($id){
        $citatorio = Citatorio::findOrFail($id);
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

    public function enviarOrden($id){
        $orden = Acta::where([['titulo','=','ordendia'],['calendario_id','=',$id]])->firstOrFail();
        //se valida que el citatorio no ha sido enviado y que ya se ha subido el citatorio firmado
        if(!$orden->acta_file){return back()->with('Error','No es posible enviar,Falta Orden del dia firmada');}
        //se eliminan las notificaciones de la ultima orden del dia enviada
        Notificacion::where('tipo','=','ordendia')->delete();
        //se notifica a los jefes y subdirector sobre la  nueva orden del dia
        $citatorio = Citatorio::where('calendario_id','=',$id)->first();
        notificar([
            'citatorio' => $citatorio->id,
            'roles' => [5,8],
            'tipo' => 'ordendia',
            'mensaje' => 'Orden del dia',
            'descripcion' => 'Tiene una nueva orden del dia de reunión'
        ]);
        return back()->with('Mensaje','Orden del dia enviado');
    }




    //acceso a la funcion solo para el administrador, validado en el constructor
    /** funcion para mostrar al secretario quien ha visto el citatorio */
    public function getCitatorio(Request $request){
        if($request->ajax()){
            $vistos=Notificacion::where([['tipo','=','citatorio'],['citatorio_id','=',$request->id]])->get();
            return response()->json($vistos);
        }else{
            return redirect('/');
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

    public function updateOrden(Request $request,$id){
        //si guarda el archivo del citatorio en caso que lo suban
        if($request->hasFile('doc_firmado')){
            $orden=$request->file('doc_firmado')->store('subidas','public');
            Acta::where([['calendario_id','=',$id],['titulo','=','ordendia']])->update(['acta_file' => $orden]);
        }else{
            return back()->with('Error','No se subio ningun archivo, vuelva a intentar');
        }
        return back()->with('Mensaje','Orden del dia subido correctamente,ahora puede enviar');
    }

    
}
