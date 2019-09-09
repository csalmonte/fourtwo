<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/showImage', function()
{
	return View::make('showImage');
});

Route::get('/access', 'PagesController@showAccess');
Route::get('/exercise', 'PagesController@showExercise');
Route::get('imageUpload', array('imageUpload' => 'imageUpload', 'uses' => 'PagesController@uploadProfileImage'));
Route::post('upload', array('upload' => 'upload', 'uses' => 'PagesController@uploadProfile'));

Route::post('showImageUpload', array('showImageUpload' => 'showImageUpload', 'uses' => 'PagesController@showImageUpload'));

Route::get('showBlade', array('showBlade' => 'showBlade', 'uses' => 'PagesController@showBlade'));

Route::post('/submitContactForm', 'PagesController@showSubmit');

Route::get('session/get','SessionController@accessSessionData');
Route::get('session/set','SessionController@storeSessionData');
Route::get('session/remove','SessionController@deleteSessionData');



Route::get('session/shwvld', array('as' => 'session/shwvld', 'uses' => 'SessionController@showValidData'));


Route::get('showCard', array('as' => 'showCard', 'uses' => 'ShowCardController@showCard'));