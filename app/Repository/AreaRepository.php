<?php 
namespace App\Repository;
use App\ORM\Area;
class AreaRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Area::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}