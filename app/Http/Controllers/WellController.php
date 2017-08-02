<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repository\WellRepository as Repository;
use App\Repository\AttachmentRepository;
use App\ORM\Well as Model;
use App\ORM\CoordinateSys;
use App\ORM\Area;
use App\ORM\Camp;
use App\ORM\Cuenca;
use App\ORM\Block;
use App\ORM\WellType;
use App\ORM\Deviation;
use App\ORM\ServiceType;
use App\ORM\User;
use App\ORM\Operator;
use App\ORM\Attachment;
use App\ORM\Location;
use App\ORM\Revision;
use App\ORM\Section;

use App\ORM\Well;
//use App\ORM\ServiceType;
class WellController extends Controller
{

    const MODE_UPDATE = 1;
    const MODE_CREATE = 2;

    protected $repository;
    public $classname;
    public $entityName;
    public $entitiesName;

    public function __construct(){
        parent::__construct();
        $this->repository = new Repository();
        $this->classname = Model::class;

        $this->entityName ="well";
        $this->entitiesName ="wells";
        \View::share ( 'classname',$this->classname);
        \View::share ( 'entityLabel',  'pozo');
        \View::share ( 'entitiesLabel', 'pozos');
        \View::share ( 'entityName', $this->entityName);
    }

    public function index(Request $request)
    {
        
        $query = $request->all();
        $sorts = ['name'];
        $sortLinks  = Model::sortableLinks($query, $sorts);

        /**/

        $this->repository->filter($request);
        $this->repository->filterUser(\Auth::user());
        $this->repository->with([
            'cuenca', 
            'area', 
            'operator',
            'camp', 
            'type' , 
            'block',
            'deviation' , 
            'coorSys',
            'services'=>function($q4){
                $q4->filterUser(\Auth::user());
            },   
            'services.type',
            'services.section',            
            'location',
        ]);
        $models = $this->repository->paginate(12);
        $all = $this->repository->get();
        $all->addAppends(['sectionsNames','serviceTypesNames']);
        if (request()->wantsJson()) {
            return response()->json($models);
        }

        $data = array(
            'all'=>$all,
            'coorSystems' => CoordinateSys::all(),
            'areas' => Area::all(),
            'camps' => Camp::all(),
            'cuencas' => Cuenca::all(),
            'blocks' => Block::all(),
            'types' => WellType::all(),
            'deviations' => Deviation::all(),
            'operators' => Operator::all(),
            'deviations' => Deviation::all(),
            'sections' => Section::all(),
            'models' => $models,
            'query' =>$query,
            'sortLinks' => $sortLinks,
            'serviceTypes'=>ServiceType::all(),
            'locations'=>Location::where('parent_id',0)->get(),
        );
        return view($this->entitiesName.'.index', $data);
    }

    public function form($request, $id = null){
        if($id == null){
            $model = new Model();
        }else{
            $model = $this->repository->whereKey($id)->with(['revisions'=>function($q){
                return $q->orderBy('created_at', 'DESC');
            }, 'revisions.createdBy'])->first();
        }

        if(!$model){
            \App::abort(404);
        }
        $user = \Auth::user();
        $data = array(
            'coorSystems' => CoordinateSys::all(),
            'areas' => Area::all(),
            'camps' => Camp::all(),
            'cuencas' => Cuenca::all(),
            'blocks' => Block::all(),
            'types' => WellType::all(),
            'deviations' => Deviation::all(),
            'operators' => Operator::all(),
            'locations' => ($user->isSuperadmin() ? Location::fullTree()->orderBy('name')->get() : Location::fullTree()->inUserLocation($user)->orderBy('name')->get() ),
            'model' => $model,
            'user'=>\Auth::user(),
        );

        $user = \Auth::user();
        if($model->approved == 1 && !$user->can('updateapproved', $model)){
            $ascendece = $model->location->listAscendence();
            $firstLocation = Location::whereKey($ascendece[0])->withTrashed()->first();
            if($firstLocation){
                
                $supervisors =  User::vacum()->isSupervisor()->inLocation($firstLocation)->get();    
                
            }else{
                 $supervisors = [];
            }
            $data['supervisors'] = $supervisors;
        }
        
        
        return view($this->entitiesName.'.create', $data); 
    }

