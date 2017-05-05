<?php 
namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseModel extends Model{

	public function newCollection(array $models = [])
    {
        return new Collection($models);
    }

    public function scopeVacum($q){
    	return $q;
    }

    public static function sortableLinks($query, $sorts){    	
        $sortLinks = [];
        foreach ($sorts as $key => $sort) {          
            $sortLinks[$sort] = [];
            $active = isset($query['sort']) && $query['sort'] == $sort ? true : false;
            $params = [];
            $params['sort'] = $sort;
            if($active && isset($query['sort_type'])){
                $params['sort_type'] =  $query['sort_type'] == 'asc' ? 'desc' : 'asc'; 
            }else{
                $params['sort_type'] = 'asc';
            }
            $sortLinks[$sort] = [
                'url'=>route(kebab_case(class_basename(static::class)).'.index', array_merge($query, $params) ),
                'type'=>($active ? 'sort-'.$query['sort_type'] : 'sort' ),
            ]; 
        }

        return  $sortLinks;
    }

    // public function addVisible($attrs){
    //     if(!is_array($attrs)){
    //         $attrs = array($attrs);
    //     }
    //     $this->visible = array_merge($this->visible,$attrs);
    // }

    // public function addHidden($add){
    //     if(!is_array($add)){
    //         $add = array($add);
    //     }
    //     $this->hidden = array_merge($this->hidden,$add);
    // }

    public function removeHidden($removes){
        if(!is_array($removes)){
            $removes = array($removes);
        }
        foreach ($removes as $key => $remove) {
            foreach ($this->hidden as $key2 => $hidden) {
                if($hidden == $remove){
                    unset($this->hidden[$key2]);
                    unset($removes[$key]);
                    break;
                }
            }
        }           
    }

    public function addAppends($add){
        if(!is_array($add)){
            $add = array($add);
        }
        $this->appends = array_merge($this->appends,$add);          
    }

    public function removeAppends($removes){
        if(!is_array($removes)){
            $removes = array($removes);
        }
        foreach ($removes as $key => $remove){
            foreach ($this->appends as $key2 => $append) {
                if($append == $remove){
                    unset($this->appends[$key2]);
                    unset($removes[$key]);
                    break;
                }
            }
        }                   
    }

    public function scopePaginator($q, $page = null, $perPage = null){

        if($page == null){
            $page = 1;
        } 
        if($perPage == null){
            $perPage= 30;
        }
        $count = $q->count();
        $totalPages = floor($count / $perPage);
        $totalPages = (($count / $perPage) - $totalPages) > 0 ? $totalPages + 1 : $totalPages;          
        
        $page = $page < 1 ? 1 : $page;
        $page = $page > $totalPages ? $totalPages : $page;

        $skip = ($page - 1)  * $perPage;
        $take = $perPage;
        $q->skip($skip);
        $q->take($take);

        $paginator = new \Util\Object;
        $collection = $q->get();
        
        $paginator->data =$collection;
        $paginator->count = $collection->count();
        $paginator->total = $count;
        $paginator->page = $page;
        $paginator->totalPages = $totalPages;

        return $paginator;

    }
         
    public function scopeFulltext($query, $fields, $search){
        return $query
                    //->select('*')
                    ->whereRaw("MATCH(".$fields.") AGAINST ('".$search."')")
                    ->orderBy(DB::raw("MATCH(".$fields.") AGAINST ('".$search."')"), 'DESC');
                    //->selectRaw("* , MATCH(".$fields.") AGAINST ('".$search."') as re");
    }

    public function scopeTerm($query, $fields, $term){
        
        $query->where(function($q) use ($fields, $term){
            $i = 0;
            foreach ($fields as $key => $field) {
                $method = $i == 0 ? 'where' : 'orWhere';
                $q->{$method}($field, 'LIKE', '%'.$term.'%');
                $i++;
            }
        });
        return $query;
    }

    public function scopeAddWith($query , $requestedWith,  $allowedWith){
        foreach ($requestedWith as $key => $with) {
            if(in_array($with, $allowedWith)){
                $query->with($with);
            }       
        }
        return $query;
    }

    public function scopeWhereKey($q, $key){
        $q->where($q->getModel()->getTable().'.'.$q->getModel()->getKeyName(), $key);
        return $q;
    }

}