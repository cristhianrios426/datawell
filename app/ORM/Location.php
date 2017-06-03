<?php
namespace App\ORM;
use App\ORM\TreeTrait;
use App\ORM\LocationTrait;
use Illuminate\Database\Eloquent\Model;
use Util\DataBag;
use Closure;
class Location extends BaseModel
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
   
    use TreeTrait{
    	children as tchildren;
    }
    
    public  function children()
    {
    	return $this->tchildren()->orderBy('name');
    }

    public function listAscendence(){
        return explode( '/', trim($this->index_search, '/'));
    }

    public function reindex($parent = false){
    	$parent = $parent !== false ? $parent : $this->parent;
        $this->index_search = $parent ? $parent->index_search.$this->getKey().'/' :  '/'.$this->getKey().'/' ;
        $this->full_name = $parent ? $parent->full_name.$this->name.'/' :  '/'.$this->name.'/' ;
    	$this->level = count(explode('/', trim($this->index_search, '/')));
    	$this->save();
    	$children = $this->children()->get();
    	foreach ($children as $key => $child) {
    		$child->reindex($this);
    	}    	
    }

    public function location()
    {
        return $this->parent();
    }

    public function scopeInLocation($q, $location){                
        $q->where('index_search', 'LIKE', $location->index_search.'%');        
        return $q;
    }

    public function scopeInUserLocation($q, $user){
        return $q->inLocation($user->location);
    }

    public function inLocation($location){      
        
        return strpos($this->index_search, $location->index_search) === 0;
    }

    public function fullName(){
        return implode(', ', explode('/', trim($this->full_name, '/')));
    }


}