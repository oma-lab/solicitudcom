<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCarrera extends Model{
    protected $fillable = [
        'identificador', 'carrera_id',
    ];
    //
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User','identificador','identificador');
    }
    public function carrera(){
        return $this->belongsTo('App\Carrera');
    }

    public function ScopeObservaciones($query,$id,$carrera){
        return $query->where('carrera_id',$carrera)
                     ->leftJoin('observaciones',function($join) use ($id){
                       $join->on('observaciones.identificador','=','user_carreras.identificador')
                       ->where('observaciones.solicitud_id', '=', $id);
          });
    }

}
