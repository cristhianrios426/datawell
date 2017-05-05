<?php 
namespace App\Util;
use App\Exceptions\Exception;
class Helpers{	


	public static function launchImage($file){
		$filename = basename($file);
		$file_extension = strtolower(substr(strrchr($filename,"."),1));

		switch( $file_extension ) {
		    case "gif": $ctype="image/gif"; break;
		    case "png": $ctype="image/png"; break;
		    case "jpeg":
		    case "jpg": $ctype="image/jpg"; break;
		    default:
		}
		return \Response::make(file_get_contents($file))->header('Content-Type' , $ctype);
	}

	public static function tempPath($file = NULL){
		$dir = storage_path('app/temporal');
		if($file != NULL){
			return $dir.DIRECTORY_SEPARATOR.$file;
		}else{
			return $dir;
		}
	}

	public static function renameFile($file_name, $prefix = ''){
		$arrFile = explode('.' ,$file_name);
		$ext = $arrFile[(count($arrFile) - 1)];
		$newName = strtolower($prefix.str_random(30)).'.'.$ext;
		return $newName;
	}

	public static function moveToPath($file, $fromPath, $toPath, $prefix = ''){
		$newName = static::renameFile($file,$prefix);
		$move = \File::move($fromPath.'/'.$file, $toPath.'/'.$newName);
		if($move){
			return $newName;	
		}else{
			return $move;
		}		
	}

	public static function upload($baseurl,$directory, $allowed = null){
		//$baseurl = url('temporal');				
		//$directory = public_path().'/temporal';
		if(\Request::isMethod('delete') || \Request::isMethod('DELETE')){
			$file = \Request::input('delete', '--');
			@unlink($directory.'/'.$file);
		}else{		
			if(isset($_FILES)){				
				foreach ($_FILES as $key => $_FILE){			
					if(isset($_FILES[$key]['name'])){									
						$input = \Request::file($key);	

						$originalName = $input->getClientOriginalName();
						$serverName = static::renameFile($originalName);
						$url = $baseurl.'/'.$serverName;
						$deleteUrl = $baseurl.'?delete='.urlencode($serverName);
						
						$ext = strtolower($input->getClientOriginalExtension());
						$blacklist = array('php', 'php5', 'php4', 'php3', 'js',  'htaccess', 'vbs','ini','perl','cgi','asp', 'aspx','py');						
						if( in_array($ext, $blacklist ) ){
							$e = new Exception();
							$e->setContext(['unauthorized'=>'Type file not allowed', 'status'=>401]);
							throw $e;
							
						}
						if($allowed){
							if( !in_array($ext, $allowed ) ){
								$e = new Exception();
								$e->setContext(['unauthorized'=>'Type file not allowed', 'status'=>401]);
								throw $e;
							}
						}

						\Request::file($key)->move($directory, $serverName);
						$files[$key]= array(
								'name'=>$serverName,
								'url'=>$url,
								'deleteUrl'=>$deleteUrl,
								'originalName'=>$originalName,								
								'ext'=>$ext
							);
					}
				}
				return $files;
			}else{
				$e = new Exception();
				$e->setContext(['unauthorized'=>'No se encontraron archivos', 'status'=>404]);
				throw $e;
			}
		}
	}

	public static function uploadTemporal($allowed = null){
		$files = static::upload(route("temporal-file",['file'=>'']),static::tempPath(), $allowed);
		if(is_array($files)){
			foreach ($files as $key => $value) {
				\Session::put('temp_'.$value['name'], true);
			}
			return $files;	
		}else{
			return [];
		}
		
	}

	public static function checkTemporal($file){
		return \Session::has('temp_'.$file);
	}

	public static function serveFile($file, $directory = NULL, $aliasFile = NULL){
		
		if($directory){
			
			$from = ['../', '..\\', '/', '\\'];
			$to = ['', '', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR];

			$files = str_replace($from, $to, $file);
			$file = rtrim($file, '/' );
			$file = rtrim( $file, '\\' );

			$directory = rtrim($directory, '/');
			$directory = rtrim($directory, '\\');			
			$directory = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $directory);

			$file = $directory.DIRECTORY_SEPARATOR.$file;			
		}
		
