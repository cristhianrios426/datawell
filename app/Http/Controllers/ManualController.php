<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ManualRepository as Repository;
use App\ORM\Manual as Model;
class ManualController extends SettingsController
{
    protected $repository;
    public $classname;
    public $entityName;
    public $entitiesName;

    public function __construct(){
        parent::__construct();
        $this->repository = new Repository();
        $this->classname = Model::class;
        
        $this->entityName ="manual";
        $this->entitiesName ="manuals";
        \View::share ( 'classname',$this->classname);
        \View::share ( 'entityLabel',  'Manual');
        \View::share ( 'entitiesLabel', 'Manuales');
        \View::share ( 'entityName', $this->entityName);
    }

    public function index(Request $request)
    {
        parent::index($request); 

        $query = $request->all();
        $sorts = ['role_id', 'name', 'file'];
        $sortLinks  = $this->classname::sortableLinks($query, $sorts);

        /**/

        if($request->has('term')){
            $this->repository->term([], $request->input('term'));
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

    public function download(Request $request, $id)
    {
        $user = \Auth::user();
        try {
            $model = $this->repository->whereKey($id)->first();            
            if($model && $user->can('download', $model)){
                if(!\File::isFile(storage_path('app/manual/'.$model->file) ) ){
                    return "File not found";
                }
                return response()->download(storage_path('app/manual/'.$model->file), ($model->client_file != '' ? $model->client_file : $model->file) );
            }
        } catch (\App\Repository\Exception\ValidatorException $e) {

           return response()->json( ['messages'=>['messages'=>array_values($e->validator->messages()->all() ), 'type'=>'danger']] , 422);
        }
    }

    public function list(Request $request)
    {
        $user = \Auth::user();
        $models = Model::where('role_id', $user->role_id)->get();
        return \View::make('manuals.list', [
            'models'=>$models
        ]);
    }
}
