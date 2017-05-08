<?php 
namespace App\Repository;
class ServiceTypeRepository extends Base{

	protected $fillable = [
		'name',
		'business_unit_id'
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\ServiceType::class;
	}
	public function getRules($input){
		return [
			'name'=>'required',
			'business_unit_id'=>"required|exists_eloquent:\\App\\ORM\\BusinessUnit",
		];
	}
}