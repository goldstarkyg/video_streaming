<?php

namespace HelloVideo\Http\Controllers;


use HelloVideo\Models\Video;
use HelloVideo\Models\Post;
use HelloVideo\Models\Page;
use HelloVideo\Models\Tag;
use HelloVideo\Models\Ad;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\PostCategory;
use HelloVideo\Libraries\ThemeHelper;
use HelloVideo\Libraries\ImageHandler;
use HelloVideo\Libraries\TimeHelper;
use HelloVideo\User;

use Validator;
use Auth;
use DB;
use Config;


class AdminVideosController extends Controller {

    /**
     * Display a listing of videos
     *
     * @return Response
     */
    public function index()
    {

        $search_value = request('s');
        $published = request('published');

        if(!empty($search_value)):
            $videos = Video::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc');
        else:
			      $videos = Video:: orderBy('created_at', 'DESC');
        endif;


        if($published){

          if($published == 1){
            $videos->where('active' , 1);
          }else if ($published == 2){
            $videos->where('active' , 0);
          }
        }

        //corp admin
//        if($corp_id = request('corp_admin')){
//          $videos->where('user_id' , $corp_id);
//        }
        if(Auth::user()->corporate_user == 'Corporate_Admin'){
            $videos->where('user_id' , Auth::user()->id);
        }
        //contribute
        if(Auth::user()->contribute == 'contribute' ) {
            $videos->where('user_id' , Auth::user()->id);
        }

        $user = Auth::user();

        $corps = User::where('role' , 'admin')
                      ->where('corporate_user' , 'Corporate_Admin')
                      ->get();


        $videos = $videos->paginate(8);

        $data = array(
            'videos' => $videos,
            'user' => $user,
            'corps' =>$corps,
            'admin_user' => $user
            );
       
        return view('admin.videos.index',$data );
    }

    public function publish($id)
    {  
		$video = Video::find($id);
		$video->active = 1;
		$video->live = 'live';
        $video->save();
        return redirect()->back();
    }
	
    public function unpublish($id)
    {

       // Video::where('id' , $id)->update(['active' => 0, 'live' => 0]);
        $video = Video::find($id);
		$video->active = 0;
		$video->live = 0;
        $video->save();
        return redirect()->back();

    }

    public function showEditAdd($id)
    {

      $ad = Ad::where('id' , $id)->first();

      return view('admin.videos.update_add' , compact('ad'));
    }


    public function editAdd($id)
    {
      if(empty(request('status'))) {
          $status = '0';
          request()->merge(compact('status'));
      }
      $second = TimeHelper::collapse(request('time'));
      request()->merge(compact('second'));
      Ad::where('id' , $id)->update(request()->except('_token'));

      return redirect()->back();
    }

	public function index1()
    {
	 return view('admin.videos.index1');
	}

	public function index3()
    {
	 return view('admin.videos.index3');
	}
	public function index4()
    {
	 return view('admin.users.index4');
	}
	public function index5()
    {
	 return view('admin.videos.index5');
	}
	public function index6()
    {
	 return view('admin.videos.index6');
	}
	public function banner()
    {
	 return view('admin.videos.banner');
	}
	public function addbanner()
    {
             $file = ImageHandler::uploadImage(request()->file('file'), 'images');
             $add_link=$_POST['add_link'];


if(isset($_POST['open'])){
    $open=intval($_POST['open']);
    $banner=DB::select("insert into banner(banner,add_link,open,status)value('".$file."','".$add_link."','".$open."','1')");
}else{

			  $banner=DB::select("insert into banner(banner,add_link,open,status)value('".$file."','".$add_link."',0,'1')");
			 }
	 //return view('admin.videos.banner');
	 return redirect('admin/videos/banner')->with(array('note' => 'Slider Successfully Added!', 'note_type' => 'success'));

	}
	public function add_ads()
    {

        $status = 1;
        $second = TimeHelper::collapse(request('time'));
        request()->merge(compact('status' , 'time'));
        Ad::create(request()->except(['_token','submit']));

	 return redirect('admin/videos/index3')->with(array('note' => 'Ads Successfully Added!', 'note_type' => 'success'));
	}

	public function thumbsection()
    {
	 $section=$_POST['section'];
     $id=$_POST['id'];
	 $sec=DB::select("update thumnail_section set name='$section' where id='$id'");
	 return redirect('admin/videos/index6')->with(array('note' => 'Section Successfully Updated !', 'note_type' => 'success'));
	}

	public function post_add()
    {
	 $ads=$_POST['ads'];
   $id=$_POST['id'];

	 $ads=DB::select("update videos set ads='$ads' where id='$id'");
	 return redirect('admin/videos')->with(array('note' => 'Ads Successfully Added On Video!', 'note_type' => 'success'));
	}

  public function disable_add($id)
  {

    Video::where('id' , $id)->update(['ads' => '']);
    return redirect('admin/videos')->with(array('note' => 'Ads Successfully Disabled On Video!', 'note_type' => 'success'));
  }