		if(!file_exists($file) ){
			$e = new Exception('No se encontraron archivos '.$file);
			$e->setContext(['file'=>'No se encontraron archivos']);
			throw $e;			
		}
		
		if($directory){
			$realpath = realpath($file);
			$pathinfo = pathinfo($realpath);
				
			if($pathinfo['dirname'] != realpath($directory)){
				$e = new Exception();
				$e->setContext(['path'=>'Permiso denegado ']);
				throw $e;
			}
		}else{

			$pathinfo = pathinfo($file);
		}

		$extention = $pathinfo['extension'];
		$extensionServeList = ['json','js','css','jpg','jpeg','png','gif', 'pdf'];

		$mimeTypes = [
			'json'=>'application/json',
			'js'=>'application/javascript',				
			'css'=>'text/css',
			'jpg'=>'image/jpeg',
			'jpeg'=>'image/jpeg',
			'png'=>'image/png',
			'gif'=>'image/gif',
			'pdf'=>'application/pdf',
		];

		if(isset($mimeTypes[strtolower($extention)])){
			$mime = $mimeTypes[strtolower($extention)];
			try
			{

			    $contents = \File::get($file);

			}
			catch (Illuminate\Filesystem\FileNotFoundException $exception)
			{

			    $e = new Exception();
				$e->setContext(['not_found'=>'archivo no encontrado']);
				throw $e;
			}

			return response($contents)->header('Content-Type', $mime);

		}else{
			if($aliasFile){
				return  response()->download($realpath, $aliasFile);
			}else{
				return  response()->download($realpath);
			}
			
		}
	}
	public static function serveTemporal($file){
		if(!static::checkTemporal($file)){
			$e = new Exception();
			$e->setContext(['session'=>'No se encontraron archivos '.'temp_'.$file]);
			throw $e;
		}
		return static::serveFile($file, static::tempPath());
	}
	// public static function serveTemporal($file){
	// 	if(!static::checkTemporal($file)){
	// 		$e = new Exception();
	// 		$e->setContext(['session'=>'No se encontraron archivos '.'temp_'.$file]);
	// 		throw $e;
	// 	}

	// 	$file = str_replace('../', '', $file);
	// 	$filename = static::tempPath($file);
	// 	$dir = static::tempPath();
		
	// 	if(!file_exists($filename) ){
	// 		$e = new Exception();
	// 		$e->setContext(['file'=>'No se encontraron archivos']);
	// 		throw $e;			
			
	// 	}		
	// 	$realpath = realpath($filename);
	// 	$pathinfo = pathinfo($realpath);
		
	// 	if($pathinfo['dirname'] != realpath($dir)){
	// 		$e = new Exception();
	// 		$e->setContext(['path'=>'No se encontraron archivos']);
	// 		throw $e;
	// 	}


	// 	$extention = $pathinfo['extension'];
	// 	$extensionServeList = ['json','js','css','jpg','jpeg','png','gif', 'pdf'];

	// 	$mimeTypes = [
	// 		'json'=>'application/json',
	// 		'js'=>'application/javascript',				
	// 		'css'=>'text/css',
	// 		'jpg'=>'image/jpeg',
	// 		'jpeg'=>'image/jpeg',
	// 		'png'=>'image/png',
	// 		'gif'=>'image/gif',
	// 		'pdf'=>'application/pdf',
	// 	];

	// 	if(isset($mimeTypes[strtolower($extention)])){
	// 		$mime = $mimeTypes[strtolower($extention)];
	// 		try
	// 		{

	// 		    $contents = \File::get($filename);

	// 		}
	// 		catch (Illuminate\Filesystem\FileNotFoundException $exception)
	// 		{

	// 		    return \Response::json(['messages'=>['type'=>'danger', 'danger'=>true, 'messages'=>[ 'Error files' ] ]], 404);
	// 		}

	// 		return response($contents)->header('Content-Type', $mime);

	// 	}else{
			
	// 		return  response()->download($realpath);
	// 	}
	// }

	public static function defaultValue($input, $key, $attr, $default){
		if(isset($input[$key])){
			return $input[$key];
		}else{
			if($attr != null ){
				return $attr;
			}else{
				return $default;
			}
		}
	}

	public function __call($name, $arguments)
    {
        return call_user_func_array([$this, $name], $arguments);      
    }
}