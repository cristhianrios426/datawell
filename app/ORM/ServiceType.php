<?php
namespace App\ORM;
//use App\ORM\BusinessUnit;
class ServiceType extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'service_types';
    protected $dates = ['deleted_at','created_at', 'updated_at'];

    public function businessUnit(){
    	return $this->belongsTo(BusinessUnit::class, 'business_unit_id');
    }
}
