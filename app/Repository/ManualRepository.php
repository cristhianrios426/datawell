<?php 
namespace App\Repository;
use App\ORM\User;
use App\Util\Helpers;

class ManualRepository extends Base{

	protected $fillable = [
		'name',
		'file',
		'role_id',
		
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\Manual::class;
	}

	public function getRules($input){
		$rules =  [];
		$rules['name'] = 'required';
		$rules['file'] = 'required';
		$rules['client_file'] = 'required';
		$rules['role_id'] = array_merge(['in'], User::getRoles() );
	}

	public function save($entity = NULL, array $input = []){
		if($entity == null){
			$className = $this->ORMClass;
			$entity = new $className;
		}
		$this->setEntity($entity);
		$user  = \Auth::user();
		if($this->entity->exists){
			$permission = 'update';
		}else{
			$permission = 'create';
		}


		try {
			$user->canOrFail($permission, $this->entity);
		} catch (Exception $e) {			
			$v = \Validator::make(['f'=>''],['f'=>'required'], ['f.required'=>$e->getMessage()]);	
			$v->fails();
			throw new ValidatorException($v);
		}

		$this->entity->name = $input['name'];		
		$this->entity->client_file = $input['client_file'];		
		$this->entity->role_id = $input['role_id'];

		if($input['file'] != $this->entity->file){
			if(\File::exists(Helpers::tempPath($input['file'])) ){
				if(\File::move(Helpers::tempPath($input['file']) , storage_path('app/manual/'.$input['file']) )){
					$this->entity->file = $input['file'];
				}
			}
		}
		
		$this->entity->save();	
	}
	
}