<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model{
    public $timestamps = false;

    protected $fillable = [
        'head1', 'head2', 'head3', 'headtext', 'body', 'pie1', 'pie2', 'pie3', 'pie4', 'pie5', 'pie6', 'pietext',
    ];
}
