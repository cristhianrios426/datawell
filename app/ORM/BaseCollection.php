<?php 
namespace App\ORM;
use Illuminate\Database\Eloquent\Collection;
class BaseCollection extends Collection{
	
	public function addHidden($hidden){			
		foreach ($this as $key => $model) {
			$model->addHidden($hidden);
		}
	}

	public function removeHidden($hidden){
		foreach ($this as $key => $model) {
			$model->removeHidden($hidden);
		}
	}
	public function addAppends($hidden){			
		foreach ($this as $key => $model) {
			$model->addAppends($hidden);
		}
	}

	public function jsonSerialize(){
		try {
			$r = parent::jsonSerialize();
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
		return $r;
	}

	public function removeAppends($hidden){
		foreach ($this as $key => $model) {
			$model->removeAppends($hidden);
		}
	}
	public function export($fields = null, $caption = null, $filename = null){
		
		$data = $this->toArray();
		if(count($data) < 1){
			return false;
		}		
		if(!$fields){
			$fields = array_keys($data[0]);
			$_fields = array();
			foreach ($fields as $key => $field) {
				$_fields[$field] = $field;
			}
			$fields = $_fields;
		}		
		if(!$filename){
			$filename = 'Exportado - '.date('Y-m-d H-i-s').'.xls';
		}
		$rows = '';	
		$rows.= $this->_rowExport($data, array_keys($fields), true);
		//exit();
		foreach ($this as $row => $model) {
			$rows .= $this->_rowExport($model, $fields);
		}

		$table = '<table>
					'.$rows.'
				</table>';		
		$response = Response::make($table)
					->header('Content-type', 'application/ms-excel')
					->header('Content-Disposition', 'attachment; filename='.$filename);
		return $response;
	}

	private function _rowExport($model, $fields, $head = false){
		$html = '<tr>';
		foreach ($fields as  $field) {
			if($head){
				$value =  $field;
			}else{
				$value = '';
				if(is_string($field) && isset($model->$field)){				
					$value = $model->$field;				
				}elseif(is_callable($field)){
					$value = call_user_func_array($field,[$model]); 
				}else{
					
					$value = $field;
				}
			}
			$html.= '<td>'.utf8_decode($value).'</td>';
		}		
		$html .= '</tr>';
		return $html;
		return '';
		
	}
}