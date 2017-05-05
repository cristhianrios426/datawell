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
use App\ORM\Desviation;
use App\ORM\ServiceType;
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
}
