<?php
namespace App\ORM;
class Area extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'areas';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}
