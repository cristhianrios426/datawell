<?php 
namespace App\Repository;
use App\ORM\Camp as Model;
use App\ORM\Location;
class CampRepository extends Base{

	protected $fillable = [
		'name',
		'location_id'
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Model::class;
	}
	public function getRules($input){
		return [
			'name'=>'required',
			'location_id'=>"required|exists_eloquent:".Location::class
		];
	}
}