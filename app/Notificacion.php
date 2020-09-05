<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model{
    protected $fillable = [
        'identificador', 'tipo', 'solicitud_id', 'citatorio_id', 'mensaje', 'descripcion', 'observacion', 'num', 'visto',
    ];


    public function user(){
        return $this->belongsTo('App\User','identificador','identificador');
    }

}
