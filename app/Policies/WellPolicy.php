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

    public function create(User $user)
    {
        if(is_string($model)){            
            $model = NULL;
        }

        if($model == NULL ){
            
            if($user->isEngineer() || 
                $user->isAdmin() || 
                $user->isSuperAdmin() || 
                $user->isSupervisor()
            ){
                return true;
            }else{
                return false;
            }        
        }else{

            if($user->isSuperAdmin() ){
                return true;
            }elseif( $user->isAdmin() || $user->isSupervisor() || $user->isEngineer()){

                $modelLocation = Location::find($model->location_id);
                
                if(!$modelLocation){
                    return false;
                }
                return ($user->inMyLocation($modelLocation));
            }  
            return false;    
        }
        
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
        if($user->isEngineer() && 
            $model->createdBy && 
            $model->createdBy->getKey() == $user->getKey() && 
            $model->state ==  Well::STATE_DRAFT){
            return true;   
        }
        if($user->isSupervisor() && $model->assignedTo && $model->assignedTo->getKey() == $user->getKey()){
            return true;   
        }
        if($user->isAdmin() && $model->location && $model->inLocation($user->location) ){
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

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User  $user
     * @param  \App\Well  $model
     * @return mixed
     */
    public function delete(User $user, Well $model)
    {
        if(  $user->isSuperAdmin() || 
            (
                $user->isAdmin() &&
                $model->location &&
                $model->inLocation($user->location)
            ) 
        ){
            return true;
        }
        return false;
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
                return ($model->location && $model->inLocation($user->location));
            }
        }
        
        if($user->isSupervisor()){            
            if($model == NULL){
                return true;
            }else{
                return ($model->assignedTo && $model->assignedTo->getKey() == $user->getKey() &&  in_array((int) $model->state, [ Well::STATE_APPROVING,  Well::STATE_DRAFT]) );
            }
        }       
        return false;
    }

    public function createapprove(User $user)
    {       
        if($user->isSuperAdmin() ||  $user->isAdmin() || $user->isSupervisor() ){
            
            return true;
        }
        return false;
    }

    public function review(User $user, Well $model){
        return ( (int) $model->state == Well::STATE_APPROVING ) && $model->assignedTo && ($model->assignedTo->getKey() == $user->getKey()) ;
    }

    public function sendapprove(User $user,  $model = Well::class)
    {
        if(is_string($model)){
            $model = NULL;
        }
        if($model && 
            $model->exists &&  
            ($model->state  == Well::STATE_APPROVING || $model->state  == Well::STATE_REVIEWING)){
            return false;
        } 
        if($user->isSuperAdmin()){
            return true;
        }
        if($user->isAdmin()){
            if($model == NULL){
                return true;
            }else{
                return ($user->inMyLocation($user->location));
            }
        }
        if($user->isSupervisor()){
            if($model == NULL){
                return true;
            }else{                        
                return ($model->created_by == $user->getKey() &&  $model->state == Well::STATE_APPROVING);
            }
        }
        if($user->isEngineer()){
            if($model == NULL){
                return true;
            }else{     
                       
                return ($model->created_by == $user->getKey());
            }
        }       
        return false;
    }

}
