<?php
namespace App\ORM;
class WellType extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'well_types';
    protected $dates = ['deleted_at','created_at', 'updated_at'];
}
