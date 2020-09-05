<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarreraDepartamento extends Model{

    public $timestamps = false;

    protected $fillable = [
        'carrera_id', 'adscripcion_id',
    ];

    //
    public function carrera(){
        return $this->belongsTo('App\Carrera');
    }
    public function adscripcion(){
        return $this->belongsTo('App\Adscripcion');
    }
}
