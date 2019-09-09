<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
    if (Session::has('userinfo')) {
        //$param = array('last_name'=>'naparate','first_name'=>'jerica');
        //$test = new RiskAssessmentTool($param);
        //$ss = $test->SearchPNA();
        
        // dd($ss);
        

        //Gets the url route page 
        $arrRoute = explode('/',$request->url());
        $_index = array_search ($_SERVER['HTTP_HOST'],$arrRoute);
        $ctr = count($arrRoute);
       
        if($_SERVER['HTTP_HOST'] == 'localhost'){
            $route = $arrRoute[$_index + 2];
            
            if($ctr > $_index + 3){
                $route = $route .'/'.$arrRoute[$ctr-1];
            }
        }
        else{
            $route = $arrRoute[$_index + 1];
            //dd($route);
            if($ctr > $_index + 2){
                $route = $route .'/'.$arrRoute[$ctr - 1];
            }
        }
        
        if(!$request->ajax()){
            $home = 'home';
            if(Session::get('userinfo')[0]['vbranch_type'] == '3') {$home = 'bp-home';}
            
            if($route != 'refresh' && $route != 'logout' && $route != 'login' && $route != $home && $route != null && $route != 'otpvalidate'){
                $resultArray = access::CheckAccess(Session::get('accessinfo'), $route);
                //dd($resultArray);
                if($resultArray['Access'] == 'DENIED') {
                    //Session::flush();
                    //return Redirect::route('login')->with('message', 'Access Denied! '.$resultArray['ModuleName']);
                    throw new Exception('You have no access to [' . $route . '] module',500);
                }
            }
        }
        $hash = Func::createAPIRequestComplete("login", "cls", array("user_id" => Session::get('userinfo')[0]['vuser_id']));

        $file = json_decode($hash, true);

        $login_session = $file['apiuspresponse']["body"][0]['curr_session'];
        if ($login_session != '') {
            if ($login_session != Session::getId()) {
                Session::flush();

                if ($request->ajax()) {
                    Session::put('message', 'Somebody logged in your account in another terminal.');
                    return Response::make('Somebody logged in your account in another terminal.', 401);
                } else {
                    if (!Request::is('login')) {
                        return Redirect::route('login')->with('message', 'Somebody logged in your account in another terminal.');
                    }
                }
            }
        } else {
            Session::flush();

            if ($request->ajax()) {
                Session::put('message', 'Somebody logged in your account in another terminal.');
                return Response::make('Somebody logged in your account in another terminal.', 401);
            } else {
                if (!Request::is('login')) {
                    return Redirect::route('login')->with('message', 'Logout Successful!');
                }
            }
        }
    }
});


App::after(function($request, $response) {
    $response->headers->set('P3P', 'CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"');
    if (Session::has("userinfo")) {
        $timein = date("Y-m-d H:i:s");

        $endTime = strtotime("+" . Config::get("app.timeout") . " minutes", strtotime($timein));
        $timeout = date('Y-m-d H:i:s', $endTime);

        Session::put('timelogin', $timein);
        Session::put('timelogout', $timeout);
    }
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function() {
    if (Auth::guest()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('login');
        }
    }
});


Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function() {
    //dd(Input::get('_token'));
    if (Session::token() !== Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
        //dd(Session::token());
    }
});


Route::filter('isExpiredOrDefault', function(){

    if(Session::has('isDefaultPass')){
        if(Session::get('isDefaultPass') == true){
          return Redirect::to('login');
        }
    }

    if(Session::has('isExpired')){
      return Redirect::to('login');
    }
});

