<?php

namespace HelloVideo\Http\Controllers;


use HelloVideo\Models\Video;
use HelloVideo\Models\Post;
use HelloVideo\Models\Page;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\Menu;
use HelloVideo\Models\PostCategory;
use HelloVideo\Libraries\ThemeHelper;

class ThemeSearchController extends Controller {

	public function __construct()
	{
		$this->middleware('secure');
	}

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	*/

	public function index()
	{
		$search_value = request('value');

		if(empty($search_value)){
			return redirect('/');
		}
		$videos = Video::where('active', '=', 1)->where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();
		$posts = Post::where('active', '=', 1)->where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();

		$data = array(
			'videos' => $videos,
			'posts' => $posts,
			'search_value' => $search_value,
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);

		return view('Theme::search-list',$data );
	}

}
