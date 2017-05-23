<?php
namespace App\ORM;
use App\ORM\locationable;
class Cuenca extends Setting implements locationable
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use LocationTrait;
    protected $fillable = [];
    protected $table = 'cuencas';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}