<?php
namespace App\Policies;
use App\ORM\User;
use App\ORM\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;
    
   /**
     * Determine whether the user can view the location.
     *
     * @param  \App\User  $user
     * @param  \App\Location  $model
     * @return mixed
     */
    public function view(User $user, Location $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $entity = Location::class)
    {        
        
        if(is_string($entity)){
            $entity = NULL;
        }
        if($user->isSuperAdmin() ){
            return true;
        }else if($user->isAdmin()){
            if( !$entity){
                return true;
            }else{                   
                $entityLocation = Location::find($entity->parent_id); 
                if(!$entityLocation){
                    return $entityLocation;
                }
                return $user->inMyLocation($entityLocation);
            }
        }else{
            return false;
        }
    }



    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\User  $user
     * @param  \App\Location  $model
     * @return mixed
     */
    public function update(User $user, Location $model)
    {
        
        if($user->isSuperAdmin() ){
            return true;
        }else if($user->isAdmin()){
            if($model instanceof Localizable){
                if(!$user->location){
                    return false;
                }
                if(!$model->location){
                    return $model->getKey() == $user->location->getKey();
                }   
                return $user->inMyLocation($model->location);
            }else{
                return true;
            }            
        }else{
            return false;
        }     
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User  $user
     * @param  \App\Location  $model
     * @return mixed
     */
    public function delete(User $user, Location $model)
    {
        if($user->isSuperAdmin()){
            return true;
        }else{
            return false;
        }        
    }

    public function index(User $user){
        if($user->isSuperAdmin() || $user->isAdmin() || $user->isManager()){            
            return true;
        }else{            
            return false;
        }
    }
}
