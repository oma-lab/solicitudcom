<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaUsuario extends Model{

    protected $fillable = [
        'lista_id', 'identificador', 'observacion',
    ];
    
    public $timestamps = false;
    public function user(){
        return $this->belongsTo('App\User','identificador','identificador');
    }
    public function lista(){
        return $this->belongsTo('App\ListaAsistencia','lista_id');
    }

    public function nombre_completo(){
        return $this->user->nombre_completo();
    }
    public function puesto(){
        return $this->user->puesto();
    }
    public function adscripcion(){
        return $this->user->adscripcion->nombre_adscripcion;
    }
}
