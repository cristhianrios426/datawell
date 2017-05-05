<?php 
namespace App\Repository;
use \App\ORM\Section;
class SectionRepository extends Base{

	protected $fillable = [
		'name'
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) \App\ORM\Section::class;
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