<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersDictamenes extends Model
{
    protected $fillable = [
        'identificador', 'dictamen_id', 'recibido',
    ];
    
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User','identificador','identificador');
    }
    public function dictamen(){
        return $this->belongsTo('App\Dictamen');
    }
}
