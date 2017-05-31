<?php
namespace App\Policies;

use App\ORM\User;
use App\ORM\Service;
use App\ORM\Well;
use App\ORM\Location;
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
  
    
    public function updateapproved(User $user, Service $model){
        if($model->approved != 1){
            return false;
        }
        if($user->isSuperAdmin()){
            return true;
        }
        if($user->isAdmin()){
            return $model->well && $model->well->location && $model->well->location->inLocation($user->location);
        }
        return false;
        
    }
    public function create(User $user, $model = Service::class)
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
                $well = Well::find($model->well_id);
               
                if(!$well){
                    return false;
                }
                // $location = Location::find($well->location_id);
                // if(!$location){
                //     return (false);
                // }
                return $well->inLocation($user->location);
            }
        }
        return (false);
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

    public function draft(User $user, Service $model){              
        return  ($model->createdBy && ( $model->createdBy->getKey() == $user->getKey()) && $model->draft == 1);
        
    }

    public function approve(User $user,  Service $model)
    {
        $approveable = $model->approveable();        
        if($user->isSuperAdmin()){
            $authorized = true;
        }elseif($user->isEngineer()){
            $authorized  =  false;
        }elseif($user->isAdmin()){
            $authorized  = ($model->well && $model->well->inLocation($user->location));            
        }elseif($user->isSupervisor()){

            $authorized =  $model->isAssignedTo($user) || $this->draft($user, $model) ;
        }else{
            $authorized = false;
        }
        return ($approveable && $authorized);
    }

    public function review(User $user, Service $model){

        $reviewable = $model->reviewable();
        if($user->isSupervisor()){
            $authorized = $model->isAssignedTo($user);    
        }else if($user->isAdmin()){
            $authorized =  $model->well &&  $model->well->location && $model->well->inLocation($user->location);    
        }else if($user->isSuperAdmin()){
            $authorized = true;
        }else{
            $authorized = false;
        }
        return ($authorized && $reviewable);
    }

    public function sendapprove(User $user, Service $model)
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
    
    public function fulledit(User $user, Service $model){
        if( $user->isSuperAdmin()){
            return !$this->approve($user, $model);
        }   
        if($user->isAdmin()){
           $well = Well::find($model->well_id);
                if(!$well){
                    return false;
                }
            
            return ($well->inLocation($user->location) && $model->approved == 1);  
            
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

     public function update(User $user, Service $model)
    {
        if(!$model->exists){
            return false;
        }
        if($user->isSuperAdmin()){
            return true;
        }
        if($user->isEngineer() || $user->isSupervisor() || $user->isAdmin()){
            return ($model->well && $model->well->location && $model->well->inLocation($user->location) );
        }
        return false;
    }
    public function delete(User $user, Service $model)
    {
        if(  $user->isSuperAdmin()){
            return true;
        }
        return false;
    }

}
