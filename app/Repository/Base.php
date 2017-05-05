<?php 	
namespace App\Repository;
class Base{
	protected $ORMClass;
	protected $query = NULL;
	protected $guard = ['deleted_at'];
	protected $fillable = [];
	protected $entity;

	public function __construct($ORMClass)
	{	
		$this->ORMClass = $ORMClass;
	}
	
	public function setFillable($fillable){
		$this->fillable = $fillable;
	}
	public function getFillable(){
		return $this->fillable;
	}
	public function setEntity($entity){
		$this->entity = $entity;
	}
	public function getEntity(){
		return $this->entity;
	}
	public function setGuard($guard){
		$this->guard = $guard;
	}
	public function getGuard(){
		return $this->guard;
	}

	public function getQuery(){
		if(!$this->query){
			$this->newQuery();
		}
		return $this->query;
	}

	public function newQuery(){

		$className = $this->ORMClass;
		$ob = new $className;
		$this->query = $ob->newQuery();
	}

	public function getRules($input){
		return [];
	}

	public function getMessages($input){
		return [];
	}

	public function getAttributesNames($input){
		return [
			'name'=>'nombre'
		];
	}

	public function getValidator($input, $rules = [], $messages = [], $customAttributes = []){
		$generatedRules = $this->getRules($input);
		$rules = array_merge($generatedRules, $rules);

		$generatedMessages = $this->getMessages($input);
		$messages = array_merge($generatedMessages,  $messages );

		$generatedCustomAttributes = $this->getAttributesNames($input);
		$attrs = array_merge($generatedCustomAttributes, $customAttributes );

		$validator = \Validator::make( $input, $rules, $messages, $attrs);
		return $validator;
	}

	public function getFillableInput($input){
		if(count($this->fillable) > 0){
			foreach ($input as $key => $value) {
				if(!in_array($key, $this->getFillable())){
					unset($input[$key]);
				}
			}	
		}

		return $input;
	}

	public function getGuardInput($input){
		if(count($this->getGuard()) > 0){
			foreach ($this->getGuard() as  $value) {
				if(isset($input[$value])){
					unset($input[$key]);
				}
			}	
		}

		return $input;
	}

	public function getAttributes($input){
		
		$input = $this->getFillableInput($input);
		$input = $this->getGuardInput($input);
		
		return $input;
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

		foreach ($attributes as $key => $value) {
			$this->entity->setAttribute($key , $value);
		}
		$this->entity->save();
	}

	public function scopeByUser($q, $user){
		return $q;
	}

	public static function sortableLinks($query, $sorts){    	
        $sortLinks = [];
        foreach ($sorts as $key => $sort) {          
            $sortLinks[$sort] = [];
            $active = isset($query['sort']) && $query['sort'] == $sort ? true : false;
            $params = [];
            $params['sort'] = $sort;
            if($active && isset($query['sort_type'])){
                $params['sort_type'] =  $query['sort_type'] == 'asc' ? 'desc' : 'asc'; 
            }else{
                $params['sort_type'] = 'asc';
            }
            $sortLinks[$sort] = [
                'url'=>route('user.index', array_merge($query, $params) ),
                'type'=>($active ? 'sort-'.$query['sort_type'] : 'sort' ),
            ]; 
        }

        return  $sortLinks;
    }

    public function __call($name, $args)
    {	
    	$localScope = 'scope'.ucfirst($name);
    	if(method_exists($this, $localScope) ){
    		array_unshift($args, $this->getQuery());
    		$this->{$localScope}(...$args);
    	}else{
    		$r = $this->getQuery()->{$name}(...$args);
    		if(in_array($name, ['first','count', 'get', 'paginate','max', 'find'])){
    			return $r;
    		}
    	}
    	return $this;
    }

    

}