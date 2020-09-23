<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];
}
