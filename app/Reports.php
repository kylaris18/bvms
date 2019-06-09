<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $fillable = [
        'account_id',
        'violator_id',
        'report_path',
        'report_date'
    ];
}
