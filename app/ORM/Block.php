<?php
namespace App\ORM;
class Block extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $dates = ['deleted_at','created_at', 'updated_at'];
    protected $table = 'blocks';
}
