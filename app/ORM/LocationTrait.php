<?php
namespace App\ORM;
use App\ORM\Location;
trait LocationTrait{
	public function location()
	{
	    return $this->belongsTo(Location::class, 'location_id')->withTrashed();
	}
	public function scopeInLocation($q, $location){
		$q->whereHas('location', function($q2) use ($location){
			$q2->where('index_search', 'LIKE', $location->index_search.'%');
		});
		return $q;
	}

	public function scopeInUserLocation($q, $user){
		return $q->inLocation($user->location);
	}
	public function inLocation(Location $location){		
		if(!$this->location){
			return false;
		}

		return strpos($this->location->index_search, $location->index_search) === 0;
	}

	public function inMyLocation(Location $location){		
		if(!$this->location){
			return false;
		}
		return strpos($location->index_search, $this->location->index_search) === 0;
	}
}
	