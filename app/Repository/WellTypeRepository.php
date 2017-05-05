<?php 
namespace App\Repository;
use App\ORM\WellType;
class WellTypeRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) WellType::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}