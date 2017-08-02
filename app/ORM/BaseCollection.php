<?php 
namespace App\ORM;
use Illuminate\Database\Eloquent\Collection;
class BaseCollection extends Collection{
	
	public function addHidden($hidden){			
		foreach ($this as $key => $model) {
			$model->addHidden($hidden);
		}
	}

	public function removeHidden($hidden){
		foreach ($this as $key => $model) {
			$model->removeHidden($hidden);
		}
	}
	public function addAppends($hidden){			
		foreach ($this as $key => $model) {
			
			$model->addAppends($hidden);
			
		}
	}

	public function jsonSerialize(){
		try {
			$r = parent::jsonSerialize();
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
		return $r;
	}

	public function removeAppends($hidden){
		foreach ($this as $key => $model) {
			$model->removeAppends($hidden);
		}
	}
	
}