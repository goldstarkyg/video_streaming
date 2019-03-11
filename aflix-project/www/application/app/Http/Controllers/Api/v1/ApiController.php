<?php

namespace HelloVideo\Http\Controllers\Api\v1;

use HelloVideo\Http\Controllers\Controller;


use HelloVideo\Models\Setting;
use HelloVideo\Models\Video;
use URL;
use DB;

class ApiController extends Controller {

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


	public function banners()
	{

		$settings = Setting::first();

		$banners = DB::select("select banner as image,add_link as link from banner where status = 1");

		$videoBanners = Video::select('id' , 'title' , 'image')
		                     ->where('featured' , 1)
		                     ->orderBy('id' , 'Desc')
												 ->limit(5)->get()
												 ->map(function($b) use ($settings){
													 $b['link'] = ($settings->enable_https) ? secure_url('video') : URL::to('video') . '/' . $b->id .'/' . str_replace(' ','-', strtolower($b->title));

													unset($b['title']);
													unset($b['id']);
													 return $b;
												 })->toArray();

		$b = array_map(function($b) use ($settings){
			  $b = (is_array($b)) ? (object) $b : $b;
        $b->image = ($settings->enable_https) ? secure_url('/') : URL::to('/') .'/content/uploads/images/'.$b->image;
				return $b;
		},array_merge($banners , $videoBanners));


		$res = ['errors' => false , 'banners' => $b];

		return response()->json($res, 200);
	}

}
