<?php
namespace App\Repository\Exception;
class Base extends \Exception{
	protected $validator;
	public function setValidator($validator)
	{
		$this->validator = $validator;
	}

	public function getValidator()
	{
		return $this->validator;
	}
}