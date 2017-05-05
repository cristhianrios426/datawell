<?php
namespace App\ORM;
class Well extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'wells';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];

    public function attachments()
    {
        return $this->morphMany('App\ORM\Attachment', 'attachable');
    }

    public function type(){
    	return $this->belongsTo('App\ORM\WellType', 'id_well_type')->withTrashed();
    }

    public function operator(){
    	return $this->belongsTo('App\ORM\Operator', 'id_operator')->withTrashed();
    }

     public function area(){
    	return $this->belongsTo('App\ORM\Area', 'id_area')->withTrashed();
    }
    public function cuenca(){
    	return $this->belongsTo('App\ORM\Cuenca', 'id_cuenca')->withTrashed();
    }
	public function camp(){
    	return $this->belongsTo('App\ORM\Camp', 'id_camp')->withTrashed();
    }

    public function block(){
    	return $this->belongsTo('App\ORM\Block', 'id_block')->withTrashed();
    }

    public function deviation(){
    	return $this->belongsTo('App\ORM\Desviation', 'id_deviation')->withTrashed();
    }

    public function coorSys(){
    	return $this->belongsTo('App\ORM\CoordinateSys', 'id_ref_cor_sis')->withTrashed();
    }

    public function routeToAttachment($id){
        return route('well.attachment', ['id'=>$this->getKey(), 'aid'=>$id]);
    }
}
