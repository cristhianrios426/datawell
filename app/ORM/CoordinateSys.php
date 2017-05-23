<?php
namespace App\ORM;
class CoordinateSys extends Setting
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'coordinates_sys';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}