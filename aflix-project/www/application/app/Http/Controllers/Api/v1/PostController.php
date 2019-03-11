<?php

namespace HelloVideo\Http\Controllers\Api\v1;


use HelloVideo\Http\Controllers\Controller;
use HelloVideo\Models\PostCategory;
use HelloVideo\Models\Setting;
use HelloVideo\Models\Post;
use Auth;

class PostController extends Controller {

	private $default_limit = 50;
	private $public_columns = array('id', 'post_category_id', 'title', 'slug', 'image', 'body_guest', 'access', 'created_at', 'updated_at');
	/**
	 * Show all posts.
	 *
	 * @return Json response
	 */
	public function index()
	{
		$response = Post::where('active', '=', 1);

		if(request('offset')){
			$reponse = $response->skip(request('offset'));
		}

		if( request('filter') && request('order') ){
			$response = $response->orderBy(request('filter'), request('order'));
		} else {
			$response = $response->orderBy('created_at', 'desc');
		}

		if(request('limit')){
			$response = $response->take(request('limit'));
		} else {
			$response = $response->take($this->default_limit);
		}

		return response()->json($response->get($this->public_columns), 200);
	}

	public function post($id)
	{
		$settings = Setting::first();
		$post = Post::find($id);

		// If user has access to all the content
		if($post->access == 'guest' || ( ($post->access == 'subscriber' || $post->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $post->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ){
			$columns = null;
		// Else we need to restrict the columns we return
		} else {
			$columns = $this->public_columns;
		}
		return response()->json(Post::where('id', '=', $id)->get($columns), 200);
	}

	public function post_categories(){
		return response()->json(PostCategory::orderBy('order')->get(), 200);
	}

	public function post_category($id){
		$post_category = PostCategory::find($id);
		return response()->json($post_category, 200);
	}

}
