<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipalities extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected  $fillable = [
        'fk_states',
        'clave',
        'name',
        ];
}
