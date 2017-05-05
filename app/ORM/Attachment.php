<?php
namespace App\ORM;
use App\Util\Helpers;
class Attachment extends BaseModel
{
	use \Illuminate\Database\Eloquent\SoftDeletes;


	
    protected $fillable = [];
    protected $table = 'attachments';
    protected $dates = ['deleted_at','created_at', 'updated_at'];

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
