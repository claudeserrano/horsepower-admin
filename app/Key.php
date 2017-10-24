<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'throttle', 'token', 'empid'
    ];

    public $timestamps = false;

}