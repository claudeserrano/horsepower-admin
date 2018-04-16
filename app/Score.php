<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
 	/**
    * Get the guest.
    */
    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }

 	/**
    * Get the answers for this exam/score.
    */
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
