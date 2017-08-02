<?php 
namespace App\Repository;
use \App\ORM\Service as Model;
class ServiceRepository extends Base{

	protected $fillable = [
		//'name',
		'description',
		'started_at',
		'ended_at',
		'section_id',
		'client_id',
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
			'ended_at'=>'fecha de inicio',
			'section_id'=>'tipo de sección',
			'well_id'=>'pozo',
			'client_id'=>'cliente',
			'service_type_id'=>'tipo de servicio',			
		];
	}	

	public function getRules($input){
		return [
			//'name'=>'required',
			'description'=>'sometimes|string|nullable',
			'ended_at'=>'required|date',
			'started_at'=>'required|date',
			'section_id'=>'required|exists_eloquent:\\App\\ORM\\Section',
			'client_id'=>'required|exists_eloquent:\\App\\ORM\\Client',
			'well_id'=>'required|exists_eloquent:\\App\\ORM\\Well',
			'service_type_id'=>'required|exists_eloquent:\\App\\ORM\\ServiceType',			
		];
	}


}