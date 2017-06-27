<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    protected $fillable = ['name'];

    //cache
    protected $mapIdByName = [
        'view' => 1,
        'play' => 2,
        'click' => 3,
    ];

    public function getAllIdByName()
    {
        return $this->mapIdByName;
    }
}