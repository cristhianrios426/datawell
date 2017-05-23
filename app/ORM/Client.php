<?php
namespace App\ORM;
class Client extends Setting
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $dates = ['deleted_at','created_at', 'updated_at'];
    protected $table = 'clients';
}
