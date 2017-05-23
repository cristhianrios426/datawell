<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ServiceRepository as Repository;
use App\Repository\AttachmentRepository;
use App\ORM\Service as Model;
use App\ORM\CoordinateSys;
use App\ORM\Area;
use App\ORM\ServiceType;
use App\ORM\Attachment;
use App\ORM\Well;
use App\ORM\Section;


class ServiceController extends Controller
{

    protected $repository;
    public $classname;
    public $entityName;
    public $entitiesName;

    public function __construct(){
        parent::__construct();
        $this->repository = new Repository();
        $this->classname = Model::class;

        $this->entityName ="service";
        $this->entitiesName ="services";
        \View::share ( 'entityName',  $this->entityName);
        \View::share ( 'classname',$this->classname);
        \View::share ( 'entityLabel',  'servicio');
        \View::share ( 'entitiesLabel', 'servicios');
        
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

        $prewell = $request->has('id_well') && !$model->exists ?  $request->get('id_well') : false;

        $data = array(
            'wells' => Well::all(),
            'serviceTypes' => ServiceType::all(),
            'sections' => Section::all(),
            'model' => $model,
            'prewell'=>$prewell
        );
        return view($this->entitiesName.'.create', $data);
    }


    public function index(Request $request)
    {
       // parent::index($request);   
        $query = $request->all();
        $sorts = ['name'];
        $sortLinks  = Model::sortableLinks($query, $sorts);
        
        /**/

        if($request->has('term')){
            $this->repository->term($sorts, $request->input('term'));
        }
        if($request->has('sort') && in_array($request->input('sort'), $sorts ) ){
            $this->repository->orderBy($request->input('sort'), $request->input('sort_type', 'desc'));
        } 
        $this->repository->with(['type', 'section', 'well']);
        $models = $this->repository->paginate(20);
        if (request()->wantsJson()) {
            return response()->json($models);
        }

        $data = array(
            'serviceTypes'=>ServiceType::all(),
            'wells' => Well::all(),
            'areas' => Area::all(),                       
            'models' => $models,
            'query' =>$query,
            'sortLinks' => $sortLinks,
            
        );
        return view($this->entitiesName.'.index', $data);
    }

    public function create(Request $request){
        return $this->form($request);
    }

    
    public function store(Request $request)
    {
        $model = (new $this->classname);
        \DB::beginTransaction();    
        try {
            $this->repository->save( $model, $request->all());
            if($request->has('attachments') && is_array($request->get('attachments'))){
                $attachRepo = new AttachmentRepository();
                foreach ($request->input('attachments') as $key => $attach) {
                    try {
                        $attachRepo->save(new Attachment, $attach);
                        $this->repository->getEntity()->attachments()->save($attachRepo->getEntity());
                        $attachRepo->getEntity()->save();
                    }catch (\App\Repository\Exception\ValidatorException $e) {
                        \DB::rollback();
                        return response()->json( ['messages'=>['messages'=>array_values($e->validator->messages()->all() ), 'type'=>'danger']] , 422);
                    }catch (\App\Repository\Exception\SaveException $e) {
                       \DB::rollback(); 
                        return response()->json( ['messages'=>['messages'=> [$e->getMessage()], 'type'=>'danger']] , 422);
                    }
                }
            }
            \DB::commit(); 
            return response()->json( ['messages'=>['messages'=>['Cambios almacenados. Redireccionando...'], 'type'=>'success'] , 'redirect'=>route($this->entityName.'.show', ['id'=>$model->getKey()]), 'delay'=>2000 ] , 200);
        } catch (\App\Repository\Exception\ValidatorException $e) {
            \DB::rollback();
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id){
        return $this->form($request, $id);
       
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

        $model = $this->repository->whereKey($id)->first();
        if(!$model){
            \App::abort(404);
        }

        \DB::beginTransaction();
        try {
            $this->repository->save($model, $request->all());
            if($request->has('attachments') && is_array($request->get('attachments'))){
                $attachRepo = new AttachmentRepository();
                foreach ($request->input('attachments') as $key => $attach) {
                    try {
                        $attachRepo->save(new Attachment, $attach);
                        $this->repository->getEntity()->attachments()->save($attachRepo->getEntity());
                        $attachRepo->getEntity()->save();
                    }catch (\App\Repository\Exception\ValidatorException $e) {
                        \DB::rollback();
                        return response()->json( ['messages'=>['messages'=>array_values($e->validator->messages()->all() ), 'type'=>'danger']] , 422);
                    }catch (\App\Repository\Exception\SaveException $e) {
                       \DB::rollback(); 
                        return response()->json( ['messages'=>['messages'=> [$e->getMessage()], 'type'=>'danger']] , 422);
                    }
                }

            }
            if($request->has('old_attachments') && is_array($request->get('old_attachments'))){
                $deleteds = [];
                foreach ($request->input('old_attachments') as $key => $attach) {
                    if( isset($attach['id'])  && isset($attach['deleted']) && $attach['deleted'] == 1){
                        $attachment = $model->attachments()->whereKey( $attach['id'] )->first();
                        if($attachment){
                            $attachment->delete();
                            $deleteds[] = $attachment->getKey();
                        }
                    }
                }
               
            }                
            \DB::commit(); 
            return response()->json( ['messages'=>['messages'=>['Cambios almacenados. Redireccionando...'], 'type'=>'success'] , 'redirect'=>route($this->entityName.'.show', ['id'=>$model->getKey()]), 'delay'=>2000 ] , 200);
        } catch (\App\Repository\Exception\ValidatorException $e) {
            \DB::rollback();
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
    


    public function serveAttachment($id, $aid)
    {
        
        $model = $this->repository->whereKey($id)->first();
      
        if ($model) {
            
            $attachment = $model->attachments()->whereKey($aid)->first();
            if($attachment){
                return $attachment->serve();
            }else{
                
            }
        }else{
            
            return response()->json(['error'], 401);    
        }

        
    }
}
