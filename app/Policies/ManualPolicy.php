<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManualPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create($user){
        return $user->isSuperAdmin();
    }
    public function update($user){
        return $user->isSuperAdmin();
    }
    public function view($user){
        return $user->isSuperAdmin();
    }
    public function delete($user){
        return $user->isSuperAdmin();
    }
    public function index($user){
        return $user->isSuperAdmin();
    }

    public function download($user, $model){
        if($user->isSuperAdmin()){
            return true;
        }
        return ($user->role_id == $model->role_id);
    }
}
