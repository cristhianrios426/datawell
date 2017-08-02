<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ServiceTypeRepository as Repository;
use App\Repository\BusinessUnitRepository;
use App\ORM\ServiceType as Model;
use App\ORM\BusinessUnit as BusinessUnit;
class ServiceTypesController extends SettingsController
{

    protected $repository;
    public $classname;
    public $entityName;
    public $entitiesName;
    public function __construct(){
        parent::__construct();
        $this->repository = new Repository();
        $this->classname = Model::class;

        $this->entityName ="service-type";
        $this->entitiesName ="service-types";
        \View::share ( 'entityName', $this->entityName);
        \View::share ( 'classname',$this->classname);
        \View::share ( 'entityLabel',  'tipo de servicio');
        \View::share ( 'entitiesLabel', 'tipos de servicio');

    }

    public function index(Request $request)
    {
        parent::index($request);   

        \DB::enableQueryLog();

        /**/

        $query = $request->all();
        $sorts = ['name', 'businessUnit.name'];
        $sortLinks  = Model::sortableLinks($query, $sorts);
        $this->repository->select($this->repository->getModel()->getTable().'.*');
        if($request->has('term')){
            $this->repository->where(function($q) use ($request, $sorts){
                $q
                ->where('name' , 'LIKE' , '%'.$request->input('term').'%')
                ->orWhereHas('businessUnit', function($q2) use ($request, $sorts){
                    $q2->where($q2->getModel()->getTable().'.name' , 'LIKE' , '%'.$request->input('term').'%');
                });
            });            
        }
        $this->repository->belongsToJoin('businessUnit');
        if($request->has('sort') && in_array($request->input('sort'), $sorts ) ){
            if($request->input('sort') == 'businessUnit.name'){
                $joinTable = $this->repository->getRelation('businessUnit')->getRelated()->getTable();
                $this->repository->orderBy($joinTable.'.name', $request->input('sort_type'));               
            }else{
                $this->repository->orderBy($request->input('sort'), $request->input('sort_type') );
            }
        }

        $this->repository->with('businessUnit');
        $models = $this->repository->paginate(20);
        if (request()->wantsJson()){
            return response()->json($models);
        }
        return view($this->entitiesName.'.index', compact('models', 'query', 'sortLinks'));
    }

    public function form($request, $id = null){
        if($id == null){
            $model = new Model();
        }else{
            $model = $this->repository->whereKey($id)->first();
        }
        if(!$model){
            \App::abort(404);
        }
        if($model->exists){
            \Auth::user()->canOrFail('update', $model);
        }else{
            \Auth::user()->canOrFail('create', '\App\ORM\ServiceType');
        }

        $data = array(        
            'businessUnits' => BusinessUnit::all(),            
            'model' => $model
        );
        return view($this->entitiesName.'.create', $data);
    }

    public function create(Request $request){
        return $this->form($request);
    }

    public function edit(Request $request, $id){
        return $this->form($request, $id);
       
    }


    
    public function store(Request $request)
    {   

         $input = $request->all();
        if(!$request->has('business_unit_id')){
            return response()->json( ['messages'=>['messages'=> ['La unidad de negocios es obligatoria'], 'type'=>'danger']] , 422);
        }
        
        if($request->input('business_unit_id') == 'new'){
           
            $repositoryUnit = new BusinessUnitRepository();            
            try {
               $repositoryUnit->save((new BusinessUnit), $request->input('business_unit', []) );
               $input['business_unit_id'] = $repositoryUnit->getEntity()->getKey();
            } catch (\App\Repository\Exception\ValidatorException $e) {  
                $m = $e->validator->messages()->all();              
                array_unshift($m, 'Errores de unidad de negocios');
                return response()->json( ['messages'=>['messages'=>array_values($m ), 'type'=>'danger']] , 422);
            }
        }

        

        try {
            $this->repository->save((new Model), $input);

            return response()->json( ['messages'=>['messages'=>['Cambios almacenados. Redireccionando...'], 'type'=>'success']] , 200);

           
        } catch (\App\Repository\Exception\ValidatorException $e) {
            
            return response()->json( ['messages'=>['messages'=>array_values($e->validator->messages()->all() ), 'type'=>'danger']] , 422);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $model,
            ]);
        }

        return view($this->entitiesName.'.show', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $this->classnameUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        
        $input = $request->all();
        if(!$request->has('business_unit_id')){
            return response()->json( ['messages'=>['messages'=> ['La unidad de negocios es obligatoria'], 'type'=>'danger']] , 422);
        }
        
        if($request->input('business_unit_id') == 'new'){
           
            $repositoryUnit = new BusinessUnitRepository();            
            try {
               $repositoryUnit->save((new BusinessUnit), $request->input('business_unit', []) );
               $input['business_unit_id'] = $repositoryUnit->getEntity()->getKey();
            } catch (\App\Repository\Exception\ValidatorException $e) {  
                $m = $e->validator->messages()->all();              
                array_unshift($m, 'Errores de unidad de negocios');
                return response()->json( ['messages'=>['messages'=>array_values($m ), 'type'=>'danger']] , 422);
            }
        }

        try {
            $model = $this->repository->whereKey($id)->first();            
            $this->repository->save($model, $input);
            return response()->json( ['messages'=>['messages'=>['Cambios almacenados. Redireccionando'], 'type'=>'success']] , 200);
           
        } catch (\App\Repository\Exception\ValidatorException $e) {

           return response()->json( ['messages'=>['messages'=>array_values($e->validator->messages()->all() ), 'type'=>'danger']] , 422);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */

}
