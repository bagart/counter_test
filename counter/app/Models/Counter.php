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
    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}