<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bf extends Model
{

	protected $fillable = ['guest_id', 'Status', 'HireDate', 'DateMarried','PlaceMarried','DateDivorced','CourtOrder','SpouseEmployer','SpouseEmployerAddress','SpouseDateHired','SpouseEmployerNumber', 'Signature'];
    /**
    * Get the guest's scores
    */
    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }
    
}
