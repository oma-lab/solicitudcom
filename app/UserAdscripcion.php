<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdscripcion extends Model{
    protected $fillable = [
        'identificador', 'adscripcion_id',
    ];
    //
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User','identificador','identificador');
    }
    public function adscripcion(){
        return $this->belongsTo('App\Adscripcion');
    }

    public function ScopeObservaciones($query,$id,$adscripcion){
        return $query->where('adscripcion_id',$adscripcion)
                     ->leftJoin('observaciones',function($join) use ($id){
                       $join->on('observaciones.identificador','=','user_adscripcions.identificador')
                       ->where('observaciones.solicitud_id', '=', $id);
          });
    }
}
