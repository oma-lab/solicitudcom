<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use App\Recomendacion;
use App\UserCarrera;
use App\UserAdscripcion;
use App\Observaciones;
use App\Carrera;
use App\Citatorio;
use App\Notificacion;
use Carbon\Carbon;

use App\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        /*middleware para validar que el usuario este autenticado*/
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        //acceso para usuarios autenticados
        $user = Auth::user();
        //metodo para redigir al usuario a su vista principal cuando inicia sesion
        if($user->esAdmin()){
            return redirect()->route('solicitudes');
        }
        if($user->esSolicitante()){
            return redirect()->route('solicitante.home');
        }
        if($user->esJefeSub()){
            //la ruta que retorna hace el filtrado de las solicitudes recibidas
            //el parametro indica que se filtraran por solicitudes no revisadas por el jefe
          return redirect()->route('jefe.solicitudes','pendientes');
        }
        if($user->esDirector()){
            return redirect()->route('director.dictamenes','pendientes');
        }
        if($user->esCoor()){
            return redirect()->route('coordinador.solicitudes','pendientes');    
        }
        back();
    }

}
