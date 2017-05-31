<?php 
namespace App\Repository;
use App\ORM\Location;
class FAQRepository extends Base{

	protected $fillable = [
		'answer',
		'question',
		
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\FAQ::class;
	}
	public function getRules($input){
		return [
			'answer'=>'required',		
			'question'=>'required'			
		];
	}
}