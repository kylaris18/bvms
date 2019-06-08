<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $fillable = [
        'account_uname',
        'account_password',
        'account_type',
        'account_suspend'
    ];
}
