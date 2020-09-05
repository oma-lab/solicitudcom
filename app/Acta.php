<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acta extends Model{

    protected $fillable = [
        'titulo', 'contenido', 'calendario_id'
    ];
    //
    public function calendario(){
        return $this->belongsTo('App\Calendario');
    }

    public function fecha(){
        return $this->calendario->start;
    }
}
