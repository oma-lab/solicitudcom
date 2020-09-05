<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asunto extends Model{
    public $timestamps = false;

    protected $fillable = [
        'asunto', 'descripcion', 'ejemplo',
    ];
}
