<?php 
namespace App\Repository;
use App\ORM\Location;
class BlockRepository extends Base{

	protected $fillable = [
		'name',
		'location_id'
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\Block::class;
	}
	public function getRules($input){
		return [
			'name'=>'required',
			'location_id'=>"required|exists_eloquent:".Location::class
		];
	}
}