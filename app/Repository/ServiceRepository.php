<?php 
namespace App\Repository;
use \App\ORM\Service as Model;
class ServiceRepository extends Base{

	protected $fillable = [
		'name',
		'description',
		'ended_at',
		'id_section',
		'id_well',
		'id_service_type',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Model::class;
	}

	public function getAttributesNames($input){
		return [
			
			'description'=>'descripción',
			'ended_at'=>'fecha de terminación',
			'id_section'=>'tipo de sección',
			'id_well'=>'pozo',
			'id_service_type'=>'tipo de servicio',			
		];
	}	

	public function getRules($input){
		return [
			'name'=>'required',
			'description'=>'sometimes|string|nullable',
			'ended_at'=>'required|date',
			'id_section'=>'required|exists_eloquent:\\App\\ORM\\Section',
			'id_well'=>'required|exists_eloquent:\\App\\ORM\\Well',
			'id_service_type'=>'required|exists_eloquent:\\App\\ORM\\ServiceType',			
		];
	}


}