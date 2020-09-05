<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
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
        ],$messages = [
            'required' => 'Este campo es requerido',
            'identificador.min' => 'El identificador debe tener minimo 12 caracteres',
            'identificador.unique' => 'Ya existente,no es posible volver a registrar',
            'apellido_paterno.min' => 'El apellido debe tener mas de 3 letras',
            'apellido_materno.min' => 'El apellido debe tener mas de 3 letras',
            'email.email' => 'Este no es un correo valido',
            'confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener minimo 6 caracteres'
        ]);        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
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
            \App\UserCarrera::create(['identificador' => $request['identificador'],'carrera_id' => $cr,]);
            }
        }
        if($request->adscs){
            $adscripciones = $request->adscs;
            foreach($adscripciones as $ad){
            \App\UserAdscripcion::create(['identificador' => $request['identificador'],'adscripcion_id' => $ad,]);
            }
        }
        return back()->with('Mensaje','Usuario agregado correctamente');
    }


    /*acceso solo para el administrador, validado en el constructor*/
    public function crear(){
        $datosadscripcion = \App\Adscripcion::all();
        //funcion para que el secretario registre ,jefes,subdirector,coordinador y director
        $roles = \App\Role::whereNotIn('id',[3,4,7,9,10])->get();
        $carreras = \App\Carrera::all();
        $adscripciones= \App\Adscripcion::where('tipo','carrera')->get();
        return view('Administrador.crear_usuarios',compact('datosadscripcion','roles','carreras','adscripciones'));
    }
}
