<?php 
namespace App\Util;
use App\Util\Exception\AuthorizeException;

use Illuminate\Foundation\Auth\Access\Authorizable as AuthAuthorizable;
trait Authorizable{
	use AuthAuthorizable;

	protected $cantReasons = [];

	public function getCantReasons(){
		return $this->cantReasons;
	}

	public function addCantReason($reason){
		return $this->cantReasons[] = $reason;
	}

	public function setCantReason(array $reasons){
		return $this->cantReasons =  $reasons;
	}

	public function canOrFail($ability, $arguments = []){
		if($this->cant($ability, $arguments)){
			$e = new AuthorizeException();
			$e->setCantReasons($this->getCantReasons());
			throw $e;
		}else{
			return true;
		}
	}
}