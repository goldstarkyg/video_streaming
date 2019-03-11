<?php

namespace HelloVideo\Http\Controllers;


use HelloVideo\Models\Video;
use HelloVideo\Models\Post;
use HelloVideo\Models\Page;
use HelloVideo\Models\Setting;
use HelloVideo\Models\PaymentSetting;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\PostCategory;
use HelloVideo\Models\Menu;
use HelloVideo\Libraries\ThemeHelper;
use Illuminate\Http\Request;
use Auth;
use DB;
use Mail;
use Hash;
use Validator;
use Session;
use Carbon\Carbon as Carbon;

use HelloVideo\User;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;


class ThemeAuthController extends Controller {

	public function __construct()
	{
		$this->middleware('secure');
	}

	/*
	|--------------------------------------------------------------------------
	| Auth Controller
	|--------------------------------------------------------------------------
	*/

	public function error() {
		return view('Theme::404',[] );
	}

	public function login_form(){
		if(!Auth::guest()){
			return redirect('/');
		}
		$data = array(
			'type' => 'login',
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);

		return view('Theme::auth',$data );
	}

	public function signup_form(){

		if(!Auth::guest()){
			return redirect('/');
		}
		$data = array(
			'type' => 'signup',
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'payment_settings' => PaymentSetting::first(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);
		return view('Theme::auth',$data );
	}

	public function login(){

		$settings = Setting::first();

	    // get login POST data
	    $email_login = array(
	        'email' => request('email'),
	        'password' => request('password')
	    );

	    $username_login = array(
	        'username' => request('email'),
	        'password' => request('password')
	    );

	    if ( Auth::attempt($email_login) || Auth::attempt($username_login) ){

	    	if($settings->free_registration && !Auth::user()->stripe_active){
    			Auth::user()->role = 'registered';
    			$user = User::find(Auth::user()->id);
    			$user->role = 'registered';
    			$user->save();
    		}



	    	if(
					Auth::user()->subscribed() ||
					(Auth::user()->role == 'admin' ||
					Auth::user()->role == 'subscriber') ||
					($settings->free_registration && Auth::user()->role == 'registered')
				){

	    		$redirect = (request('redirect', 'false')) ? request('redirect') : '/';

	    		if(Auth::user()->role == 'demo' && Setting::first()->demo_mode != 1){
	    			Auth::logout();
	    			return redirect($redirect)->with(array('note' => 'Sorry, demo mode has been disabled', 'note_type' => 'error'));
	    		}elseif(Auth::user()->status == 0) {
	    			Auth::logout();
	    			return redirect($redirect)->with(array('note' => 'Your Account Block.', 'note_type' => 'error'));
	    		}

					return Auth::user()->record($redirect);

				}else{

				$username = Auth::user()->username;
				Auth::user()->record($redirect);

				return redirect('user/' . $username . '/renew_subscription')->with(array('note' => 'Uh oh, looks like you don\'t have an active subscription, please renew to gain access to all content', 'note_type' => 'error'));
				}


	  } else {

	    	$redirect = (request('redirect', false)) ? request('redirect') : '';
	        // auth failure! redirect to login with errors
	        return redirect($redirect)->with(array('note' => 'Invalid login, please try again.', 'note_type' => 'L_error'));
	    }

	}

	//public function signup(){
    public function userregistration(Request $request){
		$input = $request->all();
		parse_str($input['data'], $input);
		//echo"<pre>";
		//print_r($input);die;
		//$user_data = array('username' => request('username'), 'email' => request('email'), 'password' => Hash::make(request('password')) );
       // $user_data = array('username' => request('username'), 'email' => request('email'), 'dob' => request('dob') ,'password' => Hash::make(request('password')),'gender' => request('gender'), 'profession' => request('profession'),'income' => request('income'),'mobile' => request('mobile'),'nohouse' => request('nohouse'));

	$dob= date('Y-m-d',strtotime($input['dob']));
	$username= $input['f_name'].' '.$input['l_name'];

	$user_data = [
		'username' => $username,
		'email' => $input['email'],
		'dob' => $dob ,
		'gender' => 'male' ,
		'user_id' => 0 ,
		'password' => Hash::make($input['password']),
		'profession' => $input['profession'],
		'income' => $input['income'],
		'mobile' => $input['mobile'],
		'nohouse' => $input['nohouse'],
		'firstname' => $input['f_name'],
		'lastname' => $input['l_name']
	];


	$user_data['plan'] = 0;
	$user_data['role1'] = 1;
	$user_data['plan_price'] = 50;
	$user_data['start_plan'] = Carbon::now();
	$user_data['end_plan'] = Carbon::now();
	$user_data['contribute'] = '';
	$user_data['contribute_req'] = 0;
	$user_data['contribute_req_status'] = 0;
	$user_data['corporate_user'] = "";
	$user_data['adm'] = '';
	$user_data['demo'] = 0;
	$user_data['mail_status'] = 0;
	$user_data['login_status'] = 0;
	$user_data['login_status2'] = 0;


	$settings = Setting::first();
	if(!$settings->free_registration){

		$payment_settings = PaymentSetting::all();

		if($payment_settings[0]->live_mode){
			User::setStripeKey( $payment_settings[0]->live_secret_key );
		} else {
			User::setStripeKey( $payment_settings[0]->test_secret_key );
		}

		$token = request('stripeToken');

		unset($input['stripeToken']);
	} else {
		if($settings->activation_email):
			$user_data['activation_code'] = str_random(60);
			$user_data['active'] = 0;
		endif;

		$user_data['role'] = 'registered';
		$user_data['status']=1;
	}

	$user = User::create($user_data);
    
	if(count($user) > 0){
		return 'success';
		$username = $user->username;

		Mail::send('Theme::emails.verify1', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) use ($user){
		$message->to($user->email, $user->username)->subject('Verify your email address');
		});

		Mail::send('Theme::emails.verify',
			array('username' => $username, 'password' => $input['password']),
			function ($message) use ($user) {
				$message->to($user->email, $user->username)->subject('Welcome To aflix.tv');
			});
					
		return 'success';	
		
	}else{
		return 'error';	
	}
            //return redirect('/login')->with(array('note' => 'Welcome! Your Account has been Successfully Created! .', 'note_type' => 'success'));
}