    public function create(Request $request){
       return $this->form($request);
    }

    public function store(Request $request){
        $user = \Auth::user();
        $user->canOrFail('create', Model::class );
        $model = new Model();
        return $this->save($request, $model, static::MODE_CREATE);
    }

    public function update(Request $request, $id){
        $model = Model::find($id);
        if(!$model){
            abort(404);
        }
        $user = \Auth::user();
        $user->canOrFail('update', $model );
         return $this->save($request, $model, static::MODE_UPDATE);
    }
    
    public function save(Request $request, $model, $mode )
    {

        //dd($request->all());
        
        \DB::beginTransaction();
        try {
            $user = \Auth::user();
            if($request->has('action') && ( $request->input('action') == 'approve'  || $request->input('action') == 'createapproved' ) ){
                if( 
                    ($mode == static::MODE_UPDATE && $user->can('approve', $model) )  || 
                    ($mode == static::MODE_CREATE && $user->can('createapproved', Model::class) ) 
                ){
                    $this->repository->save($model, $request->all(), false);
                    $model  = $this->repository->getEntity();
                    $model->approveIfNeeded($user);
                }else{
                    $e = new \App\Exceptions\Exception();
                    $e->setContext(['Acción no autorizada. 1']);
                    throw $e;
                }
            }elseif(
                $request->has('action') && 
                (
                    $request->input('action') == 'sendapprove'  || 
                    (
                        $request->input('action') == 'createsendapprove' && 
                        $request->has('assigned_to')
                    )
                )
                
            ){ 
                $this->repository->save($model, $request->all(), false);
                $model  = $this->repository->getEntity();
                if(
                    ($mode == static::MODE_UPDATE && $user->can('sendapprove', $model) )  || 
                    ($mode == static::MODE_CREATE && $user->can('createsendapprove', Model::class) ) 
                ){
                    if( ! $model->assignedTo){
                        $assigned = User::find($request->input('assigned_to'));
                        if(!$assigned){
                            $e = new \App\Exceptions\Exception();
                            $e->setContext(['El usuario asignado no es válido']);
                            throw $e;
                        }
                        if(!$assigned->inMyLocation($model->location)){
                            $e = new \App\Exceptions\Exception();
                            $e->setContext(['El usuario asignado no es válido']);
                            throw $e;
                        }
                        $model->assigned_to = $assigned->getKey();
                    }
                    $model->sendApprove($user);
                    
                }else{
                    $e = new \App\Exceptions\Exception();
                    $e->setContext(['Acción no autorizada. 2']);
                    throw $e;
                }                
            }elseif(
                ($mode == static::MODE_UPDATE && $user->can('draft', $model) )  || 
                ($mode == static::MODE_CREATE && $user->can('createdraft', Model::class) ) 
            ){
                $this->repository->save($model, $request->all(), false);
                $model  = $this->repository->getEntity();

                $model->state = 0;
                $model->draft = 1;
            }elseif(
                ($mode == static::MODE_UPDATE && $user->can('fulledit', $model) )
            ){
                $this->repository->save($model, $request->all(), false);
                $model  = $this->repository->getEntity();
                $model->state = 0;
                $model->draft = 0;
                $model->approved = 1;
            }else{
                $e = new \App\Exceptions\Exception();
                $e->setContext(['Acción no autorizada. 3']);
                throw $e;
            }
            
                    
            if(
                $request->input('action') == 'approve' || 
                $request->input('action') == 'createapproved' ||
                $request->input('action') == 'fulledit' 
            ){

                $model->attachments()->update([
                    'approved_by'=>$model->approved_by,
                    'approved_at'=>date('Y-m-d'),
                    'approved'=>1,
                ]);
            }
            if($request->has('attachments') && is_array($request->get('attachments'))){
                $attachRepo = new AttachmentRepository();
                foreach ($request->input('attachments') as $key => $attach) {
                    try {
                        $attachRepo->save(new Attachment, $attach);
                        $this->repository->getEntity()->attachments()->save($attachRepo->getEntity());
                        $att = $attachRepo->getEntity();
                        if(
                            $request->input('action') == 'approve' || 
                            $request->input('action') == 'createapproved' ||
                            $request->input('action') == 'fulledit' 
                        ){

                            $att->approved_by = $model->approved_by;                            
                            $att->approved_at = date('Y-m-d');                            
                            $att->approved =1;                            
                        }
                        if($request->input('action') == 'sendapprove' || $request->input('action') == 'createsendapprove'){
                            $att->assigned_to = $model->assigned_to;                            
                        }
                        $att->state = $model->state;
                        $att->draft = $model->draft;
                        $att->save();                       
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
                foreach ($request->input('old_attachments') as $key => $attach) {
                    if( isset($attach['id'])  && isset($attach['deleted']) && $attach['deleted'] == 1){                        
                        $attachment = $model->attachments()->whereKey( $attach['id'] )->first();
                        //if($attachment && $user->can('delete', $attachment)){                            
                            $attachment->delete();                           
                        //}
                    }
                }
            }
            
            $model->save();

            \DB::commit(); 
            return response()->json( ['messages'=>['messages'=>['Cambios almacenados. Redireccionando...'], 'type'=>'success'] , 'redirect'=>route('well.show', ['id'=>$model->getKey()]), 'delay'=>2000 ] , 200);
        }catch(\App\Exceptions\Exception $e){
            \DB::rollback();
            return response()->json( ['messages'=>['messages'=>$e->getContext(), 'type'=>'danger']] , 422);
        }catch (\App\Repository\Exception\ValidatorException $e) {
            \DB::rollback();
           return response()->json( ['messages'=>['messages'=>array_values($e->validator->messages()->all() ), 'type'=>'danger']] , 422);
        }catch(\Exception $e){
            \DB::rollback();
            throw $e;
            
            //return response()->json( ['messages'=>['messages'=>$e->getMessage(), 'type'=>'danger']] , 422);
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
        $user = \Auth::user();
        $model = $this->repository->whereKey($id)->with(
            [
                'services'=>function($q) use ($user){
                    $q->filterUser($user);
                },
                'services.type',
                'services.section',
            ])->first();

        

        

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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->repository->whereKey($id)->first();
        $user = \Auth::user();
        if($model && $user->can('delete', $model)){
            if(request()->wantsJson()) {            
                $d =  $model->delete($id);
                return response()->json( ['messages'=>['messages'=>['Eliminaci&oacute;n completa. Redireccionando'], 'type'=>'success']] , 200);
            }
            return \View::make($this->entitiesName.'.delete',['model'=>$model]);
        }
        
    }

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
    public function attachments(Request $request, $id){
       
            $model = Model::find($id);
            if(!$model){
                return  'asdada';
            }
            $attachments = $model->attachments()->where('approved', 1)->get();
            return \View::make('attachments.attachments-modal', [
                    'name'=>$model->name,
                    'model'=>$model,
                    'attachments'=>$attachments
                ]);
    }
    
    public function revision(Request $request, $id){
        if($id){
            $input = $request->all();
            $model = Model::find($id);
            if(!$model){
                abort(404);
            }
            $user = \Auth::user();
            $user->canOrFail('review', $model);
            $model->createRevision($request->input('content', ''));
            return \Response::json(
                    [
                        'messages'=>
                            [
                                'messages'=>
                                    [
                                        'Revision enviada'
                                    ], 
                                'type'=>'success', 
                                
                            ],
                        'redirect'=>route($this->entityName.'.show',['id'=>$model->getKey()]),
                        'delay'=>500
                    ]
                );
        }
    }

    public function pending(){
        $user = \Auth::user();
        $table = with(new Well)->getTable();        
    }
}
