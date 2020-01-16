<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
        'last_name',
        'second_last_name',
        'rfc',
        'curp',
        'email',
        'password',
        'user_type',
        'genders',
        'telephone',
        'api_token',
        'fk_localities',
        'fk_user_status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
}
