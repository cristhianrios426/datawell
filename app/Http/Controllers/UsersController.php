<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ORM\User;
use App\Repository\UserRepository;
use \App\ORM\IdeType;
use \App\ORM\Location;
use \App\ORM\Client;
use \App\Repository\Exception\ValidatorException;
class UsersController extends SettingsController
{

    protected $repository;
    public $classname;
    public $entityName;
    public $entitiesName;
    public function __construct(){

        $this->middleware('auth')->except(['accountActivation','accountActivationPost']);
        $this->middleware('can:index,App\ORM\Setting')->only('index');
        $this->middleware('can:create,App\ORM\Setting')->only(['store', 'create']);
        
        $this->repository = new UserRepository();
        $this->entityName ="operator";
        $this->entitiesName ="operators";
        \View::share ( 'classname',$this->classname);
        \View::share ( 'entityLabel',  'Usuario');
        \View::share ( 'entitiesLabel', 'Usuarios');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        parent::index($request);   
            

        $query = $request->all();
        $sorts = ['name', 'email', 'ide'];
        $sortLinks  = User::sortableLinks($query, $sorts);
        /**/
        
        // $table = $q->getModel()->getTable();
        // if($request->has('term')){
        //     $q->term($sorts, $request->input('term'));
        // }
        // if($request->has('sort') && in_array($request->input('sort'), $sorts ) ){
        //     $q->orderBy($table.'.'.$request->input('sort'), $request->input('sort_type', 'desc'));
        // }    
           
        //$table = $q->getModel()->getTable();
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
        return view('users.index', compact('models', 'query', 'sortLinks'));
    }


    public function form($id = null){
        if($id){
            $model = $this->repository->whereKey($id)->first();
        }else{
            $model = new User;
        }
        if(!$model){
            \App::abort(404);
        }
        $types = \App\ORM\IdeType::all();
        $locations = Location::fullTree()->orderBy('name')->get();
        $clients = Client::all();
        return view('users.edit', compact('model','types', 'locations', 'clients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        return $this->form($id);
    }


    public function create(Request $request){
        return $this->form();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        \DB::beginTransaction();
         try {
            //$model = $this->repository->whereKey($id)->first();
            $model = new User;
            $this->repository->save($model, $request->all());
            $model->sendActivationCode(User::GENERATE_ACTIVATION);

           
        } catch (\App\Repository\Exception\ValidatorException $e) {
            \DB::rollback();
           return response()->json( ['messages'=>['messages'=>array_values($e->validator->messages()->all() ), 'type'=>'danger']] , 422);
        }catch(\Exception $e){
            \DB::rollback();    
            throw $e;
        }
        \DB::commit();
        return response()->json( ['messages'=>['messages'=>['Cambios almacenados. Redireccionando...'], 'type'=>'success']] , 200);
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

        return view('users.show', compact('model'));
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {

        try {
            $model = $this->repository->whereKey($id)->first();
            $previousEmail = $model->email;
            $this->repository->save($model, $request->all());
            $model = $this->repository->whereKey($id)->first();

            if($previousEmail != $model->email){
                if($previousEmail != ''){
                    $model->sendActivationCode(User::RENEW_ACTIVATION);
                }else{
                    $model->sendActivationCode(User::GENERATE_ACTIVATION);
                }   
            }
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
        return \View::make('users.delete',['model'=>$model]);
    }

    public function accountActivation(Request $request, $token){
        $user = new User();        
        $user = User::findByToken($token)->first();
        
        if(!$user){
            return view('users.activate_error');
        }
        if(!$user->checkToken($token)){            
            return view('users.activate_error');
        }
        if(!$user->isActive()){
            return view('users.activate_error');   
        }

        return  \View::make('users.activate')->with(['model'=>$user, 'types'=>IdeType::all(), 'token'=>$token]);

    }

    public function accountActivationPost(Request $request, $token){
        $user = new User();        
        $user = User::findByToken($token)->first();
        if(!$user){
            return redirect()->route('users.activate_error');
        }
        if(!$user->checkToken($token)){            
            return redirect()->route('users.activate_error');
        }

        if(!$user->isActive()){
            return redirect()->route('users.activate_error');  
        }

        $input = $request->all();
        $this->repository->setEntity($user);
        try {
            $this->repository->activationUpdate($request->all());    
        }catch (ValidatorException $e) {
            return response()->json( ['messages'=>['messages'=>array_values($e->validator->messages()->all() ), 'type'=>'danger']] , 422);
        }
        
        return response()->json( ['messages'=>['messages'=>['Gracias. Te estamos redireccionando...'], 'type'=>'success'] , 'redirect'=>route('login'), 'delay'=>3000] , 200);
    }
}
