<?php

namespace HelloVideo\Http\Controllers\Api\v1;

use HelloVideo\Http\Controllers\Controller;

use HelloVideo\Models\Setting;
use URL;
use DB;
use Auth;
use Mail;
use Hash;
use Validator;
use Session;
use Carbon\Carbon as Carbon;
use Illuminate\Http\Request;

use HelloVideo\User;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;


class UserController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {

        return view('api.v1.documentation');
    }

    /*
     * login controller
     */
    public function login(Request $request){
        $input = $request->all();

        $settings = Setting::first();
        $data = array();
        // get login POST data
        $email =  $input['email'];
        $password =  $input['password'];
        if(empty($email)){
            $data['message'] = "email field is not exist.";
            $data['code'] = 403;
            return response()->json($data);
        }else if(strpos($email, '@') === false){
            $data['message'] = "Email format is not right.";
            $data['code'] = 405;
            return response()->json($data);
        }
        if(empty($password)) {
            $data['message'] = "Password field is not exist.";
            $data['code'] = 403;
            return response()->json($data);
        }

        $users = DB::table('users')->where('email', $email)->first();
        if(empty($users)) {
            $data['message'] = "a user not exist.";
            $data['code'] = 404;
            return response()->json($data);
        }else {
            if ($users && Hash::check($password, $users->password)) {
                //////////////////test//////////////////
//                $data['message'] = $settings;
//                $data['code'] = 200;
//                return response()->json($data);

                    if($settings->free_registration && !Auth::user()->stripe_active){
                        Auth::user()->role = 'registered';
                        $user = User::find(Auth::user()->id);
                        $user->role = 'registered';
                        $user->save();
                    }
                    if( Auth::user()->subscribed() ||
                        (Auth::user()->role == 'admin' || Auth::user()->role == 'subscriber') ||
                        ($settings->free_registration && Auth::user()->role == 'registered'))
                    {
                        if(Auth::user()->role == 'demo' && Setting::first()->demo_mode != 1){

                            Auth::logout();
                            $data['message'] = "Sorry, demo mode has been disabled";
                            $data['code'] = 404;
                            return response()->json($data);

                        }elseif(Auth::user()->status == 0) {

                            Auth::logout();
                            $data['message'] = "Your Account Block.";
                            $data['code'] = 404;
                            return response()->json($data);

                        }

                        // here you know data is valid
                        $data['message'] = $users;
                        $data['code'] = 200;
                        return response()->json($data);

                    }else{

                        // here you know data is valid
                        $data['message'] = "Uh oh, looks like you don't have an active subscription, please renew to gain access to all content";
                        $data['code'] = 404;
                        return response()->json($data);
                    }

            }else {
                $data['message'] = "password is not correct";
                $data['code'] = 403;
                return response()->json($data);
            }
        }
    }

}
