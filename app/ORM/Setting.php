<?php 
namespace App\ORM;

class  Setting extends BaseModel{

	public function scopeFilterUser($q, $user){
		if($user->isSuperAdmin() || $user->isAdmin() || $user->isManager()){
			return $q;
		}else{
			return $q->whereRaw(' 1 != 1');
		}
	}

	public static function boot(){
        parent::boot();
        static::observe(new \App\ORM\Observer\PersonObserver() );
    }
}