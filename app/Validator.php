<?php 
namespace App;
use Illuminate\Validation\Validator as IlluminateValidator;
use App\ORM\Location;
class Validator extends IlluminateValidator{
	
	public function validateClosure($attribute, $value, $parameters){
	    $closure = $parameters[0];
	   	$r =  call_user_func($closure, $attribute, $value);	   	
	   	return $r;
	}

	public function validateFail($attribute, $value, $parameters){
		return false;
	}

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

	public function validateDifferentThan($attribute, $value, $parameters){
		return $value != $parameters[0];

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
	    $closure = isset($parameters[1]) ? $parameters[1] : null;
        $q = call_user_func($class.'::where',$field, '=', $value);
        if($closure){
        	$q = call_user_func($closure,$q);
        }
        $count = $q->count();
        if($count > 0){
            return true;
        }else{
            return false;
        }
	}

	public function validateInLocation($attribute, $value, $parameters){
		$model = $parameters[0];
		$location = $parameters[1];
		if(!$model){
			return false;
		}
		return $model->inLocation($location);
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