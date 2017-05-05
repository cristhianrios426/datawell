<?php 
namespace App\Repository;
class OperatorRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\Operator::class;
	}

	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}