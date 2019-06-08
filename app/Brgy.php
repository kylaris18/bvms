<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brgy extends Model
{
    protected $fillable = [
        'brgy_name',
        'brgy_address',
        'brgy_captain',
        'brgy_sk'
    ];
}
