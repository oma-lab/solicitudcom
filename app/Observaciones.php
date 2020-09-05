<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model{
    public $timestamps = false;
    protected $fillable = [
        'identificador', 'solicitud_id', 'voto', 'descripcion', 'visto',
    ];
    //
    public function solicitud(){
        return $this->belongsTo('App\Solicitud');
    }
    public function user(){
        return $this->belongsTo('App\User','identificador','identificador');
    }
}
