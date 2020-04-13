<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $fillable = [
        'name',
        'src_document',
        'status_document',
        'validity',
        'fk_users',
        'fk_documents_type'
    ];

    protected $hidden = [];
}
