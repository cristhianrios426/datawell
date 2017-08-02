<?php
namespace App\ORM;
use App\ORM\locationable;
class Manual extends Setting
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = [];
    protected $dates = ['deleted_at','created_at', 'updated_at'];
    protected $table = 'manuals';

    public function downloadUrl(){
    	return route('manual.download', ['id'=>$this->id]);
    }

    public function roleName(){
    	switch ($this->role_id) {
    		case \App\ORM\User::ROLE_SUPERADMIN:
	           $name = "Super administrador";
	           break;
	        case \App\ORM\User::ROLE_ADMIN:
	           $name = "Administrador";
	           break;
	        case \App\ORM\User::ROLE_ENG :
	           $name = "Ingeniero";
	           break;
	        case \App\ORM\User::ROLE_SUPER:
	           $name = "Supervisor";
	           break;
	        case \App\ORM\User::ROLE_CLIENT:
	           $name = "Cliente";
	           break;
	        case \App\ORM\User::ROLE_MANAGER :
	           $name = "Gerente";
	           break;
    		default:
    			 $name = "";
    			break;
    	}
    	return $name;
        
    }
}
