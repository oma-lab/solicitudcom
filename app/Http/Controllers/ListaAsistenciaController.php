<?php

namespace App\Http\Controllers;

use App\ListaAsistencia;
use App\ListaUsuario;
use App\User;
use App\Calendario;
use App\Invitado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Formato;
use Barryvdh\DomPDF\Facade as PDF;

class ListaAsistenciaController extends Controller{
    public function __construct(){
        $this->middleware('auth');//middleware que valida que el usuario este autenticado
        $this->middleware('admin');//middleware que valida que el usuario sea administrador
    }
    

     //acceso a la funcion solo para el administrador, validado en el constructor
     //funcion que retorna la vista que muestra las listas registradas
    public function index(Request $request){
        $reunion = $request->get('fechareunion');//filtrado por fecha de reunión
        //listas registradas
        $listas = ListaAsistencia::join('calendarios','lista_asistencias.calendario_id','calendarios.id')
                                 ->select('lista_asistencias.*')
                                 ->when($reunion,function($query) use ($reunion){
                                     $query->whereDate('calendarios.start',$reunion);
                                 })
                                 ->orderBy('created_at','desc')
                                 ->paginate(5);
        //integrantes de comite academico los cuales deben aparecer en la lista de asistencia
        // 1=> secretario , 5=> jefes , 8=> subdirector
        $integrantes=User::whereIn('role_id',[1,5,8])->get();
        //se toman las ultimas tres reuniones pasadas
        $reuniones=Calendario::whereDate('start','<=',hoy())->orderBy('start','desc')->take(3)->get();
        return view('Administrador.verlistas',compact('listas','integrantes','reuniones'));        
    }

   

    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para guardar una lista
    public function store(Request $request){
        //valida que la lista de asistencia que se va a registrar no exista
        $la=ListaAsistencia::where('calendario_id',$request->calendario_id)->first();
        if(!$la){
        //se registra la lista
        $lista = ListaAsistencia::create(['calendario_id' => $request->calendario_id]);
        //guarda la asistencia,retardo,falta que tuvo el usuario en la reunion
        $usuarios =$request->identificador;
        for($j = 0;$j < count($usuarios); $j++){
            ListaUsuario::create([
                'lista_id' => $lista->id,
                'identificador' => $usuarios[$j],
                'observacion' => $request->asistencia[$j]
            ]);
        }
        //si hay invitados los registra en la lista
        if($request->has('invitados')){
        $nombres = $request->invitados;
        for($i = 0; $i < count($nombres); $i++){
            Invitado::create([
                'nombre' => $nombres[$i],
                'puesto' => $request->puestos[$i],
                'calendario_id' => $request->calendario_id,
                'lista_id' => $lista->id
            ]);
        }
        }
        return redirect()->route('listaasistencia.index')->with('Mensaje','Lista registrada correctamente');
        }else{
        return back()->with('Error','Lista con fecha ya existente, no se puede crear otra');
        }
    }


    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion que retorna la vista para poder editar una lista
    public function edit($id){
        $lista = ListaAsistencia::find($id);
        //usuarios que aparecen en la lista
        $listausuario = ListaUsuario::where('lista_id','=',$id)->get();
        //invitados que aparecen en la lista
        $invitados = Invitado::where('lista_id','=',$id)->get();
        return view('Administrador.editarLista',compact('lista','listausuario','invitados'));
    }

    


    //acceso a la funcion solo para el administrador, validado en el constructor  
    public function update(Request $request,$id){
        //valida si el secretario sube la lista firmada para guardarla
        if($request->hasFile('doc_firmado')){
            $archivolista = $request->file('doc_firmado')->store('listas','public');
            ListaAsistencia::where('id',$id)->update(['lista_archivo' => $archivolista]);
            return back()->with('Mensaje','Lista subida correctamente');
        } 
        //modifica los nombres de los invitados si se requiere
        $idinvi = $request->ids;//si no se mandan datos de los usuarios no entra en la condicion
        if(!empty($idinvi)){
        $nombreinv = $request->nombres;//nombres de los invitados
        $puestoinvi = $request->puestos;//puestos de los invitados
        for($aux = 0; $aux < count($idinvi); ++$aux){
            Invitado::where('id',$idinvi[$aux])->update(['nombre' => $nombreinv[$aux],'puesto' => $puestoinvi[$aux]]);
        }
        }
        //modifica la asistencia de los integrantes si se da el caso 
        $datos= $request->asistencia;
        $usuarios =$request->identificador;
        for($i=0; $i < count($usuarios); ++$i){
            ListaUsuario::where([['lista_id','=',$id],['identificador','=',$usuarios[$i]]])->update(['observacion' => $datos[$i]]);
        }
        return redirect()->route('listaasistencia.index')->with('Mensaje','Lista modificada correctamente');
    }

    

    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para eliminar una lista
    public function destroy($id){
        $lista=ListaAsistencia::find($id);
        ListaAsistencia::where('id','=',$id)->delete();
        return redirect()->route('listaasistencia.index',$id)->with('Mensaje','Lista eliminada');        
    }



    //acceso a la funcion solo para el administrador, validado en el constructor
    //funcion para mostrar una lista de asistencia en formato pdf
    public function verLista($id){
        $lista = ListaAsistencia::find($id);
        //invitados que asistieron a la reunion
        $invitados = Invitado::where('lista_id','=',$id)->get();
        //fecha de reunion
        $fecha= fechaLetraAnio($lista->calendario->start);
        //usuarios que apareceran en la lista
        $listaUsuarios = ListaUsuario::where('lista_id','=',$id)->get();
        //formato del documento
        $datospdf = Formato::findOrFail(1);  
        $pdflista = PDF::loadView('Administrador.listapdf',compact('listaUsuarios','fecha','invitados','datospdf'))->setPaper('carta','landscape');
        return $pdflista->stream('lista.pdf');
    }
}
