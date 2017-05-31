<?php

namespace App\Policies;
use App\ORM\User;
use App\ORM\Location;
use App\ORM\Attachment;
use App\ORM\Well;
use App\ORM\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    

    //  public function delete(User $user, Attachment $model)
    // {
    //     if(  $user->isSuperAdmin()){
    //         return true;
    //     }
        

    //     if($user->isSupervisor()){
    //         $authorized = $model->isAssignedTo($user) && $model->approved != 1;    
    //     }else if($user->isEngineer()){
    //         $authorized =  $model->createdBy &&  $model->createdBy->getKey() == $user->getKey() && $model->approved != '';    
    //     }else if($user->isSuperAdmin()){
    //         $authorized = true;
    //     }else if($user->isAdmin()){

    //         $attachable = $model->attachable;
    //         if(!$attachable){
    //             return false;
    //         }
    //         if($attachable instanceof Well){
    //             $location = $attachable->location;
    //         }else{
    //             $location = $attachable->well->location;
    //         }
    //         if(!$location){
    //             return false;
    //         }
    //         return  ($location->inLocation($user->location) &&  $model->approved != 1);
    //     }else{
    //         return  false;
    //     }
        
    // }

    public function delete($user, $model){

        if(!$model->attachable){
            return false;
        }

        $attachable = $model->attachable;        
        if($user->isSuperAdmin()){
            return true; 
        }elseif($user->isAdmin()){
            if(str_contains(get_class($attachable), 'Well') ){
                $location = $attachable->location;
            }else{
                $location = $attachable->well->location;
            }
            return $location->inLocation($user->location);
        }
        if($attachable->approveable() &&  $attachable->assignedTo && $attachable->assignedTo->getKey() == $user->getKey()  && $model->approved != 1)
        {            
            return true;
        }
        if($attachable->approveable() && $attachable->reviewing() && $attachable->sentBy && $attachable->sentBy->getKey() == $user->getKey() && $model->approved != 1){            
            return true;
        }
        return false;
    }
}
