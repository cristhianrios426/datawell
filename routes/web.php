<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('test', function(){
	$user = \App\ORM\User::where('email', 'cristhianrios426@gmail.com')->first();
	if($user){
		$user->email = 'gi.grazt@gmail.com';
		$user->save();
	}
});


Route::get('/app', 'BackController@index');

Route::get('user/account_activation/{token}', [ 'as'=>'user.account_activation', 'uses'=>'UsersController@accountActivation'] );
Route::post('user/account_activation/{token}', [ 'as'=>'user.account_activation_post', 'uses'=>'UsersController@accountActivationPost'] );
Route::get('user/account_activation', [ 'as'=>'user.activation', 'uses'=>'UsersController@activation'] );
Route::resource('user', 'UsersController');

Route::resource('well-type', 'WellTypesController');
Route::resource('service-type', 'ServiceTypesController');
Route::resource('section', 'SectionsController');
Route::resource('operator', 'OperatorsController');
Route::resource('desviation', 'DesviationController');
Route::resource('camp', 'CampController');
Route::resource('cuenca', 'CuencaController');
Route::resource('area', 'AreaController');
Route::resource('block', 'BlocksController');
Route::resource('coordinate-sys', 'CoordinateSysController');
Route::resource('client', 'ClientController');

Route::get('service/attachment/{id}/{aid}', ['uses'=>'ServiceController@serveAttachment', 'as'=>'service.attachment']);
Route::resource('service', 'ServiceController');

Route::get('well/attachment/{id}/{aid}', ['uses'=>'WellController@serveAttachment', 'as'=>'well.attachment']);
Route::resource('well', 'WellController');

Route::any('/upload-file', 'HomeController@uploadTemporal');
Route::get('/upload-file/{file}',['uses'=> 'HomeController@serveTemporal', 'as' => 'temporal-file']);

Auth::routes();
Route::get('/', ['uses'=> 'HomeController@index', 'as'=>'index']);
