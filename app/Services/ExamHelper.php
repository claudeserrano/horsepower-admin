<?php

namespace App\Services;

class ExamHelper
{
	private $answers;
	private $examList;

	public function __construct()
	{
		$this->answers[0] = [1,2,4,1,2,4,3,2,4,4];
		$this->answers[1] = [2,3,4,1,2,1,3,1,4,3,2,3];
		$this->answers[2] = [2,4,2,2,3,2,4,1,1,1];
		$this->answers[3] = [3,4,3,3,1,1,1,3,2,3,4,2,4,2,1];
		
		$this->examList['helper'] = [1,4];
		$this->examList['jrmech'] = [1,2,4];
		$this->examList['mech'] = [1,2,3,4];
	}

	public function getKey($level)
	{
		return $this->answers[$level - 1];
	}

	public function getExamList($job)
	{
		return [1,2,3,4];
		//return $this->examList[$job];
	}

}