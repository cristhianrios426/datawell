<?php
namespace App\ORM;
use App\ORM\locationable;
class Block extends Setting implements locationable
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	use LocationTrait;
    protected $fillable = [];
    protected $dates = ['deleted_at','created_at', 'updated_at'];
    protected $table = 'blocks';
}
