<?php

namespace HelloVideo\Http\Controllers;


use HelloVideo\Models\Video;
use HelloVideo\Models\Post;
use HelloVideo\Models\Page;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\Favorite;
use HelloVideo\Models\Menu;
use HelloVideo\Models\PostCategory;
use HelloVideo\Libraries\ThemeHelper;
use HelloVideo\Libraries\ImageHandler;

use Auth;
use DB;

class ThemeFavoriteController extends Controller {

	public function __construct()
	{
		$this->middleware('secure');
	}

	// Add Media Like
	public function favorite(){
		$video_id = request('video_id');
		$favorite = Favorite::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $video_id)->first();
		if(isset($favorite->id)){
			$favorite->delete();
		} else {
			$favorite = new Favorite;
			$favorite->user_id = Auth::user()->id;
			$favorite->video_id = $video_id;
			$favorite->save();
			echo $favorite;
		}
	}

	public function show_favorites(){

		if(!Auth::guest()):

			$page = request('page');

			if(empty($page)){
				$page = 1;
			}

			$favorites = Favorite::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();

			$favorite_array = array();
			foreach($favorites as $key => $fave){
				array_push($favorite_array, $fave->video_id);
			}

			$videos = Video::where('active', '=', '1')->whereIn('id', $favorite_array)->paginate(12);

	        $data = array(
		            'videos' => $videos,
		            'page_title' => ucfirst(Auth::user()->username) . '\'s Favorite Videos',
		            'current_page' => $page,
		            'page_description' => 'Page ' . $page,
		            'menu' => Menu::orderBy('order', 'ASC')->get(),
		            'pagination_url' => '/favorites',
		            'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
	            );

	        return view('Theme::video-list',$data );

	    else:

	    	return redirect('videos');

	    endif;
	}
	public function addvideos()
	{
	return view('Theme::addvideos');
	}
	public function live()
    {
      $msg = "This is a simple message.";
      return response()->json(array('msg'=> $msg), 200);
    }

	public function create_video_user()
	{
	@$p=Auth::user()->id;
	$title = $_POST['title'];
	@$embed_code = $_POST['embed_code'];
	@$full = $_POST['full'];
	@$short = $_POST['short'];
	@$category = $_POST['category'];
	@$access = $_POST['access'];
	@$price = $_POST['price'];
	@$validate1 = $_POST['validate1'];
	@$trailor_embed_code = $_POST['trailor_embed_code'];
	@$embed=$_POST['embed'];
	//$mp4_url1=$_POST['mp4_url1'];
	@$mp4_url=$_POST['mp4_url'];

	if(request()->file('file')=='')
{
 $file = 'placeholder.jpg';
}
else
{
$file = ImageHandler::uploadImage(request()->file('file'), 'images');
}

	$now = \Carbon\Carbon::now();
	@$users10 = DB::select("insert into
	      videos(
					user_id,
					video_category_id,
					title,
					type,
					access,
					details,
					description,
					active,
					image,
					embed_code,
					mp4_url,
					price,
					validate1,
					trailor_embed_code,
					created_at,
					updated_at
					)value(
						'$p',
						'$category',
						'$title',
						'$embed',
						'$access',
						'$full',
						'$short',
						 0,
						'$file',
						'$embed_code',
						'$mp4_url',
						 0,
						'$validate1',
						'$trailor_embed_code',
						'$now',
						'$now')
						");
	//return redirect('/contribute')->with(array('note' => 'Success! One last step, be sure to verify your account by clicking on the activation link sent to your email.', 'note_type' => 'success'));
    return redirect('/my_video')->with(array('note' => 'New Video Successfully Added!', 'note_type' => 'success'));


	}
	public function my_video()
	{
	return view('Theme::myvideos');
	}

	public function viewvideo()
	{
	return view('Theme::viewvideo');
	}

	public function livevideo()
	{
	return view('Theme::livevideo');
	}
	public function show()
	{
	return view('Theme::show');
	}
    public function admin_view_contribute_video()
	{
	return view('Theme::contribute_video');
	}
	public function edit_video()
	{
	return view('Theme::edit_video');
	}
	public function edit_video_user()
	{
	@$p=Auth::user()->id;
	@$p;
	@$editid=$_POST['edit_id'];
	@$title = $_POST['title'];
	@$embed_code = $_POST['embed_code'];
	@$full = $_POST['full'];
	@$short = $_POST['short'];
	@$category = $_POST['category'];
	@$access = $_POST['access'];
	@$price = $_POST['price'];
	@$validate1 = $_POST['validate1'];
	@$trailor_embed_code = $_POST['trailor_embed_code'];
	@$embed=$_POST['embed'];
	//$mp4_url1=$_POST['mp4_url1'];
	@$mp4_url=$_POST['mp4_url'];
	if(request()->file('file')=='')
{
 $file = $_POST['file'];
}
else
{
$file = ImageHandler::uploadImage(request()->file('file'), 'images');
}

	@$users10 = DB::select("update videos set user_id='$p',video_category_id='$category',title='$title',type='$embed',mp4_url='$mp4_url',access='$access',details='$full',description='$short',image='".$file."',embed_code='$embed_code',price='$price',validate1='$validate1',trailor_embed_code='$trailor_embed_code' where id='$editid'");
	//return redirect('/contribute')->with(array('note' => 'Success! One last step, be sure to verify your account by clicking on the activation link sent to your email.', 'note_type' => 'success'));
    return redirect('/my_video')->with(array('note' => ' Video Successfully Updated!', 'note_type' => 'success'));


	}
	public function policy()
	{
	return view('Theme::policy');
	}
	public function about()
	{
	return view('Theme::about');
	}
}
