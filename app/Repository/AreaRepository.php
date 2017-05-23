<?php 
namespace App\Repository;
use App\ORM\Area;
use App\ORM\Location;
class AreaRepository extends Base{

	protected $fillable = [
		'name',
		'location_id'
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Area::class;
	}
	public function getRules($input){
		return [
			'name'=>'required',
			'location_id'=>"required|exists_eloquent:".Location::class
		];
	}
}