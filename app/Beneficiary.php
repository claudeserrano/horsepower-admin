<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

	protected $table = 'beneficiaries';

    /**
    * Get the guest associated to the beneficiary.
    */
    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }
}
