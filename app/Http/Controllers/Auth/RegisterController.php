<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserCarrera;
use App\UserAdscripcion;
use App\Role;
use App\Carrera;
use App\Adscripcion;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
class RegisterController extends Controller{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest', ['except' => ['registrar','crear']]);
        $this->middleware('admin', ['only' => ['registrar','crear']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'identificador' => ['required', 'string', 'min:8', 'unique:users'],
            'nombre' => ['required', 'string', 'min:3', 'max:20'],
            'apellido_paterno' => ['required', 'string', 'min:3', 'max:20'],
            'sexo' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],           
        ]);        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

     //funcion que es llamada para crear un nuevo usuario
    protected function create(array $data){
        $nombre = ucwords(mb_strtolower($data['nombre']));
        $apellidop = ucwords(mb_strtolower($data['apellido_paterno']));
        $apellidom = ucwords(mb_strtolower($data['apellido_materno']));
        return User::create([
            'identificador' => $data['identificador'],
            'nombre' => $nombre,
            'apellido_paterno' => $apellidop,
            'apellido_materno' => $apellidom,
            'grado' => $data['grado'],
            'sexo' => $data['sexo'],
            'celular' => $data['celular'],
            'telefono' => $data['telefono'],
            'carrera_id' => $data['carrera_id'],
            'adscripcion_id' => $data['adscripcion_id'],
            'role_id' => $data['role_id'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    /*acceso solo para el administrador, validado en el constructor*/
    public function registrar(Request $request){
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());

        //permisos que le da el secretario al usuario sobre las solicitudes que recibira
        if($request->carrs){
            $carreras = $request->carrs;
            foreach($carreras as $cr){
            UserCarrera::create(['identificador' => $request['identificador'],'carrera_id' => $cr,]);
            }
        }
        if($request->adscs){
            $adscripciones = $request->adscs;
            foreach($adscripciones as $ad){
            UserAdscripcion::create(['identificador' => $request['identificador'],'adscripcion_id' => $ad,]);
            }
        }
        return back()->with('Mensaje','Usuario agregado correctamente');
    }


    /*acceso solo para el administrador, validado en el constructor*/
    public function crear(){
        $datosadscripcion = Adscripcion::all();
        //funcion para que el secretario registre ,jefes,subdirector,coordinador y director
        $roles = Role::whereNotIn('id',[3,4,7,9,10])->get();
        $carreras = Carrera::all();
        $adscripciones= Adscripcion::where('tipo','carrera')->get();
        return view('Administrador.crear_usuarios',compact('datosadscripcion','roles','carreras','adscripciones'));
    }

    //Registro de estudiante
    public function showRegistrationForm(){
        $rol = 3;
        $carreras = Carrera::all();
        return view('auth.register',compact('carreras','rol'));
    }

    //Registro de docente
    public function registrarDocente(){
        $rol = 4;
        $adscripciones = Adscripcion::where('tipo','=','carrera')->get();
        return view('auth.register',compact('adscripciones','rol'));
    }

}
