<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaAsistencia extends Model{

    protected $fillable = [
        'lista_archivo', 'calendario_id',
    ];
    
    public function calendario(){
        return $this->belongsTo('App\Calendario');
    }

    public function scopeFecha($query, $fecha){
        if($fecha){
            return $query->where('calendario_id','=',$fecha);
        }    
    }
}
