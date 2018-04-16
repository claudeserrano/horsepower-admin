<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
    * Get the exam/score it belongs to.
    */
    public function score()
    {
        return $this->belongsTo('App\Score');
    }
}
