<?php 
namespace App\ORM;
class Revision extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $dates = ['deleted_at','created_at', 'updated_at'];
    protected $table = 'revisions';

    public function revisable(){
    	return $this->morphTo();
    }
    
}
