<?php
namespace App\ORM;
class CoordinateSys extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'coordinates_sys';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}