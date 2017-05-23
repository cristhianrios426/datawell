<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mail\Contact;
use App\Http\Controllers\Controller;

class ContactCenter extends Controller{
	public function send(Request $request){
		$validator = \Validator::make($request->all(), [
			'subject'=>'required',
			'message'=>'required'
		]);
		if($validator->fails()){
			return response()->json( ['messages'=>['messages'=>array_values($validator->messages()->all() ), 'type'=>'danger']] , 422);
		}

        $subject = $request->input('subject');
        $message =  $request->input('message');       
		$user = \Auth::guard('web')->user();
		$mail = new Contact($user, $subject, $message, $request);
		\Mail::send($mail);
		return response()->json( ['messages'=>['messages'=>['Tu mensaje ha sido enviado al administrador. te estamos redireccionando'],'type'=>'success'], 'reload'=>true,'delay'=>2000] , 200);
	}
}