       // return redirect('/login')->with(array('note' => 'Welcome! Your Account has been Successfully Created!', 'note_type' => 'success'));
	    /*try{
	    	if($settings->free_registration && $settings->activation_email){

	    		Mail::send('Theme::emails.verify', array('activation_code' => $user->activation_code, 'website_name' => $settings->website_name), function($message) {
            		$message->to(request('email'), request('username'))->subject('Verify your email address');
       			 });

	    		return redirect('/login')->with(array('note' => 'Success! One last step, be sure to verify your account by clicking on the activation link sent to your email.', 'note_type' => 'success'));

	    	} else {
	    		if(!$settings->free_registration){
	    			$user->subscription('monthly')->create($token, ['email' => $user->email]);
	    		}
	    		Auth::loginUsingId($user->id);
	    		return redirect('/')->with(array('note' => 'Welcome! Your Account has been Successfully Created!', 'note_type' => 'success'));
	    	}
	    } catch(Exception $e){
	    	Auth::logout();
	    	$user->delete();
	    	return redirect('/signup')->with(array('note' => 'Sorry, there was an error with your card: ' . $e->getMessage(), 'note_type' => 'error'))->withInput(\Request::only('username', 'email'));
	    }

	}
	*/
	public function check_email($email)
	{
		$user = User::where('email', '=', $email)->first();
		if(count($user)>0) return 1;
		else return 0;

	}
    public function contribute()
	{
	return view('Theme::contribute');
	}

	public function logoutShow()
	{

		return view('Theme::logoutall');
	}

	public function logoutall()
	{

		 Auth::user()->unRecordAll();

		 return redirect('/');
	}

