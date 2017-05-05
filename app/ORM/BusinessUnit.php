<?php
namespace App\ORM;
//use ServiceType;
class BusinessUnit extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'business_units';
    protected $dates = ['deleted_at','created_at', 'updated_at'];

    public function serviceTypes(){
    	return $this->hasMany(ServiceType::class, 'business_unit_id');
    }
}
