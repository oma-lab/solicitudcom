<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adscripcion extends Model{
    protected $fillable = [
        'nombre_adscripcion', 'tipo',
    ];

    //---------------------------------------------------
    public function del(){
        //de la division de estudios profesionales
        if($this->id == 11){
            return "de la";
        }else{
        //del departamento de..    
            return "del";
        }
    }

    //--------------------------------------------------------------
}



