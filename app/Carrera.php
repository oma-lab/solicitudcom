<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model{
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
    ];
    //
    public function user(){
        return $this->hasOne('App\User');
    }

    public function carrera_nombre(){
        return $this->carrera_nombre;
    }
}
