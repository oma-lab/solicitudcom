<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dictamen extends Model{
    public $timestamps = false;
    protected $fillable = [
        'recomendacion_id', 'num_oficio', 'num_dictamen', 'respuesta', 'anotaciones', 'fecha', 'dictamen_firmado', 'enviado', 'entregado', 'entregadodepto'];

    public function recomendacion(){
        return $this->belongsTo('App\Recomendacion');
    }

    public function perteneceDocente(){
        if($this->recomendacion->solicitud->user->role->nombre_rol == 'docente'){
            return true;
        }
        return false;
    }
    public function perteneceEstudiante(){
        if($this->recomendacion->solicitud->user->role->nombre_rol == 'estudiante'){
            return true;
        }
        return false;
    }
    public function asunto(){
        return $this->recomendacion->solicitud->asunto;
    }
    public function usuario(){
        return $this->recomendacion->solicitud->user;
    }
    public function adscripcion(){
        return $this->recomendacion->solicitud->user->adscripcion_id;
    }
    public function carrera(){
        return $this->recomendacion->solicitud->user->carrera_id;
    }
    public function solicitud(){
        return $this->recomendacion->solicitud;
    }
}
