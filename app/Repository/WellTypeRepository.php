<?php 
namespace App\Repository;
use App\ORM\WellType;
class WellTypeRepository extends Base{

	protected $fillable = [
		'name',
		'color'
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) WellType::class;
	}
	public function getRules($input){
		return [
			'name'=>'required',
			'color'=>['sometimes', ['regex', '/^#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/' ]]
		];
	}
}