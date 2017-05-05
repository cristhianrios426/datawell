<?php
namespace App\ORM;
use Illuminate\Auth\Authenticatable as AuthenticatableEloquentTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

class User extends BaseModel implements AuthenticatableContract , CanResetPasswordContract
{
	use Notifiable , SoftDeletes, AuthenticatableEloquentTrait, CanResetPasswordTrait;

	const ACTIVE = 1;
	const INACTIVE = 2;
	const PENDING = 3;

	const RENEW_ACTIVATION = 1;
	const GENERATE_ACTIVATION = 2;

    const ROLE_ADMIN = 1;
    const ROLE_ENG = 2;
    const ROLE_SUPER = 3;
    const ROLE_CLIENT = 4;
    const ROLE_MANAGER = 5;

    protected $fillable = [];
    protected $dates = ['deleted_at','created_at', 'updated_at'];

    public function sendActivationCode($activation){
    	
    	$token = str_random(32);
    	$hashToken = $this->hashToken($token);

    	$this->is_actived = 0;
    	$this->activation_token = $this->hashToken($token);
        $time = new \DateTime();
        $time->modify('+ 1 days');
    	$this->expire_token = $time;

    	$this->save();
    	$self = $this;
        $mail = new \App\Mail\ActivationAccount($self, $activation);
        $mail->with('token',$token);
    	\Mail::send($mail);
    }

    public function hashToken($token){
        return md5($token);
    }

    public function checkToken($token){
        $r = ($this->activation_token == $this->hashToken($token)) ;
        $t = (time() < strtotime($this->expire_token));
        
        
        return ($r && $t);
    }
    
    public function scopeFindByToken($q, $token){
        $q->where('activation_token', $this->hashToken($token));
        return $q;
    }

    public function isActive(){
        return $this->state == static::ACTIVE;
    }

    public function isRole($roleString){
        $roles = [  
                    'admin'=>static::ROLE_ADMIN,
                    'eng'=>static::ROLE_ENG,
                    'super'=>static::ROLE_SUPER, 
                    'client'=>static::ROLE_CLIENT,
                    'manager'=>static::ROLE_MANAGER
                ];
        if(isset($roles[$roleString])){
            return $roles[$roleString] == $this->role_id;
        }else{
            return false;
        }
    }

    public function roleName(){
        return trans('roles.'.($this->role_id - 1));
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
