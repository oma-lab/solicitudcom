<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model{
    public $timestamps = false;

    protected $fillable = [
        'id', 'num_recomendacion', 'num_oficio', 'fecha', 'respuesta', 'condicion', 'observaciones', 'motivos', 'archivo', 'enviado', 'id_solicitud',
    ];




    public function solicitud(){
        return $this->belongsTo('App\Solicitud','id_solicitud');
    }

    public function dictamen(){
        return $this->hasOne('App\Dictamen');
    }


    public function usuario(){
        return $this->solicitud->user;
    }
    public function asunto(){
        return $this->solicitud->asunto;
    }
    public function condicionado(){
        return ($this->condicion) ? $this->condicion."," : ""; 
    }


}


