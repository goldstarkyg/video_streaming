<?php

namespace HelloVideo\Http\Controllers;

use HelloVideo\Models\Video;
use HelloVideo\Models\Favorite;
use HelloVideo\Models\Menu;
use HelloVideo\Models\Page;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\PaymentSetting;
use HelloVideo\Models\PostCategory;
use HelloVideo\Libraries\ThemeHelper;
use HelloVideo\Libraries\ImageHandler;

use HelloVideo\User;
use Hash;
use Auth;


class ThemeUserController extends Controller{


    public function __construct()
    {
        $this->middleware('secure');
    }

	public static $rules = array(
		'username' => 'required|unique:users',
                            'email' => 'required|email|unique:users',
                            'password' => 'required|confirmed'
                        );

    public function index($username){
    	$user = User::where('username', '=', $username)->first();

        $favorites = Favorite::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();

        $favorite_array = array();
        foreach($favorites as $key => $fave){
            array_push($favorite_array, $fave->video_id);
        }

        $videos = Video::where('active', '=', '1')->whereIn('id', $favorite_array)->take(9)->get();

    	$data = array(
                    'user' => $user,
                    'type' => 'profile',
                    'videos' => $videos,
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'video_categories' => VideoCategory::all(),
                    'post_categories' => PostCategory::all(),
                    'theme_settings' => ThemeHelper::getThemeSettings(),
                    'pages' => Page::where('active', '=', 1)->get(),
    	);
    	return view('Theme::user',$data );
    }

    public function edit($username){
    	if(!Auth::guest() && Auth::user()->username == $username){

	    	$user = User::where('username', '=', $username)->first();
	    	$data = array(
                                'user' => $user,
                                'post_route' => url('user') . '/' . $user->username . '/update',
                                'type' => 'edit',
                                'menu' => Menu::orderBy('order', 'ASC')->get(),
                                'video_categories' => VideoCategory::all(),
                                'post_categories' => PostCategory::all(),
                                'theme_settings' => ThemeHelper::getThemeSettings(),
                                'pages' => Page::where('active', '=', 1)->get(),
	    		);
	    	return view('Theme::user',$data );

	    } else {
	    	return redirect('/');
	    }
    }

    public function update($username){

    	$input = array_except(request()->all(), '_method');
		$input['username'] = str_replace('.', '-', $input['username']);

		$user = User::where('username', '=', $username)->first();

		if (Auth::user()->id == $user->id)
		{

			if(request()->has('avatar')){
            	$input['avatar'] = ImageHandler::uploadImage(request()->file('avatar'), 'avatars');
            } else { $input['avatar'] = $user->avatar; }

            if($input['password'] == ''){
            	$input['password'] = $user->password;
            } else{ $input['password'] = Hash::make($input['password']); }

            if($user->username != $input['username']){
            	$username_exist = User::where('username', '=', $input['username'])->first();
            	if($username_exist){
            		return redirect('user/' .$user->username . '/edit')->with(array('note' => 'Sorry That Username is already in Use', 'note_type' => 'error') );
            	}
            }

			$user->update($input);

			return redirect('user/' .$user->username . '/edit')->with(array('note' => 'Successfully Updated User Info', 'note_type' => 'success') );
		}

		return redirect('user/' . Auth::user()->username . '/edit ')->with(array('note' => 'Sorry, there seems to have been an error when updating the user info', 'note_type' => 'error') );

    }


    public function billing($username){
        if(Auth::guest()):
            return redirect('/');
        endif;

        if(Auth::user()->username == $username){

        if(Auth::user()->role == 'admin' || Auth::user()->role == 'admin'){
            return redirect('/user/' . $username . '/edit')->with(array('note' => 'This user type does not have billing info associated with their account.', 'note_type' => 'warning'));
        }

            $user = User::where('username', '=', $username)->first();

            $payment_settings = PaymentSetting::all();

            if($payment_settings[0]->live_mode){
                User::setStripeKey( $payment_settings[0]->live_secret_key );
            } else {
                User::setStripeKey( $payment_settings[0]->test_secret_key );
            }

            $invoices = $user->invoices();

            $data = array(
                    'user' => $user,
                    'post_route' => url('user') . '/' . $user->username . '/update',
                    'type' => 'billing',
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'video_categories' => VideoCategory::all(),
                    'post_categories' => PostCategory::all(),
                    'theme_settings' => ThemeHelper::getThemeSettings(),
                    'payment_settings' => $payment_settings,
                    'invoices' => $invoices,
                    'pages' => Page::where('active', '=', 1)->get(),
                );
            return view('Theme::user',$data );

        } else {
            return redirect('/');
        }
    }

    public function cancel_account($username){
        if(Auth::guest()):
            return redirect('/');
        endif;

        if(Auth::user()->username == $username){

            $payment_settings = PaymentSetting::all();

            if($payment_settings[0]->live_mode){
                User::setStripeKey( $payment_settings[0]->live_secret_key );
            } else {
                User::setStripeKey( $payment_settings[0]->test_secret_key );
            }

            $user = Auth::user();
            $user->subscription()->cancel();

            return redirect('user/' . $username . '/billing')->with(array('note' => 'Your account has been cancelled.', 'note_type' => 'success') );
        }
    }

