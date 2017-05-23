<?php 
namespace App\ORM\Observer;
use Schema;
class PersonObserver{

	public function created($model){

		if(\Auth::check()){			
			$user = \Auth::user();
			$table = $model->getTable();
			if(Schema::hasColumn($table, 'created_by')){
				$model->created_by = $user->getKey();
				$model->save();
			}
		}
	}


	public function deleted($model){
		if(\Auth::check()){
			$user = \Auth::user();
			$table = $model->getTable();
			if(Schema::hasColumn($table, 'deleted_by')){
				$model->deleted_by = $user->getKey();
			}
		}
	}
}