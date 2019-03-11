<?php

namespace HelloVideo\Http\Controllers;


use HelloVideo\Models\Video;
use HelloVideo\Models\Post;
use HelloVideo\Models\Page;
use HelloVideo\Models\VideoCategory;
use HelloVideo\Models\PostCategory;
use HelloVideo\Libraries\ThemeHelper;

use HelloVideo\User;

use Auth;

class ThemePageController extends Controller {

    public function __construct()
    {
        $this->middleware('secure');
    }

    /**
     * Display the specified post.
     *
     * @param  int  $id
     * @return Response
     */
    public function index($slug)
    {
        $page = Page::where('slug', '=', $slug)->first();

        //Make sure page is active
        if((!Auth::guest() && Auth::user()->role == 'admin') || $page->active){

            $author = User::find($page->user_id);
            $data = array(
                    'page' => $page,
                    'author' => $author,
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'video_categories' => VideoCategory::all(),
                    'post_categories' => PostCategory::all(),
                    'theme_settings' => ThemeHelper::getThemeSettings(),
                    'pages' => Page::where('active', '=', 1)->get(),
                );
            return view('Theme::page',$data );

        } else {
            return redirect('pages')->with(array('note' => 'Sorry, this page is no longer active.', 'note_type' => 'error'));
        }
    }

    /*
     * Page That shows the latest video list
     *
     */
    public function pages()
    {
        $data = array(
                'pages' => Page::orderBy('created_at', 'DESC')->get(),
                'page_title' => 'Pages',
                'page_description' => 'All Pages',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
            );

        return view('Theme::page-list',$data );
    }

}
