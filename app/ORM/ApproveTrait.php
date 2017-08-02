<?php 
namespace App\ORM;
trait ApproveTrait{

	public function revisions(){
        return $this->morphMany('App\ORM\Revision', 'revisable');
    }
    
    public function approveable()
    {
        if($this->approved != 1) {
            return ($this->state == static::STATE_APPROVING  || $this->state == static::STATE_REVIEWING || $this->draft == 1 );
        }else{
            return true;
        }
        
    }

    public function blocked(){
    	return $this->approveable() && $this->state == static::STATE_REVIEWING;
    }

    public function approving(){
        return $this->approveable() && $this->state == static::STATE_APPROVING;
    }

    public function reviewing(){
        return $this->approveable() && $this->state == static::STATE_REVIEWING;
    }

    public function reviewable()
    {
        return $this->state == static::STATE_APPROVING  || $this->state == static::STATE_REVIEWING ;
    }

    public function isAssignedTo($user){
        return ($this->assignedTo && 
                $this->assignedTo->getKey() == $user->getKey());
    }

    public function wasSentTo($user){
        return ($this->sentBy && 
                $this->sentBy->getKey() == $user->getKey());
    }

    public function approveIfNeeded($user){       
        
           
        $this->draft = 0;
        $this->approved = 1;
        $this->state = 0;
        if( !$this->approvedBy){               
            $this->approved_by = $user->getKey();
            $this->approved_at = date('Y-m-d');
        }
        if( $this->assignedTo){               
            $this->assigned_to = NULL;
            $this->setRelation('assignedTo', NULL);
        }
        if( $this->sentBy){               
            $this->sent_by = NULL;
            $this->setRelation('sentBy', NULL);
        }
        
        
        return $this;
    }

    public function assignIfNeeded($user){
        $this->draft = 0;
        $this->approved = 1;
        if($this->approved_by == NULL || $this->approved_by < 1){
            $this->approved_by = $user->getKey();
            $this->setRelation('approvedBy', $user);
        }       
        return $this;
    }

    public function sendApprove($user){
        $this->state = static::STATE_APPROVING;
        $this->draft = 0;
        $this->sent_by = $user->getKey();   
        $this->setRelation('sentBy', $user);
    }

    public function assignedTo(){
        return $this->belongsTo(  User::class, 'assigned_to')->withTrashed();
    }

    public function sentBy(){
        return $this->belongsTo(  User::class, 'sent_by')->withTrashed();
    }

    public function approvedBy(){
            return $this->belongsTo(  User::class, 'approved_by')->withTrashed();
    }

    public function textState(){
        if ($this->approving()){
            $text = 'Aprobaci&oacute;n pendiente';
        }elseif ($this->reviewing()){
            $text = 'Revisi&oacute;n pendiente';
        }elseif ($this->state == \App\ORM\Well::STATE_APPROVING || $this->state == \App\ORM\Well::STATE_REVIEWING){
            $text = "Elementos pendiente por aprobar";
        }elseif($this->approved != 1){
            $text = "No aprobado";
        }elseif($this->draft == 1){
            $text = "Borrador";
        }else{
            $text = "Aprobado";
        }
        return $text;
    }

    public function scopeApproving($q, $user){
        $table = $q->getModel()->getTable();
        $q->where($table.'.state', static::STATE_APPROVING);             
    }

    public function scopeReviewing($q, $user){
        $table = $q->getModel()->getTable();
        $q->where(function($q2) use ($table, $user){
            $q2->where($user.'.sent_by', $user->getKey())->where($table.'.state', static::STATE_REVIEWING);
        });
    }

    public function createRevision($content){
        $revision = new Revision();
        $revision->content = $content;
        $this->revisions()->save($revision);
        $this->state = Well::STATE_REVIEWING;
        $this->save();
        return $revision;
    }

    public function scopePendingApprove($q, $user)
    {
        $table = $q->getModel()->getTable();
        $q->where($table.'.'.'state', static::STATE_APPROVING);
        if(!$user->isSuperAdmin()){
            $q->where($table.'.'.'assigned_to', $user->getKey()); 
        }
        return $q;
    }

    public function scopePendingReview($q, $user)
    {
        $table = $q->getModel()->getTable();
        $q->where($table.'.'.'state', static::STATE_REVIEWING);
        if(!$user->isSuperAdmin()){
            $q->where($table.'.'.'sent_by', $user->getKey()); 
        }
        return $q;
    }

    public function scopeAprovingUser($q, $user){
        $q->where(function($q0) use($user){
            $q0->where(function($q2) use($user){
                $q2->pendingReview($user);
            })
            ->orWhere(function($q3) use($user){
                $q3->pendingApprove($user);
            });
        });
    }
}