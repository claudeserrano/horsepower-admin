<?php

namespace App\Services;

class EmployeeIdentifier
{

	public $_;
	public $type;

	public function __construct($paramValue, $attrValue)
	{
		$this->_ = $paramValue;
	    $this->type = $attrValue;
	}

}