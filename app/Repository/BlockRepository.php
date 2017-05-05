<?php 
namespace App\Repository;
class BlockRepository extends Base{

	protected $fillable = [
		'name',
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\Block::class;
	}
	public function getRules($input){
		return [
			'name'=>'required'
		];
	}
}