<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model{
    public $timestamps = false;
    
    protected $fillable = [
        'title', 'start', 'hora', 'color', 'descripcion', 'lugar',
    ];
    //
}
