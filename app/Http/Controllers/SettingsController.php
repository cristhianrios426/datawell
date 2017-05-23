<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
abstract class SettingsController extends Controller
{
	public function __construct(){
		parent::__construct();
        $this->middleware('can:index,App\ORM\Setting')->only('index');
		$this->middleware('can:create,App\ORM\Setting')->only(['store', 'create']);
        
	}	

	public function index(Request $request){
		$this->repository->filterUser(\Auth::user());
	}

	public function destroy($id)
    {
        $model = $this->repository->whereKey($id)->first();
        $user = \Auth::user();
        if(!$model || !$user){
            abort(404);
        }
        
        $user->canOrFail('delete', $model);    
        
        if(request()->wantsJson()) {            
            $d =  $model->delete($id);
            return response()->json( ['messages'=>['messages'=>['Eliminaci&oacute;n completa. Redireccionando'], 'type'=>'success']] , 200);
        }
        return \View::make($this->entitiesName.'.delete',['model'=>$model]);
    }
}