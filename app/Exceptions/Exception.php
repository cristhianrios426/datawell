<?php 
namespace App\Exceptions;
class Exception extends \Exception
{	
	protected $context = NULL;

	public function setContext($context){
		$this->context = $context;
	}
	public function getContext(){
		return $this->context;
	}
}