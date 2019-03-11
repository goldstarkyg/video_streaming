<?php

namespace HelloVideo\Http\Controllers;
 

class TestController extends Controller {

	public function __construct()
	{
		//$this->middleware('secure');
	}

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	*/

	public function index()
	{

		echo 'test';
	}

}