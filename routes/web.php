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



Route::post('location-select', ['uses'=> 'HomeController@locationSelect']);
Route::post('valid-supervisor', ['uses'=> 'HomeController@validSupervisor']);

Route::get('/app', 'BackController@index');

Route::post('user/send-token', [ 'as'=>'user.send-token', 'uses'=>'UsersController@sendToken'] );
Route::get('user/account_activation/{token}', [ 'as'=>'user.account_activation', 'uses'=>'UsersController@accountActivation'] );
Route::post('user/account_activation/{token}', [ 'as'=>'user.account_activation_post', 'uses'=>'UsersController@accountActivationPost'] );
Route::get('user/account_activation', [ 'as'=>'user.activation', 'uses'=>'UsersController@activation'] );
Route::resource('user', 'UsersController');

Route::get('por-aprobar', 'HomeController@toApprove');
Route::get('por-revisar', 'HomeController@toReview');
Route::resource('well-type', 'WellTypesController');
Route::resource('service-type', 'ServiceTypesController');
Route::resource('section', 'SectionsController');
Route::resource('operator', 'OperatorsController');
Route::resource('deviation', 'DeviationController');
Route::resource('camp', 'CampController');
Route::resource('cuenca', 'CuencaController');
Route::resource('area', 'AreaController');
Route::resource('block', 'BlocksController');
Route::resource('coordinate-sys', 'CoordinateSysController');
Route::resource('client', 'ClientController');
Route::resource('business-unit', 'BusinessUnitController');
Route::resource('location', 'LocationsController');
Route::resource('f-a-q', 'FAQController');

Route::get('manual-de-usuario', ['uses'=>'ManualController@list', 'as'=>'manual.list' ]);
Route::get('manual/download/{id}', ['uses'=>'ManualController@download', 'as'=>'manual.download' ]);
Route::resource('manual', 'ManualController');


Route::get('preguntas-frecuentes', ['uses'=>'FAQController@list', 'as'=>'preguntas-frecuentes']);

Route::post('send-contact', ['uses'=>'ContactCenter@send', 'as'=>'send-contact']);

Route::get('service/attachment/{id}/{aid}', ['uses'=>'ServiceController@serveAttachment', 'as'=>'service.attachment']);
Route::post('service/{id}/revision',[ 'as'=>'service-revision', 'uses'=>'ServiceController@revision']);
Route::get('service/{id}/attachments', ['as'=>'service.attachments', 'uses'=> 'ServiceController@attachments']);
Route::resource('service', 'ServiceController');

Route::get('well/attachment/{id}/{aid}', ['uses'=>'WellController@serveAttachment', 'as'=>'well.attachment']);
Route::post('well/{id}/revision',[ 'as'=>'well-revision', 'uses'=>'WellController@revision']);
Route::post('pendientes',[ 'as'=>'well.pending', 'uses'=>'WellController@pending']);
Route::resource('well', 'WellController');

Route::any('/upload-file', 'HomeController@uploadTemporal');
Route::get('/upload-file/{file}',['uses'=> 'HomeController@serveTemporal', 'as' => 'temporal-file']);

Auth::routes();
Route::get('/', ['uses'=> 'HomeController@index', 'as'=>'index']);


