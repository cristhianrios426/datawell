<?php
namespace App\ORM;
class WellType extends Setting 
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [];
    protected $table = 'well_types';
    protected $dates = ['deleted_at','created_at', 'updated_at'];
    protected $appends = ['markerUrl'];
    const DEFAULT_COLOR = "#ff0000"; 

    public static function makeMarkerUrl($color){
    	$c = str_replace('#', '', $color);
    	$path = public_path('marker/'.$c.'.png');
    	if(!\File::exists($path)){
    		static::createMarker($color);
    	}
    	return url('marker/'.$c.'.png');
    }  
      
    public static function createMarker($color){

        //$img = \Image::canvas(60, 90,$color);
    	$img = \Image::canvas(100, 100,$color);
		$img->mask(storage_path('app/marker_template/tplblack.png'), true);	
		//$img->insert(storage_path('app/marker_template/tplfront.png'));	
		$img->resize(36,36);	
		$img->save(public_path('marker/'.str_replace('#','' , $color).'.png'));
    }

    public function markerUrl(){
        return static::makeMarkerUrl( ($this->color != "" ? $this->color : static::DEFAULT_COLOR ) );
    	
    }

    public function getMarkerUrlAttribute(){
    	return $this->markerUrl();
    	//return url('marker/marker.png');
    }
}
