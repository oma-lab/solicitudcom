<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitado extends Model{

    protected $fillable = [
        'nombre', 'puesto', 'lista_id',
    ];



    public function nombre_puesto(){
        return $this->nombre." ".$this->puesto;
    }
}
