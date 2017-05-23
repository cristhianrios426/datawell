<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\OperatorRepository;
use App\ORM\Operator;
class OperatorsController extends SettingsController
{
    protected $repository;

    public $classname;
    public $entityName;
    public $entitiesName;

    public function __construct(){
        parent::__construct();
        $this->repository = new OperatorRepository();
        $this->classname = \App\ORM\Operator::class;
        
        $this->entityName ="operator";
        $this->entitiesName ="operators";
        \View::share ( 'entityName',  'operator');
        \View::share ( 'classname',$this->classname);
        \View::share ( 'entityLabel',  'operador');
        \View::share ( 'entitiesLabel', 'operadores');
        
    }

    public function index(Request $request)
    {
        parent::index($request);  
        $query = $request->all();
        $sorts = ['name'];
        $sortLinks  = Operator::sortableLinks($query, $sorts);

        /**/

        if($request->has('term')){
            $this->repository->term($sorts, $request->input('term'));
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
            $model = new Operator();            
        }else{
            $model = $this->repository->whereKey($id)->first();
        }
        if(!$model){
            \App::abort(404);
        }
        if($model->exists){
            \Auth::user()->canOrFail('update', $model);
        }else{
            \Auth::user()->canOrFail('create', $this->classname);
        }
        
        $data = array(            
            'model'=>$model
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
    
}
