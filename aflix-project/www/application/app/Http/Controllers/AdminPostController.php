<?php

namespace HelloVideo\Http\Controllers;



use HelloVideo\Models\Post;
use HelloVideo\Models\PostCategory;
use HelloVideo\Models\Setting;

use Config;
use Validator;
use Auth;

class AdminPostController extends Controller {

    /**
     * Display a listing of videos
     *
     * @return Response
     */
    /*public function index()
    {

        $search_value = request('s');

        if(!empty($search_value)):
            $posts = Post::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(10);
        else:
            $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        endif;

        $user = Auth::user();

        $data = array(
            'posts' => $posts,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return view('admin.posts.index',$data );
    }
public function index()
    {

        $search_value = request('s');

        if(!empty($search_value)):
            $posts = Post::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(10);
        else:
            $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        endif;

        $user = Auth::user();

        $data = array(
            'posts' => $posts,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return view('admin.Subscribe.index',$data );
    }
    /**
     * Show the form for creating a new video
     *
     * @return Response
     */
    /*public function create()
    {
        $data = array(
            'post_route' => url('admin/posts/store'),
            'button_text' => 'Add New Post',
            'admin_user' => Auth::user(),
            'post_categories' => PostCategory::all(),
            );
        return view('admin.posts.create_edit',$data );
    }*/

    /**
     * Store a newly created video in storage.
     *
     * @return Response
     */
    /*public function store()
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

        if(empty($data['active'])){
            $data['active'] = 0;
        }

        $post = Post::create($data);

        return redirect('admin/posts')->with(array('note' => 'New Post Successfully Added!', 'note_type' => 'success') );
    }*/

	public function index()
    {

        /*$search_value = request('s');

        if(!empty($search_value)):
            $posts = Post::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(10);
        else:
            $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        endif;

        $user = Auth::user();

        $data = array(
            'posts' => $posts,
            'user' => $user,
            'admin_user' => Auth::user()
            );*/

        return view('admin.Subscribe.index');
    }

public function create()
    {
        $data = array(
            'post_route' => url('admin/Subscribe/store'),
            'button_text' => 'Add New Subscription Plan',
            'admin_user' => Auth::user(),
            //'post_categories' => PostCategory::all(),
            );
        return view('admin.Subscribe.create_edit',$data );
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

        //$subscribe = Subscribe::create($data);
		$post = Post::create($data);

        return redirect('admin/Subscribe/')->with(array('note' => 'New Subscribe Plan Successfully Added!', 'note_type' => 'success') );
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        $data = array(
            'headline' => '<i class="fa fa-edit"></i> Edit Post',
            'post' => $post,
            'post_route' => url('admin/Subscribe/update'),
            'button_text' => 'Update Subscription Plan',
            'admin_user' => Auth::user(),
            'post_categories' => PostCategory::all(),
            );

        return view('admin.Subscribe.create_edit',$data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
        $data = request()->all();
        $id = $data['id'];
        $post = Post::findOrFail($id);

        $validator = Validator::make($data, Post::$rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $post->update($data);

        return redirect('admin/Subscribe/edit' . '/' . $id)->with(array('note' => 'Subscription Plan Successfully Updated !', 'note_type' => 'success') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $this->deletePostImages($post);

        Post::destroy($id);

        return redirect('admin/Subscribe')->with(array('note' => 'Successfully Deleted Subscription Plan', 'note_type' => 'success') );
    }

    private function deletePostImages($post){
        $ext = pathinfo($post->image, PATHINFO_EXTENSION);

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . $post->image) && $post->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . $post->image);
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $post->image) ) && $post->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-large.' . $ext, $post->image) );
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $post->image) ) && $post->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-medium.' . $ext, $post->image) );
        }

        if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $post->image) ) && $post->image != 'placeholder.jpg'){
            @unlink(Config::get('site.uploads_dir') . 'images/' . str_replace('.' . $ext, '-small.' . $ext, $post->image) );
        }
    }

	public function create1()
	{
	return view('admin/content/create');
	//return redirect('admin/content/create1');
	}

}