	public function contributecreate()
	{
	$user = $_POST['name'];

	$email = $_POST['email'];
	$password = $_POST['password'];
	$id="";
	@$auth1= DB::select("select * from users where email='$email'");
	foreach ($auth1 as $auth2)
	{
	if(@$id=="")
	{
	  @$id=$auth2->email;
	 }
	else
	{
		 @$id=$auth2->email;
	}
	}

	if(@$email==@$id)
	{
	return redirect('/contribute')->with(array('note' => 'You Have  Already Registered with This emailid', 'note_type' => 'success'));
	}
	else
	{
	@$users10 = DB::select("insert into users(username,email,password,contribute)value('$user','$email','$password','contribute')");
	}

	//return redirect('/contribute')->with(array('note' => 'Success! One last step, be sure to verify your account by clicking on the activation link sent to your email.', 'note_type' => 'success'));
    return redirect('/contribute')->with(array('note' => 'Welcome! Your Account has been Successfully Created!', 'note_type' => 'success'));

	}
	public function verify ($activation_code) {
		if( ! $activation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::where('activation_code', '=', $activation_code)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->active = 1;
       $user->status = 1;
        $user->activation_code = null;
        $user->save();

        return redirect('/login')->with(array('note' => 'You have successfully verified your account. Please login below.', 'note_type' => 'success'));
	}

	public function logout(){

		if(Auth::check()){
			Auth::user()->unrecord();
		}

		return redirect('/')->with(array('note' => 'You have been successfully logged out', 'note_type' => 'success'));
	}

public function success()
{
return view('Theme::sucess');
}
public function upload()
{
return view('Theme::upload');
}

public function add_file()
{

$file = request()->file('data');
$handle = fopen($file, "r");
$c = 0;
while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
{
$FullName = $filesop[0];
$email = $filesop[1];
$password = $filesop[2];
$dob = $filesop[3];
$profession = $filesop[4];
$income = $filesop[5];
$mobile = $filesop[6];
$nohouse = $filesop[7];

$user = DB::select("insert into users(username,email,password,dob,profession,income,mobile,nohouse)
value('$FullName','$email','$password','$dob','$profession','$income','$mobile','$nohouse')");

$c = $c + 1;
 Mail::send('Theme::emails.verify',
            array('username' => $FullName, 'password' => $password),
            function($message) use ($email,$FullName) {
            $message->to($email,$FullName)->subject('Welcome To aflix.tv');
        });
}
 return redirect('/upload')->with(array('note' => 'You have successfully verified your account. Please login below.', 'note_type' => 'success'));
}

public function success1()
{
	    $input = request()->all();

$id = request('id');


return view('Theme::sucess1');


}
                 public function subscription_plan()
                 {

                      return view('Theme::plan');

                  }

				  public function my_payment()
                 {

                      return view('Theme::my_payment');

                  }
				   public function my_purchase()
                 {

                      return view('Theme::my_purchase');

                  }

	public function send_request(){

		$req_email=$_POST['req_email'];
		@$users10 = DB::select("update users set contribute_req=1 where email='$req_email'");
		return redirect('/')->with(array('note' => 'Your Request have been successfully Send', 'note_type' => 'success'));

	}

	public function generate_coupon()
	{

		$coupon=$_POST['coupon'];
		$user=$_POST['user'];
		$plan=$_POST['plan'];
		$gcs=DB::select("select * from coupon_code where name='$coupon'");
		foreach($gcs as $gc)
		{
			if($coupon==$gc->name)
			{
			$couponval=$gc->value;
			session(['couponval' => $couponval]);
			    session('couponval');
				return redirect('/user/'.$user.'/renew_subscription?plan='.$plan.'')->with(array('note' => 'Your Coupon Code successfully Applied', 'note_type' => 'success'));
			}
			else
			{
			return redirect('/user/'.$user.'/renew_subscription?plan='.$plan.'')->with(array('note' => 'Your Coupon Code Invalid', 'note_type' => 'success'));
			}
		}
		return redirect('/user/'.$user.'/renew_subscription?plan='.$plan.'')->with(array('note' => 'Your Coupon Code Invalid', 'note_type' => 'success'));

	}
	public function generate_coupon1()
	{

		$coupon=$_POST['coupon'];
		$user=$_POST['user'];
		$id=$_POST['id'];
		$gcs=DB::select("select * from coupon_code where name='$coupon'");
		foreach($gcs as $gc)
		{
			if($coupon==$gc->name)
			{
			$couponval=$gc->value;
			session(['couponval' => $couponval]);
			    session('couponval');
				return redirect('/user/'.$user.'/renew_subscription?id='.$id.'')->with(array('note' => 'Your Coupon Code successfully Applied', 'note_type' => 'success'));
			}
			else
			{
			return redirect('/user/'.$user.'/renew_subscription?id='.$id.'')->with(array('note' => 'Your Coupon Code Invalid', 'note_type' => 'success'));
			}
		}
		return redirect('/user/'.$user.'/renew_subscription?id='.$id.'')->with(array('note' => 'Your Coupon Code Invalid', 'note_type' => 'success'));

	}

	// ********** RESET PASSWORD ********** //
	public function password_reset()
	{
		$data = array(
			'type' => 'forgot_password',
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'payment_settings' => PaymentSetting::first(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);
		return view('Theme::auth',$data );
	}

	// ********** RESET REQUEST ********** //
	public function password_request()
	{
		$credentials = array('email' => request('email'));
		$response = Password::sendResetLink($credentials, function($message){
			$message->subject('Password Reset Info');
		});

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				return redirect('login')->with(array('note' => trans($response), 'note_type' => 'success'));

			case PasswordBroker::INVALID_USER:
				return redirect()->back()->with(array('note' => trans($response), 'note_type' => 'error'));
		}
	}

	// ********** RESET PASSWORD TOKEN ********** //
	public function password_reset_token($token)
	{
		$data = array(
			'type' => 'reset_password',
			'token' => $token,
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'payment_settings' => PaymentSetting::first(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);
	  return view('Theme::auth',$data );
	}

	// ********** RESET PASSWORD POST ********** //
	public function password_reset_post()
	{

		$credentials = $credentials = array('email' => request('email'), 'password' => request('password'), 'password_confirmation' => request('password_confirmation'), 'token' => request('token'));



		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();

		});

		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				return redirect('login')->with(array('note' => 'Your password has been successfully reset. Please login below', 'note_type' => 'success'));

			default:
				return redirect()->back()->with(array('note' => trans($response), 'note_type' => 'error'));
		}


	}

}
