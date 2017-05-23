<?php 
namespace App\Repository;
use \App\ORM\Location;
class LocationRepository extends Base{

	protected $fillable = [
		'name',
		'parent_id'
	];
	public function __construct()	
	{	
		$this->ORMClass = Location::class;
	}
	public function getRules($input){
		$rules =  [
			'name'=>'required',
			'parent_id' => 'required',
		];
		if($this->entity){
			if($this->entity->exists){
				$rules['parent_id'] = 'required|different_than:'.$this->entity->getKey();
			}
		}
		return $rules;
	}

	public function getValidator($input, $rules = [], $messages = [], $customAttributes = []){
		$messages['parent_id.closure'] = 'No puede ser hijo de si mismo.';
		$validator = parent::getValidator($input, $rules, $messages, $customAttributes);
		$entity = $this->getEntity();
		$newRules = [
			'required', 
			['exists_eloquent', Location::class],
			['closure', function($attribute, $value) use ($entity){
				if($entity->exists){
					$id = $entity->getKey();
					$model = Location::find($value);
					$depth = 20;					
					$list = [];
					while($depth > 0 &&  $model && $model->parent_id != 0  ){						
						$list[] = $model->parent_id;
						$model = Location::find($model->parent_id);
						$depth--;
					}					
					return !in_array($id, $list);
				}else {
					return true;
				}
			}]	
		];
		$validator->sometimes( 'parent_id',$newRules,  function ($input) {
		    return $input->parent_id > 0 ;
		});
		return $validator;
	}
}