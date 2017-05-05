<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ServiceTypeRepository;
use App\ORM\ServiceType as ServiceType;
use App\ORM\BusinessUnit as BusinessUnit;
class ServiceTypesController extends Controller
{

    protected $repository;
     public $classname;
    public $entityName;
    public $entitiesName;
    public function __construct(){
        $this->repository = new ServiceTypeRepository();
        $this->classname = ServiceType::class;

        $this->entityName ="service-type";
        $this->entitiesName ="service-types";
        \View::share ( 'entityName', $this->entityName);
        \View::share ( 'entityLabel',  'tipo de servicio');
        \View::share ( 'entitiesLabel', 'tipos de servicio');

    }

    public function index(Request $request)
    {   
            

        $query = $request->all();
        $sorts = ['name'];
        $sortLinks  = ServiceType::sortableLinks($query, $sorts);

        $this->repository->with('businessUnit');

        if($request->has('term')){
            $this->repository->where(function($q) use ($request, $sorts){
                $q->term($sorts, $request->input('term'))
                ->orWhereHas('businessUnit', function($q2) use ($request, $sorts){
                    $q2->where('name' , 'LIKE' , '%'.$request->input('term').'%');
                });
            });            
        }
        if($request->has('sort') && in_array($request->input('sort'), $sorts ) ){
            $this->repository->orderBy($request->input('sort'), $request->input('sort_type', 'desc'));
        } 
        $models = $this->repository->paginate(20);
        if (request()->wantsJson()) {
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

         try {
            $this->repository->save((new $this->classname), $request->all());

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

        try {
            $model = $this->repository->whereKey($id)->first();
            //dd($model);
            $this->repository->save($model, $request->all());

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
    public function destroy($id)
    {
        $model = $this->repository->whereKey($id)->first();
        if(request()->wantsJson()) {            
            $d =  $model->delete($id);
            return response()->json( ['messages'=>['messages'=>['Eliminaci&oacute;n completa. Redireccionando'], 'type'=>'success']] , 200);
        }
        return \View::make($this->entitiesName.'.delete',['model'=>$model]);
    }
}
