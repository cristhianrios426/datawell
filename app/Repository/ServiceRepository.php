<?php 
namespace App\Repository;
use \App\ORM\Service as Model;
class ServiceRepository extends Base{

	protected $fillable = [
		'name',
		'description',
		'ended_at',
		'section_id',
		'well_id',
		'service_type_id',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Model::class;
	}

	public function getAttributesNames($input){
		return [
			
			'description'=>'descripción',
			'ended_at'=>'fecha de terminación',
			'section_id'=>'tipo de sección',
			'well_id'=>'pozo',
			'service_type_id'=>'tipo de servicio',			
		];
	}	

	public function getRules($input){
		return [
			'name'=>'required',
			'description'=>'sometimes|string|nullable',
			'ended_at'=>'required|date',
			'section_id'=>'required|exists_eloquent:\\App\\ORM\\Section',
			'well_id'=>'required|exists_eloquent:\\App\\ORM\\Well',
			'service_type_id'=>'required|exists_eloquent:\\App\\ORM\\ServiceType',			
		];
	}


}