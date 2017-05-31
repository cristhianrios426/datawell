<?php
namespace App\ORM;
class Deviation extends Setting
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'deviations';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'drilled_at'];
}