<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
    * Get the guest's scores
    */
    public function scores()
    {
        return $this->hasMany('App\Score');
    }

    /**
    * Get the guest's information
    */
    public function information()
    {
        return $this->hasOne('App\Information');
    }

    /**
    * Get the guest's bf.
    */
    public function bf()
    {
        return $this->hasOne('App\Bf');
    }

    /**
    * Get the guest's bf.
    */
    public function union()
    {
        return $this->hasOne('App\Union');
    }

    /**
    * Get the guest's dependents
    */
    public function dependents()
    {
        return $this->hasMany('App\Dependent');
    }

    /**
    * Get the guest's dependents
    */
    public function beneficiaries()
    {
        return $this->hasMany('App\Beneficiary');
    }
}
