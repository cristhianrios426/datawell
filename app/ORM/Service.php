<?php
namespace App\ORM;
class Service extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'services';
    protected $dates = ['deleted_at','created_at', 'updated_at'];

    public function type(){
    	return $this->belongsTo('App\ORM\ServiceType', 'id_service_type')->withTrashed();
    }

    public function section(){
    	return $this->belongsTo('App\ORM\Section', 'id_section')->withTrashed();
    }

    public function well(){
    	return $this->belongsTo('App\ORM\Well', 'id_well')->withTrashed();
    }

    public function attachments()
    {
        return $this->morphMany('App\ORM\Attachment', 'attachable');
    }

    public function routeToAttachment($id){
        return route('service.attachment', ['id'=>$this->getKey(), 'aid'=>$id]);
    }

    public function scopeFilterUser($q, $user){
        if($user->isClient()){
            $q->where('client_id', $user->getKey());
        }
        return $q;
    }
}
