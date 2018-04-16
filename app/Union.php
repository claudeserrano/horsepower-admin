<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{

    	protected $fillable = ['guest_id', 'WorkPhone', 'DateHired', 'PrimaryType', 'PrimaryName', 'PrimaryRel', 'PrimaryAddress', 'SecondaryType', 'SecondaryName', 'SecondaryRel', 'SecondaryAddress', 'TertiaryType', 'TertiaryName', 'TertiaryRel', 'TertiaryAddress', 'Signature'];

    	/**
        * Get the guest's scores
        */
        public function guest()
        {
            return $this->belongsTo('App\Guest');
        }

}
