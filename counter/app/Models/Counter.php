<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'counter',
        'date',
        'event_id',
        'country_id',
    ];

}