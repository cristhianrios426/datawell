<?php 
namespace App\Repository;
class BusinessUnitRepository extends Base{

	protected $fillable = [
		'name'
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\BusinessUnit::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}