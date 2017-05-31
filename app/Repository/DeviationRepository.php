<?php 
namespace App\Repository;
use App\ORM\Deviation;
class DeviationRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Deviation::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}