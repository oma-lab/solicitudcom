<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\RestablecerContrasenaUsuario;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identificador', 'nombre', 'apellido_paterno', 'apellido_materno', 'sexo', 'celular', 'telefono', 'grado', 'carrera_id', 'adscripcion_id', 'role_id', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($username){
        return $this->where('identificador', $username)->first();
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new RestablecerContrasenaUsuario($token));
    }



    public function role(){
        return $this->belongsTo('App\Role');
    }    
    public function carrera(){
        return $this->belongsTo('App\Carrera');
    }
    public function adscripcion(){
        return $this->belongsTo('App\Adscripcion');
    }

    public function esAdmin(){
        if($this->role->nombre_rol == 'administrador' || $this->role->nombre_rol == 'superusuario'){
            return true;
        }
        return false;
    }
    public function esSolicitante(){
        if($this->role->nombre_rol == 'estudiante' || $this->role->nombre_rol == 'docente' || $this->role->nombre_rol == 'depto'){
            return true;
        }
        return false;
    }
    public function esCoor(){
        if($this->role->nombre_rol == 'coordinador'){
            return true;
        }
        return false;
    }
    public function esJefeSub(){
        if($this->role->nombre_rol == 'jefe' || $this->role->nombre_rol == 'subdirector'){
            return true;
        }
        return false;
    }
    public function esDirector(){
        if($this->role->nombre_rol == 'director'){
            return true;
        }
        return false;
    }
    public function esJefe(){
        if($this->role->nombre_rol == 'jefe'){
            return true;
        }
        return false;
    }
    public function esIntegrante(){
        if($this->adscripcion->tipo == 'administrativo'){
            return true;
        }
        return false;
    }
    public function esSub(){
        if($this->role->nombre_rol == 'subdirector'){
            return true;
        }
        return false;
    }
    public function esEstudiante(){
        if($this->role->nombre_rol == 'estudiante'){
            return true;
        }
        return false;
    }
    public function esDocente(){
        if($this->role->nombre_rol == 'docente'){
            return true;
        }
        return false;
    }
    public function esDepto(){
        if($this->role->nombre_rol == 'depto'){
            return true;
        }
        return false;
    }
    //-------------------------------------------------


    //-------------------------------------
    //view/jefe/solicitudesRecibidas
    public function nombre_completo(){
        return $this->nombre." ".$this->apellido_paterno." ".$this->apellido_materno;
    }

    public function puesto_presidente(){
        return $this->presidente()." del comité académico";
    }

    public function puesto(){
        if($this->esSub()){
            return ($this->sexo == 'H') ? "subdirector académico" : "subdirectora académica";
        }
        if($this->esDirector()){
            return ($this->sexo == 'H') ? "director" : "directora";
        }
        if($this->esAdmin()){
            return $this->puesto_secretario_comite();
        }
        if($this->esJefe()){
            if($this->sexo == 'H'){
                return "jefe ".$this->adscripcion->del()." ".$this->adscripcion->nombre_adscripcion;
            }else{
                return "jefa ".$this->adscripcion->del()." ".$this->adscripcion->nombre_adscripcion;
            }
        }
    }
    public function puesto_secretario_comite(){
        return ($this->sexo == 'H') ? "secretario del comité académico" : "secretaria del comité académico";
    }
    public function grado_nombre_puesto(){
        return $this->grado." ".$this->nombre_completo().", ".$this->puesto();
    }
    public function presidente(){
        return ($this->sexo == 'H') ? "presidente" : "presidenta";
    }
    public function el(){
        return ($this->sexo == 'H') ? "el" : "la";
    }
    public function del(){
        return ($this->sexo == 'H') ? "del" : "de la";
    }
    public function el_interesado(){
        return ($this->sexo == 'H') ? "el interesado" : "la interesada";
    }
    public function del_interesado(){
        return ($this->sexo == 'H') ? "del interesado" : "de la interesada";
    }
    public function sabedor(){
        return ($this->sexo == 'H') ? "Sabedor" : "Sabedora";
    }
    public function adscrito(){
        return ($this->sexo == 'H') ? "adscrito" : "adscrita";
    }
    public function iniciales(){
        return implode('', array_map(function($v) { return $v[0]; }, explode(' ', trim($this->nombre_completo())))); 
    }
    public function tipo_id(){
        if($this->esEstudiante()){
            return "N° de control";
        }else{
            return ($this->esDocente()) ? "RFC" : "Usuario";
        }
    }
    public function tipo_carrera_adscripcion(){
        return ($this->esEstudiante()) ? "Carrera" : "Adscripción";
    }
    //view/jefe/solicitudesRecibidas
    public function carrera_adscripcion(){
        return ($this->esEstudiante()) ? $this->carrera->nombre : $this->adscripcion->nombre_adscripcion;
    }
    public function solicitante(){
        if($this->esEstudiante()){
            return "Estudiante";
        }elseif($this->esDocente()){
            return ($this->sexo == "H") ? "profesor" : "profesora";
        }else{
            return "Departamento";
        }
    }
    public function solicitantes(){
        if($this->esEstudiante()){
            return "Estudiantes";
        }else{
            return ($this->sexo == "H") ? "profesor" : "profesora";
        }
    }
    public function delSolicitante(){
        if($this->esEstudiante()){
            return "del estudiante";
        }elseif($this->esDocente()){
            return ($this->sexo == 'H') ? "del profesor" : "de la profesora";
        }else{
            return "";
        }
    }
    public function nombre_adscripcion(){
        return $this->adscripcion->nombre_adscripcion;
    }
    public function nombre_carrera(){
        return $this->carrera->nombre;
    }
    public function departamento(){
        if($this->esEstudiante()){
            $depto = \App\CarreraDepartamento::where('carrera_id','=',$this->carrera_id)->first();
        return $depto->adscripcion->nombre_adscripcion;
        }else{
            return $this->adscripcion->nombre_adscripcion;
        }
    }

    public function usuario_tipo(){
        if($this->esSolicitante()){
            return "Interesado";
        }
        if($this->esJefe()){
            return $this->adscripcion->nombre_adscripcion;
        }
        if($this->esCoor()){
            return "Coordinación de la carrera";
        }
    }





    //------------------------------------------------------


    public function scopeNombre($query, $nombre){
        if($nombre){
            return $query->where('nombre','LIKE',"%$nombre%")
                         ->orWhere('apellido_paterno','LIKE',"%$nombre%")
                         ->orWhere('apellido_materno','LIKE',"%$nombre%");
        }   
    }
    public function scopeIdentificador($query, $identificador){
        if($identificador){
            return $query->where('identificador','LIKE',"%$identificador%");
        }    
    }
    public function scopeRole($query, $roleid){
        if($roleid){
            return $query->where('role_id','LIKE',"%$roleid%");
        }
    }   
    public function scopeCarrera($query, $id){
        if($id){
            return $query->where('carrera_id','=',$id);
        }    
    }
    public function scopeCarreras($query, $ids){
        if($ids){
            return $query->whereIn('carrera_id',$ids);
        }    
    }
    public function scopeAdscripcion($query, $id){
        if($id){
            return $query->where('adscripcion_id','=',$id);
        }    
    }
   
}
