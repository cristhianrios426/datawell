<?php
namespace App\ORM;
use App\Util\Helpers;
use App\ORM\ApproveTrait;
use App\ORM\User;
class Attachment extends BaseModel
{
     use \Illuminate\Database\Eloquent\SoftDeletes;
	   use ApproveTrait;

    const STATE_DRAFT = 1;
    const STATE_APPROVING = 2;
    const STATE_ACTIVE = 4;

	   
    protected $fillable = [];
    protected $table = 'attachments';
    protected $dates = ['deleted_at','created_at', 'updated_at', 'approved_at'];

   	public function path($path = NULL){
   		if($path){
   			return storage_path('app/attachments/'.$path);
   		}else{
   			return storage_path('app/attachments');
   		}
   	}

    public function filename(){
      return $this->path($this->file);
    }

    public function serve(){
      return Helpers::serveFile($this->file, $this->path(), $this->name);
    }

   	public function attachable()
    {
      
        return $this->morphTo();
    }

    
}
