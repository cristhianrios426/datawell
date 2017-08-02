<?php

namespace App\Policies;
use App\ORM\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManualPolicy
{
    use HandlesAuthorization;

    public function create($user){
        return $user->isSuperAdmin();
    }
    public function delete($user){
        return $user->isSuperAdmin();
    }
    public function update($user){
        return $user->isSuperAdmin();
    }
    public function view($user){
         return $user->isSuperAdmin();
    }
}
