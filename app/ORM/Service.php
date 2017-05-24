<?php
namespace App\ORM;
use App\ORM\ApproveTrait;
use App\ORM\User;
use App\ORM\Location;
class Service extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use ApproveTrait;
    const STATE_APPROVING = 1;
    const STATE_REVIEWING= 2;

    protected $fillable = [];
    protected $table = 'services';
    protected $dates = ['deleted_at','created_at', 'updated_at'];

    public function type(){
    	return $this->belongsTo('App\ORM\ServiceType', 'service_type_id')->withTrashed();
    }

    public function section(){
    	return $this->belongsTo('App\ORM\Section', 'section_id')->withTrashed();
    }

    public function well(){
    	return $this->belongsTo('App\ORM\Well', 'well_id')->withTrashed();
    }

    public function attachments()
    {
        return $this->morphMany('App\ORM\Attachment', 'attachable');
    }   

    public function assignedTo(){
        return $this->belongsTo(  User::class, 'assigned_to');
    }

    public function createdBy(){
        return $this->belongsTo(  User::class, 'created_by');
    }

    public function approvedBy(){
        return $this->belongsTo(  User::class, 'approved_by');
    }

    public function routeToAttachment($id){
        return route('service.attachment', ['id'=>$this->getKey(), 'aid'=>$id]);
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    public function scopeFilterUser($q, $user){
        if($user->isClient()){
            $q->where('client_id', $user->getKey());
            $q->where('approved', 1);
        }else{
            $q->where(function($innerq) use ($user){
                $innerq
                    ->where('draft', 0)
                    ->orWhere(function($subq) use ($user){
                        $subq
                            ->where('draft', 1)
                            ->where('created_by', $user->getKey());
                    }); 
            });
        }
        return $q;
    }


}
