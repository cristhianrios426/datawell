<?php
namespace App\ORM;
class Desviation extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'desviations';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}