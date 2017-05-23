<?php
namespace App\ORM;
use App\ORM\locationable;
class Area extends Setting implements locationable
{
	use LocationTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'areas';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}
