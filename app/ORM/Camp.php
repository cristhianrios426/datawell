<?php
namespace App\ORM;
class Camp extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'camps';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}