<?php

namespace HelloVideo\Http\Controllers;


use HelloVideo\Models\ThemeSetting;
use HelloVideo\Models\Setting;
use HelloVideo\Libraries\ImageHandler;

use Auth;

class AdminSettingsController extends Controller {

	public function index()
	{

		$data = array(
			'admin_user' => Auth::user(),
			'settings' => Setting::first(),
			);
		return view('admin.settings.index',$data );
	}

	public function save_settings(){

		$input = request()->all();
		$settings = Setting::first();

		$demo_mode = request('demo_mode');
		$enable_https = request('enable_https');
		$free_registration = request('free_registration');
		$activation_email = request('activation_email');
		$premium_upgrade = request('premium_upgrade');

		if(empty($demo_mode)){
			$input['demo_mode'] = 0;
		}

		if(empty($enable_https)){
			$input['enable_https'] = 0;
		}

		if(empty($free_registration)){
			$input['free_registration'] = 0;
		}

		if(empty($activation_email)){
			$input['activation_email'] = 0;
		}

		if(empty($premium_upgrade)){
			$input['premium_upgrade'] = 0;
		}

		if(request()->has('logo')){
        	$input['logo'] = ImageHandler::uploadImage(request()->file('logo'), 'settings');
        } else { $input['logo'] = $settings->logo; }

        if(request()->has('favicon')){
        	$input['favicon'] = ImageHandler::uploadImage(request()->file('favicon'), 'settings');
        } else { $input['favicon'] = $settings->favicon; }


        $settings->update($input);

        return redirect('admin/settings')->with(array('note' => 'Successfully Updated Site Settings!', 'note_type' => 'success') );

	}

}
