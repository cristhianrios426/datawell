<?php
namespace App\ORM;
class Operator extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'operators';
    protected $dates = ['deleted_at','created_at', 'updated_at'];
}
