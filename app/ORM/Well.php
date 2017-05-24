<?php
namespace App\ORM;
use App\ORM\User;
use App\ORM\Location;
use App\ORM\ApproveTrait;

class Well extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes, LocationTrait;
	use ApproveTrait;
    const STATE_APPROVING = 1;
    const STATE_REVIEWING= 2;


    protected $fillable = [];
    protected $table = 'wells';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];

    public function attachments()
    {
        return $this->morphMany('App\ORM\Attachment', 'attachable');
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
    	return $this->belongsTo('App\ORM\Desviation', 'deviation_id')->withTrashed();
    }

    public function coorSys(){
    	return $this->belongsTo('App\ORM\CoordinateSys', 'ref_cor_sis_id')->withTrashed();
    }

    public function revisions(){
        return $this->morphMany('App\ORM\Revision', 'revisable');
    }

    public function services(){
        return $this->hasMany('App\ORM\Service', 'well_id');
    }

    public function routeToAttachment($id){
        return route('well.attachment', ['id'=>$this->getKey(), 'aid'=>$id]);
    }

    public function approveable()
    {
        return ($this->approved != 1 || $this->attachments()->where('approved', 0)->count() > 0);
    }

    public function scopeApproveable($q)
    {  
       $q
        ->where('approved',0)
        ->orWhereHas('attachments', function($inneq){
            $table = $inneq->getModel()->getTable();
            $inneq->where($table.'.approved', 0);
        });
        return $q;
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

    public function scopeFilterUser($q, $user){

        if($user->isClient()){
            $q->whereHas('services', function($q2) use ($user){
                $q2->filterUser($user);                
                return $q2;
            });
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
