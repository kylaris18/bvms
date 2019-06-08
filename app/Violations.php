<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violations extends Model
{
    protected $fillable = [
        'type_id',
        'account_id',
        'violation_violator',
        'violation_date',
        'violation_status',
        'violation_notes',
        'violation_report',
        'violation_photo'
    ];
}
