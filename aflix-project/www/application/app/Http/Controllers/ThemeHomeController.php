<?php

namespace HelloVideo\Http\Controllers;

use HelloVideo\Models\Video;
use HelloVideo\Models\Post;
use HelloVideo\Models\Page;
use HelloVideo\Models\Setting;
use HelloVideo\Models\Menu;
use HelloVideo\User;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\PostCategory;
use HelloVideo\Libraries\ThemeHelper;

use Cookie;
use Auth;

class ThemeHomeController extends Controller {

	private $videos_per_page = 12;

	public function __construct()
	{

		$this->middleware('secure');
		$settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;
	}

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	*/

	public function index()
	{
	
		if(request('theme')){
			Cookie::queue('theme', \request('theme'), 100);
			return redirect('/')->withCookie(cookie('theme', \request('theme'), 100));
		}


		$data = array(
			'videos' => Video::where('active', '=', '1')->orderBy('created_at', 'DESC')->simplePaginate($this->videos_per_page),
			'current_page' => 1,
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'pagination_url' => '/videos',
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);


		return view('Theme::home',$data );
	}

}
