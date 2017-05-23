<?php 
namespace App\Repository;
use App\ORM\Cuenca;
use App\ORM\Location;
class CuencaRepository extends Base{

	protected $fillable = [
		'name',
		'location_id'
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Cuenca::class;
	}
	public function getRules($input){
		return [
			'name'=>'required',
			'location_id'=>"required|exists_eloquent:".Location::class
		];
	}
}