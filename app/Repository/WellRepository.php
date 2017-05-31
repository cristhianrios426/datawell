<?php 
namespace App\Repository;
use App\ORM\Well;
use App\ORM\Location;
class WellRepository extends Base{

	protected $fillable = [
		'name',
		'x',
		'y',
		'z',		
		'profundidad_tvd',
		'profundidad_md',
		'well_kb_elev',
		'rotaty_elev',
		'cuenca_id',
		'camp_id',
		'area_id',
		'block_id',
		'well_type_id',
		'operator_id',
		'location_id',
		'deviation_id',
		'ref_cor_sis_id',
		'drilled_at',
		'lat',
		'long',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Well::class;
	}
	public function getRules($input){
		$rules =  [
			'name'=>'required',
			'x'=>'sometimes|numeric|nullable',
			'y'=>'sometimes|numeric|nullable',
			'z'=>'sometimes|numeric|nullable',
			'location_id'=>'required|exists_eloquent:\\App\\ORM\\Location',			
			'profundidad_tvd'=>'sometimes|numeric|nullable',
			'profundidad_md'=>'sometimes|numeric|nullable',
			'well_kb_elev'=>'sometimes|numeric|nullable',
			'rotaty_elev'=>'sometimes|numeric|nullable',
			'ref_cor_sis_id'=>'sometimes|exists_eloquent:\\App\\ORM\\CoordinateSys',
			'cuenca_id'=>'required|exists_eloquent:\\App\\ORM\\Cuenca',
			'camp_id'=>'required|exists_eloquent:\\App\\ORM\\Camp',
			'area_id'=>'required|exists_eloquent:\\App\\ORM\\Area',
			'block_id'=>'required|exists_eloquent:\\App\\ORM\\Block',
			'well_type_id'=>'required|exists_eloquent:\\App\\ORM\\WellType',
			'deviation_id'=>'required|exists_eloquent:\\App\\ORM\\Deviation',
			'operator_id'=>'required|exists_eloquent:\\App\\ORM\\Operator',
			'drilled_at'=>'required|date',
		];
		

		return $rules;
	}
	public function filter($request){
		if($request->has('term')){
			$sorts = ['name'];
            $this->term($sorts, $request->input('term'));
        }
        if($request->has('sort') && in_array($request->input('sort'), $sorts ) ){
            $this->orderBy($request->input('sort'), $request->input('sort_type', 'desc'));
        }

        $location = NULL;
        foreach (['country_id', 'state_id', 'city_id'] as $key => $current_location){
        	if($request->has($current_location) && $request->input($current_location) != ''){
        		$testLocation = Location::find($request->input($current_location));
        		if($testLocation){
        			$location = $testLocation;
        			break;
        		}
        	}
        }
        if( $location){
        	$this->inLocation($location);
        }

        $listCriteria = ['area_id','operator_id','camp_id','well_type_id', 'cuenca_id', 'deviation_id']; 
        foreach ($listCriteria as $key => $criteria) {
            if($request->input($criteria, false) != false){
                $value = $request->input($criteria); 

                if(count($value) > 0){
                	foreach ($value as $key => $v) {
                		if($v == NULL){
                			unset($value[$key]);
                		}
                	}
                	if(count($value) > 0){
                		$this->whereIn($criteria, $value);                		
                	}
                }
            }
        }


        if($request->input('name', '') != ''){
            $this->where('name','LIKE', '%'.$request->input('name').'%');
        }

        if($request->has('profundidad_tvd')){
        	$numbers = $request->input('profundidad_tvd');
        	$range = explode(',',$numbers );
        	$this->where('profundidad_tvd', '>=', $range[0])->where('profundidad_tvd', '<', $range[1]);
        }
        $byServices = false;
        foreach (['service_type_id', 'ended_at', 'section_id'] as $key => $value) {
        	if($request->has($value)){
        		$byServices = true;
        		break;
        	}
        }
        if($byServices){
        	$this->whereHas('services', function($q) use ($request){
        		$table = $q->getModel()->getTable();
        		if($request->has('service_type_id') && is_array($request->input('service_type_id')) ){
        			$q->whereIn($table.'.service_type_id', $request->input('service_type_id'));
        		}
                if($request->has('section_id') && is_array($request->input('section_id')) ){
                    $q->whereIn($table.'.section_id', $request->input('section_id'));
                }
        		if($request->has('ended_at')){
        			$range = $request->input('ended_at');
        			$rangeArray = explode(' - ', $range);
        			$from = $rangeArray[0];
        			$to = $rangeArray[1];

        			$q->where($table.'.ended_at', '>=', $from);
        			$q->where($table.'.ended_at', '<=', $to);
        		}
        	});
        }        
	}
}