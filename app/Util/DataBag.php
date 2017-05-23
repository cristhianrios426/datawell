<?php 
namespace App\Util;
class DataBag{
	protected $data; 
	public function __construct(){
		$this->data = [];
	}
	public function get($key){
		return (isset($this->data[$key]) ? $this->data[$key] : NULL);
	}
	public function set($key, $value){
		$this->data[$key] = $value;
	}
}