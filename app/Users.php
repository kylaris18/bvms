<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = [
        'account_id',
        'user_fname',
        'user_lname',
        'user_contactno',
        'user_photo'
    ];
}
