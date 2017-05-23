<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Util\Helpers;
use App\Exceptions\Exception;
use App\ORM\Well as Model;
use App\Repository\WellRepository;
use App\ORM\CoordinateSys;
use App\ORM\Area;
use App\ORM\User;
use App\ORM\Camp;
use App\ORM\Cuenca;
use App\ORM\Block;
use App\ORM\WellType;
use App\ORM\Desviation;
use App\ORM\ServiceType;
use App\ORM\Location;
use App\ORM\Operator;
use App\ORM\Attachment;


class HomeController extends Controller
{
    
    public function __construct()
    {
        //$this->middleware('auth')->except('index');
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
        
        $repoWell = new WellRepository();
        $query = $request->all();
        $sorts = ['name'];
        $sortLinks  = Model::sortableLinks($query, $sorts);

        $repoWell->filter($request);
        $repoWell->with(['cuenca', 'area', 'operator', 'camp', 'type' , 'block','deviation' , 'coorSys']);
        $models = $repoWell->paginate(12);
        if (request()->wantsJson()) {
            return response()->json($models);
        }

        $data = array(
            'coorSystems' => CoordinateSys::all(),
            'areas' => Area::all(),
            'camps' => Camp::all(),
            'cuencas' => Cuenca::all(),
            'blocks' => Block::all(),
            'types' => WellType::all(),
            'desviations' => Desviation::all(),
            'operators' => Operator::all(),
            'models' => $models,
            'query' =>$query,
            'sortLinks' => $sortLinks,
            'serviceTypes'=>ServiceType::all()
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
                        if(!$location){
                            $result = $q->get();
                        }else{
                            $result  = $q->inLocation($location)->get();
                        }
                        $response[$value] = $result;   
                    }
                 
                }
                
            }
            $json = json_encode($response);            
            //return \Response::make($json)->header('Content-Type', 'application/json');
            return \Response::json($response);
        }else{
            return new \stdClass;
        }
    }
}
