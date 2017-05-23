<?php 
namespace App\Repository;
use App\ORM\User;
use App\ORM\Location;
class UserRepository extends Base{

	protected $fillable = [
		'name',
		'email',
		'phone',
		'ide_type',
		'address',
		'job_phone',
		'ide',
		'cell',
		'job_cell',
		'job_address',
		'state',
		'role_id',
		'location_id',
		'client_id'
	];
	public function __construct()	
	{	
		$this->ORMClass = (string) User::class;
	}
	public function getAttributesNames($input){

		$attrs = parent::getAttributesNames($input);
		$nattrs = [
			'ide_type'=>'tipo de identificación',
			'ide'=>'número de identificación',
		];
		return array_merge($attrs, $nattrs);
	}

	public function getRules($input){
		$model = $this->entity;
		$rules = [];
		$rules['name']  = [];
		$rules['name'][] = 'required';

		$rules['email']  = [];
		$rules['email'][] = 'email';

		if($model->isNew){
			$rules['email'][] = ['unique_eloquent', "\\App\\ORM\\User","email"];
		}else{
			$rules['email'][] = ['unique_eloquent_or_value', "\\App\\ORM\\User","email", $this->entity->email];
		}

		$rules['ide_type'] = [];
		$rules['ide_type'][] = ['exists_eloquent', "\\App\\ORM\\IdeType"];
		$rules['ide'] = [];
		$rules['ide'][] = ['unique_eloquent_or_value', "\\App\\ORM\\User", "ide", $this->entity->ide];
		//$rules['ide'][] = ['unique_eloquent_or_value', "\\App\\ORM\\User", "ide", $this->entity->ide];
		$rules['state'] = [];
		$rules['state'][] = ['in', \App\ORM\User::ACTIVE, \App\ORM\User::INACTIVE];

		$rules['role_id'] = [];
		$rules['role_id'][] = 'required';
		$rules['role_id'][] = ['in', User::ROLE_ADMIN,User::ROLE_ENG,User::ROLE_SUPER,User::ROLE_CLIENT,User::ROLE_MANAGER];

		if(isset($input['role_id']) && $input['role_id'] == User::ROLE_CLIENT){
			
			$rules['client_id'] = "required|exists_eloquent:\\App\\ORM\\Client";
		}
		$rules['location_id'] = "required|exists_eloquent:".Location::class;
		return $rules;
	}

	

	public function activationUpdate($input){
		$rules = $this->getRules($input);
		$deleteRules = ['email', 'state', 'role_id','location_id'];
		foreach ($deleteRules as  $rule) {
			if(isset($rules[$rule])){
				unset($rules[$rule]);
			}
		}
		$deleteInput = ['email', 'state', 'role_id', 'location_id'];
		foreach ($deleteInput as $key => $value) {
			if(isset($input[$value])){
				unset($input[$value]);
			}
		}


		$rules['ide'][] = ['required'];
		$rules['ide_type'][] = ['required'];
		$rules['phone'] = 'required';
		$rules['cell'] = 'required';
		$rules['address'] = 'required';
		$rules['job_phone'] = 'required';
		$rules['job_cell'] = 'required';
		$rules['job_address'] = 'required';
		$rules['password'] = 'required|confirmed|numbers|letters|case_diff|min:8';

		$attrsNames =[];
		$attrsNames['name'] = 'nombre';		
		$attrsNames['ide'] = 'No de identificación';
		$attrsNames['ide_type'] = 'Tipo de identificación';
		$attrsNames['phone'] = 'teléfono';
		$attrsNames['cell'] = 'celular';
		$attrsNames['address'] = 'dirección';
		$attrsNames['job_phone'] = 'teléfono de empresa';
		$attrsNames['job_cell'] = 'teléfono celular';
		$attrsNames['job_address'] = 'dirección de empresa';
		$attrsNames['password'] = 'contraseña';


		if(isset($rules['role_id'])){
			
			unset($rules['role_id']);
		}
		$validator = \Validator::make($input, $rules, [], $attrsNames);
		if($validator->fails()){
			throw new \App\Repository\Exception\ValidatorException($validator);
		}

		$this->entity->name = $input['name'];
        $this->entity->ide_type = $input['ide_type'];
        $this->entity->ide = $input['ide'];
        $this->entity->phone = $input['phone'];
        $this->entity->cell = $input['cell'];
        $this->entity->address = $input['address'];
        $this->entity->job_phone = $input['job_phone'];
        $this->entity->job_cell = $input['job_cell'];
        $this->entity->job_address = $input['job_address'];
        $this->entity->password = \Hash::make($input['password']);
        $this->entity->activation_token = '';

        $this->entity->save();
	}
	
}