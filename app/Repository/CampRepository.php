<?php 
namespace App\Repository;
use App\ORM\Camp as Model;
class CampRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Model::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}