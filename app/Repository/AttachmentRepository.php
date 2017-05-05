<?php 
namespace App\Repository;
use \App\Util\Helpers;
use \App\Repository\Exception\SaveException;
class AttachmentRepository extends Base{

	protected $fillable = [
		'name',
		'file',
		'extension'
	];
	public function __construct()	
	{	
		$this->ORMClass = \App\ORM\Attachment::class;
	}
	public function getRules($input){
		return [
			'name'=>'required',
			'file'=>'required'
		];
	}

	public function save($entity = NULL, array $input = []){
		if($entity == null){
			$className = $this->ORMClass;
			$entity = new $className;
		}
		
		$this->setEntity($entity);

		$attributes = $this->getAttributes($input);
		
		$attributesTest = array_merge($this->entity->getAttributes(), $attributes);
			
		
		$validator = $this->getValidator($attributesTest);
		if($validator->fails()){
			throw new \App\Repository\Exception\ValidatorException($validator);
		}

		$info = pathinfo($attributes['file']);

		if(!$this->entity->exists){
			if(file_exists(Helpers::tempPath($attributes['file']) ) && is_file(Helpers::tempPath($attributes['file']) ) ){
				$attributes['file'] = Helpers::moveToPath($attributes['file'], Helpers::tempPath(), $this->entity->path());
			}else{
				throw new SaveException('El archivo a adjuntar no existe.');
			}	
		}

		$attributes['extension'] = isset($info['extension']) ? $info['extension'] : '';

		foreach ($attributes as $key => $value) {
			$this->entity->setAttribute($key , $value);
		}
		$this->entity->save();
	}
}