	public function assignto()
    {
		$count = 0;
	    $count = count($_POST['user'])-1;
        $video_id=$_POST['id'];
        $del_assign = DB::select("delete  from assignto where video_id='".$video_id."'");
		for($i = 0; $i <= $count; $i++){
		    $user=$_POST['user'][$i];
            $id=$_POST['id'];
			$p1=DB::select("select * from assignto where video_id='$id' AND user_id='$user'");
			$id1="";
			$user1="";
			foreach($p1 as $p2)
			{
				if($id1=="")
				{

					$id1=$p2->video_id;

				}
				else
				{

					$id1=$p2->video_id;
				}
				if($user1=="")
				{

					$user1=$p2->user_id;

				}
				else
				{
					$user1=$p2->user_id;

				}
			}

			if($id==$id1 AND $user==$user1)
			{
				return redirect('admin/videos')->with(array('note' => '  Video Already  Assign ', 'note_type' => 'success'));

			}
			else
			{
	     $ads=DB::select("insert into assignto(video_id,user_id,ass_date)value('$id','$user',now())");
		 $ass=DB::select("update videos set ass=1 where id='$id'");
			}
		}
	 return redirect('admin/videos')->with(array('note' => ' Video Assign To Corporate Admin Successfully!', 'note_type' => 'success'));
	}

    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Video',
            'post_route' => url('admin/videos/store'),
            'button_text' => 'Add New Video',
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            );
        return view('admin.videos.create_edit',$data );
    }

    /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function store()
    {

        $validator = Validator::make($data = request()->all(), Video::$rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = (isset($data['image'])) ? $data['image'] : '';
        if(!empty($image)){
            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');

        } else {
            $data['image'] = 'placeholder.jpg';
        }
		$bannerImg = (isset($data['bannerImg'])) ? $data['bannerImg'] : '';
        if(!empty($bannerImg)){
            $data['bannerImg'] = ImageHandler::uploadImage($data['bannerImg'], 'file');

        } else {
            $data['bannerImg'] = '';
        }


		@$subtitle = request()->file('subtitle');
		if($subtitle!='')
		{
        $destinationPath = 'content/uploads/avatars';
        $subtitle->move($destinationPath);
        }
        $tags = $data['tags'];
        unset($data['tags']);

		  if(empty($data['user_id'])){
            $data['user_id'] = 1;
        }


        if(empty($data['active'])){
            $data['active'] = 0;
        }else{
//			 $data['live'] = 'live';
		}

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
       if(empty($data['price'])){
            $data['price'] = 0;
        }
		if(empty($data['mp4_url'])){
            $data['mp4_url'] = "";
        }
        if(empty($data['validate1'])){
            $data['validate1'] = 0;
        }
        if(empty($data['trailor_embed_code']))
        {
            $data['trailor_embed_code'] = "";
        }
        if(empty($data['live']))
        {
            $data['live'] = 0;
        }

        if(empty($data['type1']))
        {
            $data['type1'] = 0;
        }

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }


        $data['ads'] = "";
        $data['ass'] = 1;
        $data['ads_link'] = "";
        $data['subtitle'] = "";
        $data['delbycontri'] = 1;
        $data['details'] = (isset($data['details'])) ? $data['details'] : "";
       
        $video = Video::create($data);
        $this->addUpdateVideoTags($video, $tags);
		
        if(Auth::user()->contribute == 'contribute'){
			return redirect('admin')->with(array('note' => 'Successfully Deleted Video', 'note_type' => 'success') );
		}else{
			return redirect('admin/videos')->with(array('note' => 'New Video Successfully Added!', 'note_type' => 'success') );
		}
        
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $video = Video::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'post_route' => url('admin/videos/update'),
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            );

        return view('admin.videos.create_edit',$data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
        $input = request()->all();
        $id = $input['id'];
        $video = Video::findOrFail($id);

        $validator = Validator::make($data = $input, Video::$rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tags = $data['tags'];
        unset($data['tags']);
        $this->addUpdateVideoTags($video, $tags);

 if(empty($data['price'])){
            $data['price'] = 0;
        }



  if(empty($data['validate1'])){
            $data['validate1'] = 0;
        }

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        if(empty($data['image'])){
            unset($data['image']);
        } else {
            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');

        }

            if(empty($data['bannerImg'])){
            unset($data['bannerImg']);
        } else {
            $data['bannerImg'] = ImageHandler::uploadImage($data['bannerImg'], 'file');

        }
			//$data['bannerImg'] = ImageHandler::uploadImage($data['bannerImg'], 'file');


        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }

        $data['trailor_embed_code'] ='';
        $data['details'] = ( is_null(request('details')) ) ? '' : request('details');
        $data['description'] = ( is_null(request('description')) ) ? '' : request('description');

        $video->update($data);

        return redirect('admin/videos/edit' . '/' . $id)->with(array('note' => 'Successfully Updated Video!', 'note_type' => 'success') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $video = Video::find($id);

        // Detach and delete any unused tags
        foreach($video->tags as $tag){
            $this->detachTagFromVideo($video, $tag->id);
            if(!$this->isTagContainedInAnyVideos($tag->name)){
                $tag->delete();
            }
        }

        $this->deleteVideoImages($video);

        Video::destroy($id);
        if(Auth::user()->contribute == 'contribute'){
			return redirect('admin')->with(array('note' => 'Successfully Deleted Video', 'note_type' => 'success') );
		}else{
			return redirect('admin/videos')->with(array('note' => 'Successfully Deleted Video', 'note_type' => 'success') );
		}
        
    }

    private function addUpdateVideoTags($video, $tags){
        $tags = array_map('trim', explode(',', $tags));


        foreach($tags as $tag){

            $tag_id = $this->addTag($tag);
            $this->attachTagToVideo($video, $tag_id);
        }

        // Remove any tags that were removed from video
        foreach($video->tags as $tag){
            if(!in_array($tag->name, $tags)){
                $this->detachTagFromVideo($video, $tag->id);
                if(!$this->isTagContainedInAnyVideos($tag->name)){
                    $tag->delete();
                }
            }
        }
    }

    /**************************************************
    /*
    /*  PRIVATE FUNCTION
    /*  addTag( tag_name )
    /*
    /*  ADD NEW TAG if Tag does not exist
    /*  returns tag id
    /*
    /**************************************************/

    private function addTag($tag){
        $tag_exists = Tag::where('name', '=', $tag)->first();

        if($tag_exists){
            return $tag_exists->id;
        } else {
            $new_tag = new Tag;
            $new_tag->name = strtolower($tag);
            $new_tag->save();
            return $new_tag->id;
        }
    }

    /**************************************************
    /*
    /*  PRIVATE FUNCTION
    /*  attachTagToVideo( video object, tag id )
    /*
    /*  Attach a Tag to a Video
    /*
    /**************************************************/

    private function attachTagToVideo($video, $tag_id){
        // Add New Tags to video
        if (!$video->tags->contains($tag_id)) {
            $video->tags()->attach($tag_id);
        }
    }

    private function detachTagFromVideo($video, $tag_id){
        // Detach the pivot table
        $video->tags()->detach($tag_id);
    }

    public function isTagContainedInAnyVideos($tag_name){
        // Check if a tag is associated with any videos
        $tag = Tag::where('name', '=', $tag_name)->first();
        return (!empty($tag) && $tag->videos->count() > 0) ? true : false;
    }

    private function deleteVideoImages($video){
        $ext = pathinfo($video->image, PATHINFO_EXTENSION);
        if(file_exists(Config::get('site.uploads_dir') . 'images/' . $video->image) && $video->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . $video->image);
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $video->image) )  && $video->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $video->image) );
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $video->image) )  && $video->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $video->image) );
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $video->image) )  && $video->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $video->image) );
        }
    }

	 public function create1()
    {
        $data = array(
            'headline' => '<i class="fa fa-plus-circle"></i> New Video',
            'post_route' => url('admin/videos/store1'),
            'button_text' => 'Add New Video',
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            );
        return view('admin.videos.create_edit1',$data );
    }

    /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    public function store1()
    {
        $validator = Validator::make($data = request()->all(), Video::$rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = (isset($data['image'])) ? $data['image'] : '';
        if(!empty($image)){
            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');
        } else {
            $data['image'] = 'placeholder.jpg';
        }

        $tags = $data['tags'];
        unset($data['tags']);

		  if(empty($data['user_id'])){
            $data['user_id'] = 1;
        }


        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }
       if(empty($data['price'])){
            $data['price'] = 0;
        }



  if(empty($data['validate1'])){
            $data['validate1'] = 0;
        }
if(empty($data['trailor_embed_code']))
{
 $data['trailor_embed_code'] = 0;
   }
   if(empty($data['live']))
{
 $data['live'] = 0;
   }

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        $video = Video::create($data);
        $this->addUpdateVideoTags($video, $tags);

        return redirect('admin/videos/index1')->with(array('note' => 'New Video Successfully Added!', 'note_type' => 'success') );
    }

	public function edit1($id)
    {
        $video = Video::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Video',
            'video' => $video,
            'post_route' => url('admin/videos/update1'),
            'button_text' => 'Update Video',
            'admin_user' => Auth::user(),
            'video_categories' => VideoCategory::all(),
            );

        return view('admin.videos.create_edit1',$data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update1()
    {
        $input = request()->all();
        $id = $input['id'];
        $video = Video::findOrFail($id);

        $validator = Validator::make($data = $input, Video::$rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tags = $data['tags'];
        unset($data['tags']);
        $this->addUpdateVideoTags($video, $tags);

 if(empty($data['price'])){
            $data['price'] = 0;
        }



  if(empty($data['validate1'])){
            $data['validate1'] = 0;
        }

        if(isset($data['duration'])){
                //$str_time = $data
                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $data['duration']);
                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                $data['duration'] = $time_seconds;
        }

        if(empty($data['image'])){
            unset($data['image']);
        } else {
            $data['image'] = ImageHandler::uploadImage($data['image'], 'images');
        }

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        if(empty($data['featured'])){
            $data['featured'] = 0;
        }

        $video->update($data);

        return redirect('admin/videos/edit1' . '/' . $id)->with(array('note' => 'Successfully Updated Video!', 'note_type' => 'success') );
    }

}
