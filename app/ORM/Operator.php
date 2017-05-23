<?php
namespace App\ORM;
class Operator extends Setting
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'operators';
    protected $dates = ['deleted_at','created_at', 'updated_at'];
}
