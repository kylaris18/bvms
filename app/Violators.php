<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violators extends Model
{
    protected $fillable = [
        'violator_lname',
        'violator_fname',
        'violator_mname',
        'violator_count'
    ];
}
