<?php
namespace App\ORM;
use \Illuminate\Database\Eloquent\SoftDeletes;
class IdeType extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
	protected $dates = ['deleted_at','created_at', 'updated_at'];
    protected $fillable = [];
    protected $table = 'ide_types';
}
