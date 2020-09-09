<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model{
    protected $fillable = [
        'asunto', 'motivos_academicos', 'motivos_personales', 'otros_motivos', 'evidencias', 'solicitud_firmada', 'observaciones', 'fecha', 'identificador', 'semestre', 'enviado', 'enviadocoor', 'carrera_profesor','calendario_id',
    ];
    //
    public function user(){
        return $this->belongsTo('App\User','identificador','identificador');
    }

    public function recomendacion(){
        return $this->hasOne('App\Recomendacion','id_solicitud');
    }

    public function dictamen(){
        if(isset($this->recomendacion->dictamen)){
            return $this->recomendacion->dictamen;
        }else{
            return false;
        }
    }

    public function recomendacion_enviada(){
        if(isset($this->recomendacion)){
            return $this->recomendacion->enviado;
        }else{
            return false;
        }
    }

    public function dictamen_enviado(){
        if(isset($this->recomendacion->dictamen)){
            return $this->recomendacion->dictamen->enviado;
        }else{
            return false;
        }
    }
    
    
    public function calendario(){
        return $this->belongsTo('App\Calendario');
    }


    public function carrera(){
        if($this->user->esDocente()){
            return $this->carrera_profesor;
        }
        return $this->user->carrera->nombre;
    }

    public function motivos_academicos(){
        return ($this->motivos_academicos) ? $this->motivos_academicos : "ninguno";
    }
    public function motivos_personales(){
        return ($this->motivos_personales) ? $this->motivos_personales : "ninguno";
    }
    public function otros_motivos(){
        return ($this->otros_motivos) ? $this->otros_motivos : "ninguno";
    }

}
