<?php

namespace HelloVideo\Http\Controllers;

use HelloVideo\Models\ThemeSetting;
use HelloVideo\Models\Setting;
use HelloVideo\Libraries\ThemeHelper;

use Auth;

class AdminThemeSettingsController extends Controller {

	public function theme_settings(){
		$settings = Setting::first();
		$user = Auth::user();
		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			);
		return view('admin.settings.theme_settings',$data );
	}

	public function theme_settings_form(){
		$settings = Setting::first();
		$user = Auth::user();

		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			'theme_settings' => ThemeHelper::getThemeSettings(),
			);
		return view('Theme::includes.settings',$data );
	}

	public function update_theme_settings(){
		// Get the Active Theme
		$active_theme = Setting::first()->theme;

		$input = request()->all();
		foreach($input as $key => $value){
			$this->createOrUpdateThemeSetting($active_theme, $key, $value);
		}

		return redirect('/admin/theme_settings');
	}

	private function createOrUpdateThemeSetting($theme_slug, $key, $value){

       	$setting = array(
        		'theme_slug' => $theme_slug,
        		'key' => $key,
        		'value' => $value
        	);

       	$theme_setting = ThemeSetting::where('theme_slug', '=', $theme_slug)->where('key', '=', $key)->first();

        if (isset($theme_setting->id))
        {
            $theme_setting->update($setting);
            $theme_setting->save();
        }
        else
        {
            ThemeSetting::create($setting);
        }

    }

 }
