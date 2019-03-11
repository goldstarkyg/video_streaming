<?php

namespace HelloVideo\Http\Controllers\Api\v1;

use HelloVideo\Http\Controllers\Controller;


use HelloVideo\Models\Setting;
use HelloVideo\Models\Video;
use URL;
use DB;

class TestController extends Controller {

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

    /*
     * login controller
     */
    public function login(){
        $sample = array();
        $sample['test'] = 'This is test';
        return response()->json($sample , 200);
    }

}
