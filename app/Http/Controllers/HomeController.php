<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Util\Helpers;
use App\Exceptions\Exception;
use App\ORM\Well as Model;
use App\Repository\WellRepository;
use App\ORM\CoordinateSys;
use App\ORM\Area;
use App\ORM\Camp;
use App\ORM\Cuenca;
use App\ORM\Block;
use App\ORM\WellType;
use App\ORM\User;
use App\ORM\Deviation;
use App\ORM\ServiceType;
use App\ORM\Section;
use App\ORM\Location;
use App\ORM\Well;
use App\ORM\Service;
use App\ORM\Operator;
use App\ORM\Attachment;



class HomeController extends Controller
{

    public $repository;
    
    public function __construct()
    {
        //parent::__construct();
        $this->middleware('auth')->only(['toApprove', 'toReview','uploadTemporal','serveTemporal','validSupervisor']);
        
    }

    public function toApprove(){
        $user = \Auth::user();
        return \View::make('app.to-approve',[ 
            'wells'=> Well::pendingApprove($user)->get(), 
            'services'=>  Service::pendingApprove($user)->get(), 
            'user'=>$user]);
    }
    public function toReview(){
        $user = \Auth::user();
        return \View::make('app.to-review',[ 
            'wells'=> Well::pendingReview($user)->get(), 
            'services'=> Service::pendingReview($user)->get(), 
            'user'=>$user]);
    }

    public function index(Request $request)
    {
        
        if(\Auth::check()){
            return \Redirect::route('well.index');
        }else{
            return $this->home($request);
        }
    }

    public function home(Request $request)
    {   
        
        $query = $request->all();

        $sorts = ['name'];
        $sortLinks  = Model::sortableLinks($query, $sorts);
        $this->repository = new WellRepository();
        $this->repository->filter($request);
        $this->repository->noAuthenticated()->get();
        $this->repository->with([
            'cuenca', 
            'area', 
            'operator', 
            'camp', 
            'type' , 
            'block',
            'deviation' , 
            'location',
            'coorSys',             
            'services.type',
            'services.section',
            'location',
            ]);
        $all = $this->repository->get();
        if($all->count() > 0){
            $all->addAppends(['sectionsNames','serviceTypesNames']);
        }
        
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
            'query' =>$query,
            'sortLinks' => $sortLinks,
            'serviceTypes'=>ServiceType::all(),
            'locations'=>Location::where('parent_id',0)->get(),
        );
        return view('front.home', $data);
    }

    public function uploadTemporal(){
        try {
            //$images = Helpers::uploadTemporal(['jpg', 'jpeg', 'png', 'gif', 'pdf', 'zip', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']);    
            $images = Helpers::uploadTemporal(['pdf', 'jpg', 'png']);    
        } catch (Exception $e) {
            return response()->json($e->getContext(), 550);
        }       
        return response()->json($images);
    }

    public function serveTemporal($file){
        try {
            return Helpers::serveTemporal($file);    
        } catch (Exception $e) {
            return response()->json($e->getContext(), 550);
        }       
        return response()->json($images);
    }

    public function validSupervisor(Request $request){
        if($request->has('well_id')){
            $id = $request->input('well_id');
            $well = Well::find($id);
            if(!$well){
                return [];
            }
            $location = $well->location;
            if(!$location){
                return [];
            }
            $list = $location->listAscendence();
            $locationId = $location->parent_id == 0 ? $location->getKey() : $list[0];
            $currentLocation = ($locationId == $location->getKey()) ? $location : Location::find($locationId);    
            
            $users = User::vacum()->isSupervisor()->inLocation($currentLocation)->get();
            return $users;
        }
        return [];
    }

    // public function locationSelect(Request $request){
    //     $locals = [
    //         'cuenca'=>Cuenca::vacum(),
    //         'block'=>Block::vacum(),
    //         'area'=>Area::vacum(),
    //         'location'=>Location::vacum(),
    //         'camp'=>Camp::vacum(),            
    //         'supervisor'=>User::vacum()->isSupervisor(),            
    //     ];
    //     if($request->has('parent_id') && $request->has('list') &&  is_array($request->input('list'))){
    //         $parent = $request->input('parent_id');
    //         $parent = $parent != '' ? $parent : 0;
    //         $location = Location::find($parent);            
            
    //         $list = array_unique($request->input('list'));
    //         $response = [];
    //         foreach ($list as $key => $value) {
    //             if(isset($locals[$value])){
    //                 $q = $locals[$value];
    //                 $q->select(['id', 'name']);
    //                 if($value == 'location'){
    //                     if(!$location){
    //                         $result = $q->where('parent_id', 0)->get();
    //                     }else{
    //                         $result  = $q->where('parent_id', $location->getKey())->get();
    //                     }
    //                     $response[$value] = $result; 
    //                 }else{
    //                     if(!$location){
    //                         $result = $q->get();
    //                     }else{
    //                         $result  = $q->inLocation($location)->get();
    //                     }
    //                     $response[$value] = $result;   
    //                 }
                 
    //             }
                
    //         }
    //         $json = json_encode($response);            
    //         //return \Response::make($json)->header('Content-Type', 'application/json');
    //         return \Response::json($response);
    //     }else{
    //          return \Response::json([]);
    //     }
    // }


    public function locationSelect(Request $request){
        $locals = [
            'cuenca'=>Cuenca::vacum(),
            'block'=>Block::vacum(),
            'area'=>Area::vacum(),
            'location'=>Location::vacum(),
            'camp'=>Camp::vacum(),            
            'supervisor'=>User::vacum()->isSupervisor(),            
        ];
        if($request->has('parent_id') && $request->has('list') &&  is_array($request->input('list'))){
            $parent = $request->input('parent_id');
            $parent = $parent != '' ? $parent : 0;
            $location = Location::find($parent); 
            $list = array_unique($request->input('list'));
            $response = [];
            foreach ($list as $key => $value) {
                if(isset($locals[$value])){
                    $q = $locals[$value];
                    $q->select(['id', 'name']);
                    if($value == 'location'){
                        if(!$location){
                            $result = $q->where('parent_id', 0)->get();
                        }else{
                            $result  = $q->where('parent_id', $location->getKey())->get();
                        }
                        $response[$value] = $result; 
                    }else{
                        $list = $location->listAscendence();
                        $locationId = $location->parent_id == 0 ? $location->getKey() : $list[0];
                        $currentLocation = ($locationId == $location->getKey()) ? $location : Location::find($locationId);    
                        if(!$location){
                            $result = $q->get();
                        }else{
                            $result  = $q->inLocation($currentLocation)->get();
                        }
                        $response[$value] = $result;   
                    }
                 
                }
                
            }
            $json = json_encode($response);            
            //return \Response::make($json)->header('Content-Type', 'application/json');
            return \Response::json($response);
        }else{
             return \Response::json([]);
        }
    }
}