    public function resume_account($username){
        if(Auth::guest()):
            return redirect('/');
        endif;

        if(Auth::user()->username == $username){

            $payment_settings = PaymentSetting::all();

            if($payment_settings[0]->live_mode){
                User::setStripeKey( $payment_settings[0]->live_secret_key );
            } else {
                User::setStripeKey( $payment_settings[0]->test_secret_key );
            }

            $user = Auth::user();
            $user->subscription('monthly')->resume();

            return redirect('user/' . $username . '/billing')->with(array('note' => 'Welcome back, your account has been successfully re-activated.', 'note_type' => 'success') );
        }

    }

    public function update_cc_store($username){
        if(Auth::guest()):
            return redirect('/');
        endif;

        $payment_settings = PaymentSetting::all();

        if($payment_settings[0]->live_mode){
            User::setStripeKey( $payment_settings[0]->live_secret_key );
        } else {
            User::setStripeKey( $payment_settings[0]->test_secret_key );
        }

        $user = Auth::user();

        if(Auth::user()->username == $username){

            $token = request('stripeToken');

            try{

                $user->subscription('monthly')->resume($token);
                return redirect('user/' . $username . '/billing')->with(array('note' => 'Your Credit Card Info has been successfully updated.', 'note_type' => 'success'));

            } catch(Exception $e){
                return redirect('/user/' . $username . '/update_cc')->with(array('note' => 'Sorry, there was an error with your card: ' . $e->getMessage(), 'note_type' => 'error'));
            }

        } else {
            return redirect('user/' . $username);
        }

    }

    public function update_cc($username){
        if(Auth::guest()):
            return redirect('/');
        endif;

        $payment_settings = PaymentSetting::all();

        if($payment_settings[0]->live_mode){
            User::setStripeKey( $payment_settings[0]->live_secret_key );
        } else {
            User::setStripeKey( $payment_settings[0]->test_secret_key );
        }

        $user = Auth::user();

        if(Auth::user()->username == $username && $user->subscribed()){

            $data = array(
                'user' => $user,
                'post_route' => url('user') . '/' . $user->username . '/update',
                'type' => 'update_credit_card',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'payment_settings' => $payment_settings,
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
                );

            return view('Theme::user',$data );
        } else {
            return redirect('user/' . $username);
        }

    }

    public function renew($username){

        if(Auth::guest()):
            return redirect('/');
        endif;


        $user = User::where('username', '=', $username)->first();

        $payment_settings = PaymentSetting::all();

        if(isset($payment_settings[0])){          
          if($payment_settings[0]->live_mode){
            User::setStripeKey( $payment_settings[0]->live_secret_key );
          } else {
            User::setStripeKey( $payment_settings[0]->test_secret_key );
          }
        }

        if(strtolower(Auth::user()->username) == strtolower($username)){

            $data = array(
                    'user' => $user,
                    'post_route' => url('user') . '/' . $user->username . '/update',
                    'type' => 'renew_subscription',
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'payment_settings' => $payment_settings,
                    'video_categories' => VideoCategory::all(),
                    'post_categories' => PostCategory::all(),
                    'theme_settings' => ThemeHelper::getThemeSettings(),
                    'pages' => Page::where('active', '=', 1)->get(),
                );

            return view('Theme::user',$data );
        } else {
            return redirect('/');
        }
    }

    public function upgrade($username){
        if(Auth::guest()):
            return redirect('/');
        endif;

        $user = User::where('username', '=', $username)->first();

        $payment_settings = PaymentSetting::all();

        if($payment_settings[0]->live_mode){
            User::setStripeKey( $payment_settings[0]->live_secret_key );
        } else {
            User::setStripeKey( $payment_settings[0]->test_secret_key );
        }

        if(Auth::user()->username == $username){

            $data = array(
                    'user' => $user,
                    'post_route' => url('user') . '/' . $user->username . '/update',
                    'type' => 'upgrade_subscription',
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'payment_settings' => $payment_settings,
                    'video_categories' => VideoCategory::all(),
                    'post_categories' => PostCategory::all(),
                    'theme_settings' => ThemeHelper::getThemeSettings(),
                    'pages' => Page::where('active', '=', 1)->get(),
                );

            return view('Theme::user',$data );
        } else {
            return redirect('/');
        }
    }

    public function upgrade_cc_store($username){
        if(Auth::guest()):
            return redirect('/');
        endif;

        $payment_settings = PaymentSetting::all();

        if($payment_settings[0]->live_mode){
            User::setStripeKey( $payment_settings[0]->live_secret_key );
        } else {
            User::setStripeKey( $payment_settings[0]->test_secret_key );
        }

        $user = User::find(Auth::user()->id);

        if(Auth::user()->username == $username){

            $token = request('stripeToken');

            try{

                $user->subscription('monthly')->create($token, ['email' => $user->email]);
                $user->role = 'subscriber';
                $user->save();
                return redirect('user/' . $username . '/billing')->with(array('note' => 'You have been successfully signed up for a subscriber membership!', 'note_type' => 'success'));

            } catch(Exception $e){
                return redirect('/user/' . $username . '/upgrade_subscription')->with(array('note' => 'Sorry, there was an error with your card: ' . $e->getMessage(), 'note_type' => 'error'));
            }

        } else {
            return redirect('user/' . $username);
        }

    }

}
