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
        if($user->isAdmin()){
            return  $model->location && $model->location->inLocation($user->location);
        }
        return false;
        
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
        //dd  ($model->createdBy , ( $model->createdBy->getKey() == $user->getKey()) , $model->draft == 1);
        return  ($model->createdBy && ( $model->createdBy->getKey() == $user->getKey()) && $model->draft == 1);
        
    }
    
    

    public function approve(User $user,  Well $model)
    {
        
        $approveable = $model->approveable();
        if($user->isSuperAdmin()){
            $authorized = true;
        }elseif($user->isEngineer()){
            $authorized  =  false;
        }elseif($user->isAdmin()){
            $authorized  = ($model->location && $model->inLocation($user->location));            
        }elseif($user->isSupervisor()){
            $authorized =  $model->isAssignedTo($user) || $this->draft($user, $model) ;
        }else{
            $authorized = false;
        }
        return ($approveable && $authorized);
    }

    public function review(User $user, Well $model){

        $reviewable = $model->reviewable();
        if($user->isSupervisor()){
            $authorized = $model->isAssignedTo($user);    
        }else if($user->isAdmin()){
            $authorized = $model->location && $model->location->inLocation($user->location);    
        }else if($user->isSuperAdmin()){
            $authorized = true;
        }else{
            $authorized = false;
        }

        //dd ($authorized , $reviewable);
        return ($authorized && $reviewable);
    }

    public function sendapprove(User $user, Well $model)
    {
        
        

        $approving = $model->approving();
        if($user->isSupervisor()){            
            $authorized = ( !$model->approving() && !$model->reviewing() );    
        }else if($user->isAdmin() || $user->isEngineer()){
            $authorized = $model->location && $model->inLocation($user->location);    
            if($user->isEngineer()){
                if($model->reviewing()){
                    $authorized = $model->wasSentTo($user);
                }else{
                    $authorized = true;
                }
            }
        }else if($user->isSuperAdmin()){
            $authorized = true;
        }else{
            $authorized = false;
        }
        //dd ($authorized , $approveable , !$blocked , !$model->isAssignedTo($user));
        return ($authorized && !$approving);
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
        if($user->isEngineer() || $user->isSupervisor() || $user->isAdmin()){
            return ($model && $model->location && $model->inLocation($user->location) );
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

    public function sendapprovefiles(User $user, Well $model)
    {        
        $blocked = $model->blocked();
        if($user->isSupervisor()){
            $authorized = $model->isAssignedTo($user);    
        }else if($user->isAdmin()){
            $authorized =  $model->well &&  $model->well->location && $model->well->inLocation($user->location);    
        }else if($user->isSuperAdmin()){
            $authorized = true;
        }else if($user->isEngineer()){
            $authorized = $model->createdBy && $model->createdBy->getKey() == $user->getKey();
        }else{
            $authorized = false;
        }
        return ($authorized && !$blocked && !$model->isAssignedTo($user));
    }

    
    

}   
