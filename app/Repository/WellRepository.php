<?php 
namespace App\Repository;
use App\ORM\Well;
class WellRepository extends Base{

	protected $fillable = [
		'name',
		'x',
		'y',
		'z',
		'id_ref_cor_sis',
		'profundidad_tvd',
		'profundidad_md',
		'well_kb_elev',
		'rotaty_elev',
		'id_cuenca',
		'id_camp',
		'id_area',
		'id_block',
		'id_well_type',
		'id_operator',
		'id_deviation',
		'drilled_at',
		'lat',
		'long',
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) Well::class;
	}
	public function getRules($input){
		return [
			'name'=>'required',
			'x'=>'sometimes|numeric|nullable',
			'y'=>'sometimes|numeric|nullable',
			'z'=>'sometimes|numeric|nullable',
			'id_ref_cor_sis'=>'sometimes|exists_eloquent:\\App\\ORM\\CoordinateSys|nullable',
			'profundidad_tvd'=>'sometimes|numeric|nullable',
			'profundidad_md'=>'sometimes|numeric|nullable',
			'well_kb_elev'=>'sometimes|numeric|nullable',
			'rotaty_elev'=>'sometimes|numeric|nullable',
			'id_cuenca'=>'sometimes|exists_eloquent:\\App\\ORM\\Cuenca|nullable',
			'id_camp'=>'sometimes|exists_eloquent:\\App\\ORM\\Camp|nullable',
			'id_area'=>'sometimes|exists_eloquent:\\App\\ORM\\Area|nullable',
			'id_block'=>'sometimes|exists_eloquent:\\App\\ORM\\Block|nullable',
			'id_well_type'=>'sometimes|exists_eloquent:\\App\\ORM\\WellType|nullable',
			'id_deviation'=>'sometimes|exists_eloquent:\\App\\ORM\\Desviation|nullable',
			'drilled_at'=>'sometimes|date|nullable',

		];
	}

	public function filter($request){
		if($request->has('term')){
			$sorts = ['name'];
            $this->term($sorts, $request->input('term'));
        }
        if($request->has('sort') && in_array($request->input('sort'), $sorts ) ){
            $this->orderBy($request->input('sort'), $request->input('sort_type', 'desc'));
        }

        $listCriteria = ['id_area','id_operator','id_camp','id_well_type', 'id_cuenca']; 
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
        $byServices = false;
        foreach (['id_service_type', 'ended_at'] as $key => $value) {
        	if($request->has($value)){
        		$byServices = true;
        		break;
        	}
        }
        if($byServices){
        	$request->whereHas('services', function($q) use ($request){
        		$table = $q->getModel()->getTable();
        		if($request->has('id_service_type') && is_array($request->input('id_service_type')) ){
        			$q->whereIn($table.'.id_service_type', $request->input('id_service_type'));
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