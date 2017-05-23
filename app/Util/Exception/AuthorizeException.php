<?php 
namespace App\Util\Exception;
use Exception;
class AuthorizeException extends Exception{
	protected $cantReasons = [];
	protected $message = 'No tines autorización para esta operación';

	public function getCantReasons(){
		return $this->cantReasons;
	}

	public function setCantReasons(array $reasons){
		$this->cantReasons = $reasons;
		if(count($this->cantReasons)){
			$this->message = implode(', ', array_values( $this->getCantReasons() ) );
		}
		return $this->getCantReasons();
	}	
}