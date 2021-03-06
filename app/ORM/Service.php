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
    protected $dates = ['deleted_at', 'started_at', 'ended_at'];

    public function type(){
    	return $this->belongsTo('App\ORM\ServiceType', 'service_type_id')->withTrashed();
    }

    public function section(){
    	return $this->belongsTo('App\ORM\Section', 'section_id')->withTrashed();
    }
    
    public function well(){
        return $this->belongsTo('App\ORM\Well', 'well_id')->withTrashed();
    }

    public function client(){
    	return $this->belongsTo('App\ORM\Client', 'client_id')->withTrashed();
    }

    public function attachments()
    {
        return $this->morphMany('App\ORM\Attachment', 'attachable');
    }
    
    public function createdBy(){
        return $this->belongsTo(  User::class, 'created_by');
    }

    public function routeToAttachment($id){
        return route('service.attachment', ['id'=>$this->getKey(), 'aid'=>$id]);
    }


    public function scopeFilterUser($q, $user){ 
        $table = $q->getModel()->getTable();       
        if($user->isClient()){
            $q->where($table.'.'.'client_id', $user->client_id)
            ->where($table.'.'.'approved',1);
        }else{
            $q->where('id', '>', 0);
            $q->orWhere(function($q3) use ($user, $table){
                $q3->where($table.'.'.'draft', 1)->where($table.'.'.'created_by', $user->getKey());
            });     
            if(!$user->isSuperAdmin() && !$user->isAdmin()){
                $q->orWhere(function($q2) use ($user){
                    $q2->aprovingUser($user);                    
                })                
                ->orWhere($table.'.'.'approved', 1);
            }           
        }
    }


}
