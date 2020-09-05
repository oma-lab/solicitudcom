<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citatorio extends Model{
    public $timestamps = false;

    protected $fillable = [
        'fecha', 'oficio', 'archivo', 'enviado', 'calendario_id',
    ];

    public function calendario(){
        return $this->belongsTo('App\Calendario');
    }

    public function fecha(){
        return $this->calendario->start;
    }

    public function reunion(){
        return $this->calendario->title;
    }



}
