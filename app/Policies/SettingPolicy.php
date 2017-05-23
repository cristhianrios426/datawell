<?php
namespace App\Policies;

use App\ORM\User;
use App\ORM\locationable;
use App\ORM\Location;
use App\ORM\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\User  $user
     * @param  \App\Setting  $model
     * @return mixed
     */
    public function view(User $user, Setting $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $entity = Setting::class)
    {

        if(is_string($entity)){
            $entity = NULL;

        }

        if($user->isSuperAdmin()){
            return  true;

        }else if($user->isAdmin()){
            if( !$entity){                               
                return  true;
            }else{                   
               if($entity instanceof locationable){                    
                    $entityLocation = Location::find($entity->location_id); 
                    if(!$entityLocation){
                        return  false;
                    }else{
                        return  $user->inMyLocation($entityLocation);    
                    }
               }else{
                    return  true;
               }
            }

        }else{
            return  false;
        }   
        
    }



    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\User  $user
     * @param  \App\Setting  $model
     * @return mixed
     */
    public function update(User $user, Setting $model)
    {
        
        if($user->isSuperAdmin()){
            return true;
        }else if($user->isAdmin()){


            if(!$user->location){
                return false;
            }
            if(!$model->location){

                return $model->getKey() == $user->location->getKey();
            }   
            return $user->inMyLocation($model->location);

            return false;
        }        
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User  $user
     * @param  \App\Setting  $model
     * @return mixed
     */
    public function delete(User $user, Setting $model)
    {
        if($user->isSuperAdmin()){
            return true;
        }else {
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
