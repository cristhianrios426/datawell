<?php
namespace App\ORM;
use App\ORM\User;
use App\ORM\Location;
use App\ORM\ApproveTrait;

class Well extends BaseModel
{
    const STATE_APPROVING = 1;
    const STATE_REVIEWING= 2;
	use \Illuminate\Database\Eloquent\SoftDeletes, LocationTrait;
	use ApproveTrait;
    protected $fillable = [];
    protected $table = 'wells';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];

    public function attachments()
    {
        return $this->morphMany('App\ORM\Attachment', 'attachable');
    }


    public function getSectionsNamesAttribute(){
        return $this->sectionsNames();
    }
    public function sectionsNames(){
        $sections = [];
        foreach ($this->services as $key => $service){
            if(!in_array($service->section->name,$sections) ){
                $sections[] = $service->section->name;
            }
        }
        return $sections;
    }

    public function getServiceTypesNamesAttribute(){
        return $this->serviceTypesNames();
    }

    public function markerUrl(){
        $type = $this->type;
        if($type){
            return $type->getMarkerUrl();
        }else{
            return \App\ORM\WellType::markerUrl();
        }

    }

    public function serviceTypesNames(){
        $serviceTypes = [];
        foreach ($this->services as $key => $service){
            if(!in_array($service->type->name,$serviceTypes) ){
                $serviceTypes[] = $service->type->name;
            }
        }
        return $serviceTypes;
    }

    public function type(){
    	return $this->belongsTo('App\ORM\WellType', 'well_type_id')->withTrashed();
    }

    public function operator(){
    	return $this->belongsTo('App\ORM\Operator', 'operator_id')->withTrashed();
    }

     public function area(){
    	return $this->belongsTo('App\ORM\Area', 'area_id')->withTrashed();
    }
    public function cuenca(){
    	return $this->belongsTo('App\ORM\Cuenca', 'cuenca_id')->withTrashed();
    }
	public function camp(){
    	return $this->belongsTo('App\ORM\Camp', 'camp_id')->withTrashed();
    }

    public function block(){
    	return $this->belongsTo('App\ORM\Block', 'block_id')->withTrashed();
    }

    public function deviation(){
    	return $this->belongsTo('App\ORM\Deviation', 'deviation_id')->withTrashed();
    }

    public function coorSys(){
    	return $this->belongsTo('App\ORM\CoordinateSys', 'ref_cor_sis_id')->withTrashed();
    }
    public function services(){
        return $this->hasMany('App\ORM\Service', 'well_id');
    }

    public function routeToAttachment($id){
        return route('well.attachment', ['id'=>$this->getKey(), 'aid'=>$id]);
    }

    public function createdBy(){
        return $this->belongsTo(  User::class, 'created_by');
    }
    public function scopeNoAuthenticated($q){
        return $q->where('approved', 1)->where('draft',0);
    }
    // public function scopeFilterUser($q, $user){
    //     $table = $q->getModel()->getTable();
    //     if($user->isClient()){
    //         $q->whereHas('services', function($q2) use ($user){
    //             $q2->filterUser($user);                
    //             return $q2;
    //         });
    //         $q->where('approved', 1);
    //     }else{
    //         $q->where(function($innerq) use ($user, $table){
    //             $innerq
    //                 ->where(function($innerq2) use ($user, $table){
    //                     $innerq2->where($table.'.draft', '!=', 1);
    //                     $innerq2->orWhere(function($innerq3) use ($user, $table){
    //                         $innerq3
    //                             ->where($table.'.draft',1)
    //                             ->where($table.'.created_by', $user->getKey());
    //                     });
    //                 });
                    
    //             if($user->isAdmin()){
    //                 $innerq->orWhere('location_id', $user->location->getKey());                   
    //             }elseif(!$user->isSuperAdmin()){                    
    //                  $innerq->orWhere(function($innerq2) use ($user, $table) {
    //                     $innerq2->where(function($subq) use ($user, $table){
    //                         $subq->where($table.'.approved','!=', 1)->where($table.'.assigned_to', $user->getKey());  
    //                     })
    //                     ->orWhere(function($subq) use ($user, $table){
    //                         $subq->where($table.'.approved','!=', 1)->where($table.'.sent_by', $user->getKey());  
    //                     })
    //                     ->orWhere(function($subq) use ($user, $table){
    //                         $subq->where($table.'.approved','=', 1);  
    //                     }); 
    //                 });
    //             }   
    //         });
    //     }
    //     return $q;
    // }

    public function scopeFilterUser($q, $user){
        $table = $q->getModel()->getTable();  
        if($user->isClient()){
            $q->whereHas('services', function($q2) use ($user,$table){
                 $q2->filterUser($user);                
                 return $q2;
            })
            ->where($table.'.'.'approved',1);
        }else{
            $q->where($table.'.'.'id', '>', 0);
            $q->orWhere(function($q3) use ($user, $table){
                $q3->where($table.'.'.'draft', 1)->where($table.'.'.'created_by', $user->getKey());
            });     
            if(!$user->isSuperAdmin() && !$user->isAdmin()){
                $q->orWhere(function($q2) use ($user, $table){
                    $q2->aprovingUser($user);                    
                })                
                ->orWhere($table.'.'.'approved', 1);
            }     

        }
    }

           

}
