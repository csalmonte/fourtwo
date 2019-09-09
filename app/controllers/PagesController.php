<?php

class PagesController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showHome()
	{
		return View::make('hello');
	}

	public function showAccess()
	{
		return View::make('showAccess');
	}

	public function showSubmit()
	{
		return View::make('showSubmit');
	}

	public function showBlade()
	{
		return View::make('dropDown');
	}

	public function uploadProfileImage()
	{
		return View::make('uploadProfile');
	}

	public function showExercise(){
		return View::make('showExercise');
	}

	public function showImageUpload(){
		return $results = DB::select('select avatar from userinfo where id = 35');
	}

	public function uploadProfile()
	{
		$croppedImageDataURL = Input::get('_croppedImageDataURL');

		//str_replace(find,replace,string,count)
		
		//echo str_replace("data:image/png;base64\,","",$croppedImageDataURL);

		//echo ltrim($croppedImageDataURL,"data:image/png;base64\,");
		//$token = Input::get('_token');
		//$email = Input::get('_email');
		//$password = Input::get('_password');
		//$croppedImageDataURL = Input::get('_croppedImageDataURL');
		//dd($croppedImageDataURL);
		//$destinationPath = 'uploads';
		//$savepath = move($destinationPath, $croppedImageDataURL);
		//dd($croppedImageDataURL);


		DB::table('userinfo')->insert(
		    array( 'firstName' => 'Chester', 
		    	   'middleName' => 'Soriano',
		    	   'lastName' => 'Almonte',
		    	   'birthdate' => '2019-07-04',
		    		'username' => 'kachenas',
		    		'email' => 'almonte.chester@petnet.com.ph',
		    		'password' => 'sample_password',
		    		'cpNumber' => '09274458838',
		    		'tempAddress' => 'Mandaluyong',
		    		'permAddress' => 'Dagupan',
		    		'avatar' => $croppedImageDataURL)
		);
		//dd($croppedImageDataURL);
		
		//return View::make('uploadProfileInfo')->with('destinationPath', $croppedImageDataURL);

		//$input = Input::file('fileInput')->getRealPath();
		//$target_dir = $post->file('fileInput')->store('avatarUpload');
		//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		//$uploadOk = 1;
		//$inputs = Input::all();
		//dd($inputs);
		//return View::make('uploadProfileInfo')->with('target_dir',$target_dir);
		//$inputs = Input::get('fileToUpload');

		if (Input::file('fileInput')->isValid()) 
		{
			$destinationPath = 'uploads';
			//$extension = Input::file('fileInput')->getClientOriginalExtension(); // get extension
			//$fileName = pathinfo(Input::file('fileInput')->getClientOriginalName(), PATHINFO_FILENAME); //get filename
			//$realPath = Input::file('fileInput')->getRealPath();
			$savepath = Input::file('fileInput')->move($destinationPath, $croppedImageDataURL); //saving path
			$croppedImageDataURL =  Input::file('result');
		    $output = $croppedImageDataURL;
		}
		else {
			$output = "file is not valid";
		}

		
		//return View::make('uploadProfileInfo')->with('output',$token);
		  //$destinationPath = 'uploads';

		 //$avatarUpload = Input::file('fileInput')->getRealPath();
		 //dd($avatarUpload);
		//$extension = Input::file('file')->getClientOriginalExtension();
		//return View::make('uploadProfileInfo', array('destinationPath' =>  $destinationPath, 'extension'=>$extension));
		//return View::make('uploadProfileInfo')->with('destinationPath',$destinationPath);
	}

}