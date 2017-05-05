<?php
namespace App\ORM;
class Cuenca extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'cuencas';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}