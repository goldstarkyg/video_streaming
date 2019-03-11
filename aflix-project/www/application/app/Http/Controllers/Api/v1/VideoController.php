<?php

namespace HelloVideo\Http\Controllers\Api\v1;


use HelloVideo\Http\Controllers\Controller;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\Setting;
use HelloVideo\Models\Video;
use Auth;

class VideoController extends Controller {

	private $default_limit = 50;
	private $public_columns = array('id', 'video_category_id', 'type', 'access', 'details', 'description', 'featured', 'duration', 'views', 'image', 'created_at', 'updated_at');
	/**
	 * Show all videos.
	 *
	 * @return Json response
	 */
	public function index()
	{
		$response = Video::where('active', '=', '1');

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

	public function video($id)
	{
		$settings = Setting::first();
		$video = Video::find($id);

		// If user has access to all the content
		if($video->access == 'guest' || ( ($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ){
			$columns = null;
		// Else we need to restrict the columns we return
		} else {
			$columns = $this->public_columns;
		}
		return response()->json(Video::where('id', '=', $id)->get($columns), 200);
	}

	public function video_categories(){
		return response()->json(VideoCategory::orderBy('order')->get(), 200);
	}

	public function video_category($id){
		$video_category = VideoCategory::find($id);
		return response()->json($video_category, 200);
	}

	public function categoryVideoList($id){
		$videos = Video::where('video_category_id' , $id)->get();

		$res = ['errors' => false , 'videos' => $videos];

		return response()->json($res, 200);
	}

	public function suggestions()
	{
		$id = request('id');

		$video = Video::where('id', $id)->first();

		$suggestions = new Video;

		foreach (explode(' ' , $video->title) as $title) {
			$suggestions = $suggestions->orWhere('title' , 'like' , "%$title%");
		}

		$suggestions = $suggestions->get()->reject(function($v) use ($video){
			return $v->id == $video->id;
		});

		if(! $suggestions->count()){

			$suggestions = Video::where('video_category_id' , $video->video_category_id)
			                     ->where('id' , '!=' , $video->id)->get();
		}

		$res = ['errors' => false , 'videos' => $suggestions];

		return response()->json($res, 200);
	}
	public function popular()
	{
		$videos = Video::where('active', 1)->orderBy('views', 'DESC')->take(4)->get();

		$res = ['errors' => false , 'videos' => $videos];

		return response()->json($res, 200);
	}

	public function recent()
	{
		$videos = Video::where('active', 1)->limit(10)->orderBy('id' , 'DESC')->get();

		$res = ['errors' => false , 'videos' => $videos];

		return response()->json($res, 200);
	}

	public function subscribed()
	{
		$videos = Video::where('active', 1)->where('access' , 'subscriber')->get();

		$res = ['errors' => false , 'videos' => $videos];

		return response()->json($res, 200);
	}

	public function search()
	{
		$search_value = request('search_word');

		if(empty($search_value)){
			$res = ['errors' => ['msg' => 'You Can\'t Search By empty text']];

			return response()->json($res, 200);
		}

		$videos = Video::where('active', '=', 1)->where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();

		$res = ['errors' => false , 'videos' => $videos];

		return response()->json($res, 200);
	}


}
