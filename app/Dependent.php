<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
    * Get the guest associated to the dependent.
    */
    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }
}
