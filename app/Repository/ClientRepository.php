<?php 
namespace App\Repository;
use \App\ORM\Client as Model;
class ClientRepository extends Base{

	protected $fillable = [
		'name'
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Model::class;
	}

	public function getAttributesNames($input){
		return [
			'name'=>'nombre'
		];
	}	

	public function getRules($input){
		return [
			'name'=>'required'
		];
	}


}