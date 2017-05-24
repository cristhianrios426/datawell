<?php 
namespace App\ORM;
trait ApproveTrait{
	public function revisions(){
        return $this->morphMany('App\ORM\Revision', 'revisable');
    }
    
    public function approveable()
    {
        return (
                ($this->state == static::STATE_APPROVING  || $this->state == static::STATE_REVIEWING  ) &&
                $this->approved != 1
            );
    }

    public function blocked(){
    	return $this->approveable() && $this->state == static::STATE_REVIEWING;
    }

    public function reviewable()
    {
        return ($this->approved != 1 || $this->attachments()->where('approved', 0)->count() > 0);
    }

    public function scopeApproveable($q)
    {  
       $q
        ->where('approved',0)
        ->orWhereHas('attachments', function($inneq){
            $table = $inneq->getModel()->getTable();
            $inneq->where($table.'.approved', 0);
        });
        return $q;
    }

    public function isAssignedTo($user){
        return ($this->assignedTo && 
                $this->assignedTo->getKey() == $user->getKey() && 
                $this->approved != 1 );
    }

    public function approveIfNeeded($user){       
        if( !$this->approvedBy || $this->approved != 1){
           
            $this->draft = 0;
            $this->approved = 1;
            if( !$this->approvedBy){
               
                $this->approved_by = $user->getKey();
            }
            $this->save();
        } 
        return $this;
    }

    public function assignIfNeeded($user){
        if ( !$this->approvedBy || $this->approved != 1){
            $this->draft = 0;
            $this->approved = 1;
            if($this->approved_by == NULL || $this->approved_by < 1){
                $this->approved_by = $user->getKey();
            }
        }
        return $this;
    }
}