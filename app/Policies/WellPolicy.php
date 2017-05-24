<?php

namespace App\Policies;

use App\ORM\User;
use App\ORM\Well;
use App\ORM\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class WellPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\User  $user
     * @param  \App\Well  $model
     * @return mixed
     */
    public function view(User $user, Well $model)
    {

        if($user->isClient()){
            return ($model->services()->where('client_id', $user->client_id)->count() > 0);
        } else{
            return true;
        }
    }
    
    public function updateapproved(User $user, Well $model){
        if($model->approved != 1){
            return false;
        }
        if($user->isSuperAdmin()){
            return true;
        }
        
    }

    public function create(User $user, $model = Well::class)
    {   
        if(is_string($model)){
            $model = NULL;
        }

        if($user->isSuperAdmin()){
            return true;
        }
        if( $user->isEngineer()||
            $user->isAdmin() ||
            $user->isSupervisor() 
        ){
            if(!$model){
                return true;
            }else{
                $location = Location::find($model->location_id);
                if(!$location){
                    return false;
                }
                return $location->inLocation($user->location);  
            }
        }
        return false;
    }

    public function createdraft(User $user){
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



    public function createsendapprove(User $user){
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
    
    public function createapproved(User $user){        
        if($user->isSuperAdmin() || $user->isAdmin()){
            return true;
        }
        return false;     
    }

    public function draft(User $user, Well $model){              
        return  ($model->createdBy && ( $model->createdBy->getKey() == $user->getKey()) && $model->draft == 1);
        
    }
    
    

    public function approve(User $user,  Well $model)
    {
        
        if($model->approved == 1){
            return false;
        }

        if($user->isSuperAdmin()){
            return true;
        }
        if($user->isEngineer()){
            return false;
        }
        if($user->isAdmin()){
            if($model == NULL){
                return true;
            }else{
                return ($model->location && $model->inLocation($user->location));
            }
        }
        
        if($user->isSupervisor()){
            return (
                (
                    $model->assignedTo && 
                    $model->assignedTo->getKey() == $user->getKey() && 
                    $model->approved != 1 
                )  ||
                (
                    $this->draft($user, $model)
                )             
            );
        } 
        return false;
    }

    public function review(User $user, Well $model){

        $reviewable = (
                ($model->state == Well::STATE_APPROVING  || $model->state == Well::STATE_REVIEWING  ) &&
                $model->approved != 1
        );

        if($user->isSupervisor()){
            $authorized = $model->assignedTo && ($model->assignedTo->getKey() == $user->getKey());    
        }else if($user->isAdmin()){
            $authorized = $model->location && $model->location->inLocation($user->location);    
        }else if($user->isSuperAdmin()){
            $authorized = true;
        }else{
            $authorized = false;
        }

        return ($authorized && $reviewable);
    }

    public function sendapprove(User $user, Well $model)
    {
        $approveable = (
            $model->state != Well::STATE_APPROVING && 
            $model->approved != 1
        );
        $authorized = $this->draft($user,  $model);
        return ($authorized && $approveable);
    }
    
    public function fulledit(User $user, Well $model){
        if( $user->isSuperAdmin()){
            return !$this->approve($user, $model);
        }   
        if($user->isAdmin()){
            $location = Location::find($model->location_id);
            if(!$location){
                    return false;
            }
            return ($location->inLocation($user->location) && $model->approved == 1);  
            
        }
        return false;
    }

    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\User  $user
     * @param  \App\Well  $model
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
        if($user->isEngineer()){
            
            return (
                $this->draft( $user, $model) ||

                (
                    $model->createdBy &&
                    $model->createdBy->getKey() == $user->getKey()  &&
                    $model->approved != 1 &&
                    $model->state == Well::STATE_REVIEWING
                )
            );              
        }
        if($user->isSupervisor()){

            $r = (
                     $this->draft( $user, $model) ||
                     (
                        $model->assignedTo && 
                        $model->assignedTo->getKey() == $user->getKey() &&
                        $model->approved != 1 
                        
                     )
                );
            return $r;
        }

        if($user->isAdmin()){
            if($this->draft( $user, $model)){
                return true;
            }else{
                $location = Location::find($model->location_id);
                if(!$location){
                    return false;
                }
                return $location->inLocation($user->location);  
            }
        }
        return false;
    }

     /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User  $user
     * @param  \App\Well  $model
     * @return mixed
     */
    public function delete(User $user, Well $model)
    {
        if(  $user->isSuperAdmin()){
            return true;
        }


        return false;
    }

}   
