<?php 
namespace App\Repository;
use App\ORM\CoordinateSys;
class CoordinateSysRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) CoordinateSys::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}