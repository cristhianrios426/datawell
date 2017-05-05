<?php 
namespace App;
use Illuminate\Validation\Validator as IlluminateValidator;
class Validator extends IlluminateValidator{
	
	public function validateUniqueEloquent($attribute, $value, $parameters){
	    $class = $parameters[0];
	    $model = new $parameters[0];
	    $field = isset($parameters[1]) ? $parameters[1] : $model->getKeyName();	    
	    $count = call_user_func($class.'::where', $field, '=', $value)->count();
	    if($count > 0){
	    	return false;
	    }else{
	    	return true;
	    }
	}

	public function validateUniqueEloquentOrValue($attribute, $value, $parameters){
	    $class = $parameters[0];
	    $field = $parameters[1] ;
	    $default = $parameters[2];

	    if($value != $default){
	         $count = call_user_func($class.'::where',$field, '=', $value)->count();
	        if($count > 0){
	            return false;
	        }else{
	            return true;
	        }
	    }else{ 
	        return true;
	    }
	}

	public function validateExistsEloquent($attribute, $value, $parameters){

		//dd($parameters);
	    $class = $parameters[0];
	    $field = isset($parameters[1]) ? $parameters[1] : with(new $class())->getKeyName();
        $q = call_user_func($class.'::where',$field, '=', $value);
        $count = $q->count();
        if($count > 0){
            return true;
        }else{
            return false;
        }
	   
	}

	public function validateJsonSchema($attribute, $value, $parameters){
		if(empty($value)){
	        return true;
	    }  
		$schema = $parameters[0]; 

		if(is_string($value)){
	        $value = json_decode($value);
	    }elseif(is_array($value)){
	        $value = json_decode(json_encode($value));
	    }

	    if(is_string($schema)){
	        $schema = json_decode($schema);
	    }elseif(is_array($schema)){
	        $schema = json_decode(json_encode($schema));
	    }
	    if(!$schema){
	        return true;
	    }
	    $schemaStorage = new \JsonSchema\SchemaStorage();
	    $schemaStorage->addSchema('file://ValidatorSchema', $schema);
	    $jsonValidator = new \JsonSchema\Validator( new \JsonSchema\Constraints\Factory($schemaStorage));
	    $jsonValidator->check($value, $schema);
	    return $jsonValidator->isValid();

	}
}