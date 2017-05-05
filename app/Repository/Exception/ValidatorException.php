<?php 	
namespace App\Repository\Exception;
class ValidatorException extends Base
{
	public $validator;
	public function __construct($validator){
		parent::__construct('Error');
		$this->validator = $validator;
	}

	public function response(){
		return response()->json( ['messages'=>['messages'=>array_values($e->getPlainMessages() ), 'type'=>'danger']] , 422);
	}
}