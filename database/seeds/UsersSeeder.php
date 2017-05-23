<?php

use Illuminate\Database\Seeder;
use App\ORM\User;
class UsersSeeder extends Seeder
{
    

    public function run()
    {
       	$arr = [
       	'role_superadmin' => 0,
    	'role_admin' => 1,
    	'role_eng' => 2,
    	'role_super' => 3,
    	'role_client' => 4,
    	'role_manager' => 5
    	];
    	foreach ($arr as $name => $role) {
    		$model = new User;
    		$model->name = $name.'_ven';
    		$model->email = $name.'_ven@datawell.local';
    		$model->role_id = $role;
    		$model->state = User::ACTIVE;
    		$model->ide_type = 1;
    		$model->ide = 12364;
    		$model->password = \Hash::make(123456);;
    		$model->sendActivationCode(User::GENERATE_ACTIVATION);
    	}

    	foreach ($arr as $name => $role) {
    		$model = new User;
    		$model->name = $name.'';
    		$model->email = $name.'@datawell.local';
    		$model->role_id = $role;
    		$model->state = User::ACTIVE;
    		$model->ide_type = 1;
    		$model->ide = 12364;
    		$model->password =  \Hash::make(123456);
    		$model->sendActivationCode(User::GENERATE_ACTIVATION);
    	}

    }
}
