<?php
namespace App\ORM;
use Closure;
use App\Util\DataBag;
use Traversable;
trait TreeTrait{
	public function children()
	{
	    return $this->hasMany(static::class, 'parent_id');
	}

	public function parent()
	{
	    return $this->belongsTo(static::class, 'parent_id');
	}

	public function treeChildren()
	{
	    return $this->children()->with('treeChildren');
	}

	public function scopeFullTree($q)
	{
	    return $q->where('parent_id', 0)->with('treeChildren');
	}

	public function recursiveIterator($collection, Closure $callback, $bag = NULL){
		$bag = $bag == NULL ? new DataBag() : $bag;
		foreach ($collection as $key => $model) { 
			$return = call_user_func($callback, $model, $bag);
			if($return instanceof Traversable){
				echo '--- trans --';
				echo "\n\r";
				$this->recursiveIterator($return, $callback, $bag);
			}
		}
		return $bag;
	}
}
	