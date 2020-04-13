<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localities extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected  $fillable = [
        'name',
        'zip_code',
        'tipo_asentamiento',
        'city',
        'zona',
        'clave_ciudad',
        'fk_municipalities'
        ];
}
