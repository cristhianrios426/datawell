<?php
namespace App\Policies;

use App\ORM\User;
use App\ORM\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $model
     * @return mixed
     */
    public function view(User $user, Service $model)
    {
        if($user->isClient()){
            return ($model->id_client == $user->id_client);
        } else if(
                $user->isEngineer() || 
                $user->isAdmin() || 
                $user->isSuperAdmin() || 
                $user->isSupervisor()
            ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->isEngineer() || 
            $user->isAdmin() || 
            $user->isSuperAdmin() || 
            $user->isSupervisor()
        ){
            return true;
        }else{
            return false;
        }        
    }

    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $model
     * @return mixed
     */
     public function update(User $user, Well $model)
    {
        if(!$model->exists){
            return false;
        }
        if($user->isSuperAdmin()){
            return true;
        }
        if($user->isEngineer() && 
            $model->createdBy && 
            $model->createdBy->getKey() == $user->getKey() && 
            $model->state ==  Well::STATE_DRAFT){
            return true;   
        }
        if($user->isSupervisor() && 
            $model->assignedTo && 
            $model->assignedTo->getKey() == $user->getKey()
        ){
            return true;   
        }
        if($user->isAdmin() && $model->location && $model->well && $model->well->inLocation($user->location) ){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $model
     * @return mixed
     */
    public function delete(User $user, Service $model)
    {
        if(  $user->isSuperAdmin() || 
            (
                $model->location &&
                $model->well &&
                $model->well->inLocation($user->location) &&
                $user->isAdmin()
            ) 
        ){
            return true;
        }
        return false;
    }

    public function save(User $user, $model = Well::class){
        if(is_string($model) || !$model->exists){
            return $this->create( $user, $model);
        }else{
            return $this->update( $user, $model);
        }
    }

    public function approve(User $user,  $model = Well::class)
    {
        if(is_string($model)){
            $model = NULL;
        }

        if($user->isEngineer()){
            return false;
        }

        if($user->isSuperAdmin()){
            return true;
        }

        if($user->isAdmin()){
            if($model == NULL){
                return true;
            }else{
                return ($model->location && $model->well && $model->well->inLocation($user->location));
            }
        }
        
        if($user->isSupervisor()){
            if($model == NULL){
                return true;
            }else{
                return (
                    $model->assignedTo && 
                    $model->assignedTo->getKey() == $user->getKey() &&  
                    in_array((int) $model->state, [ 
                        Well::STATE_APPROVING,  
                        Well::STATE_DRAFT]) );
            }
        }       
        return false;
    }

}
