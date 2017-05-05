<?php 
namespace App\Repository;
class ServiceTypeRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\ServiceType::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}