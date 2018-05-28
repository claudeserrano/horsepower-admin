<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{

	protected $table = 'informations';
    
	protected $fillable = ['guest_id', 'progress', 'LName', 'FName', 'MI', 'SSN1', 'SSN2', 'SSN3', 'aptNo', 'Number', 'Street', 'City', 'State', 'Zip', 'AreaCode', 'TelNo1', 'TelNo2', 'AreaCodePhone', 'CellNo1', 'CellNo2', 'DOBMonth', 'DOBDay', 'DOBYear', 'Email', 'StartMonth', 'StartDay', 'StartYear', 'EthnicGroup', 'Race', 'Sex', 'Veteran', 'Status', 'Signature'];

    /**
    * Get the guest's scores
    */
    public function guest()
    {
        return $this->belongsTo('App\Guest');
    }
}
