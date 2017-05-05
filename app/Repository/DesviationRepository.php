<?php 
namespace App\Repository;
use App\ORM\Desviation;
class DesviationRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Desviation::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}