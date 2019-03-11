<?php

namespace HelloVideo\Http\Controllers;

use HelloVideo\Models\Setting;
use HelloVideo\Libraries\ThemeHelper;

use Auth;

class AdminThemesController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	public function index()
	{
		$data = array(
			'admin_user' => Auth::user(),
			'themes' => ThemeHelper::get_themes(),
			'active_theme' => Setting::first()->theme
			);

		return view('admin.themes.index',$data );
	}

	public function activate($slug)
	{
		$settings = Setting::first();
		$settings->theme = $slug;
		$settings->save();
		return redirect('admin/themes')->with(array('note' => 'Successfully Activated ' . ucfirst($slug) . ' Theme', 'note_type' => 'success'));
	}

}
