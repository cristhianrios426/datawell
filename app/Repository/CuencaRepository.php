<?php 
namespace App\Repository;
use App\ORM\Cuenca;
class CuencaRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Cuenca::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}