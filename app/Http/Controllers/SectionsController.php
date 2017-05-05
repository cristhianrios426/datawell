<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\SectionRepository;
use App\ORM\Section;
class SectionsController extends Controller
{

    protected $repository;
    public $classname;
    public $entityName;
    public $entitiesName;

    public function __construct(){
        $this->repository = new SectionRepository();
        $this->classname = \App\ORM\Section::class;

        $this->entityName ="section";
        $this->entitiesName ="sections";
        \View::share ( 'entityName',  'section');
        \View::share ( 'entityLabel',  'sección');
        \View::share ( 'entitiesLabel', 'secciones');

        
    }

    public function index(Request $request)
    {   
        $query = $request->all();
        $sorts = ['name'];
        $sortLinks  = Section::sortableLinks($query, $sorts);

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
        return view('sections.index', compact('models', 'query', 'sortLinks'));
    }

    public function create(Request $request){

        if($request->ajax()){
            return view('sections.create');    
        }
        
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

        return view('sections.show', compact('model'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        
        $model = $this->classname::whereKey($id)->first();

        return view('sections.edit', compact('model'));
       
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
        return \View::make('sections.delete',['model'=>$model]);
    }
}
