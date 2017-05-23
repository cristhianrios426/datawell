<?php 
namespace App\ORM\Observer;
class LocationObserver{
	public static $listening = true;
	public $backup = NULL;
	public function updating($model){
		$this->backup = $model->toArray();
	}

	public function updated($model){
		if(static::$listening){
			static::$listening = false;
			if($this->backup['parent_id'] != $model->parent_id){
				$model->reindex();
			}	
			static::$listening = true;		
		}
	}

	public function created($model){
		$model->reindex();
	}

	public function deleted($model){
		foreach ($model->children() as $key => $child) {
			$child->delete();
		}
	}
}