<?php

namespace HelloVideo\Http\Controllers;

use HelloVideo\User;
use HelloVideo\Models\Countribute;
use HelloVideo\Models\SubscriptionPlan;
use HelloVideo\Models\VideoView;
use HelloVideo\Models\ContributorPayout;
use HelloVideo\Libraries\WistiaApi;
use Illuminate\Http\Request;
use DB;
use Auth;
class AdminMediaController extends Controller {

	public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware('isAdmin');
    }

	public function index()
	{
		return view('admin.media.index');
	}

	public function files(){
		$folder = request('folder');
		if($folder == '/'){ $folder = ''; }
		$dir = "./content/uploads" . $folder;

		$response = $this->getFiles($dir);

		return response()->json(array(
			"name" => "files",
			"type" => "folder",
			"path" => $dir,
			"folder" => $folder,
			"items" => $response,
			"last_modified" => date('F jS, Y \a\t h:i:s A', filemtime($dir))
		));
	}

	private function getFiles($dir){


		$files = array();

		// Is there actually such a folder/file?

		if(file_exists($dir)){

			foreach(scandir($dir) as $f) {

				if(!$f || $f[0] == '.') {
					continue; // Ignore hidden files
				}

				if(is_dir($dir . '/' . $f)) {

					// The path is a folder

					$files[] = array(
						"name" => $f,
						"type" => "folder",
						"path" => $dir . '/' . $f,
						"items" => $this->getNumberOfFilesInDir($dir . '/' . $f),
						"last_modified" => date('F jS, Y \a\t h:i:s A', filemtime($dir . '/' . $f))
					);
				}

				else if( $this->is_image($dir . '/' . $f) ) {

					$files[] = array(
						"name" => $f,
						"type" => "image",
						"path" => $dir . '/' . $f,
						"size" => filesize($dir . '/' . $f), // Gets the size of this file
						"last_modified" => date('F jS, Y \a\t h:i:s A', filemtime($dir . '/' . $f))
					);

				}

				else if( strstr(mime_content_type($dir . '/' . $f), "video/") ) {
					$files[] = array(
						"name" => $f,
						"type" => "video",
						"path" => $dir . '/' . $f,
						"size" => filesize($dir . '/' . $f), // Gets the size of this file
						"last_modified" => date('F jS, Y \a\t h:i:s A', filemtime($dir . '/' . $f))
					);
				}

				else if( strstr(mime_content_type($dir . '/' . $f), "audio/") ) {
					$files[] = array(
						"name" => $f,
						"type" => "audio",
						"path" => $dir . '/' . $f,
						"size" => filesize($dir . '/' . $f), // Gets the size of this file
						"last_modified" => date('F jS, Y \a\t h:i:s A', filemtime($dir . '/' . $f))
					);
				}

				else {

					// It is a file

					$files[] = array(
						"name" => $f,
						"type" => "file",
						"path" => $dir . '/' . $f,
						"size" => filesize($dir . '/' . $f), // Gets the size of this file
						"last_modified" => date('F jS, Y \a\t h:i:s A', filemtime($dir . '/' . $f))
					);
				}
			}

		}

		return $files;

	}

	private function is_image($path)
	{
		$a = getimagesize($path);
		$image_type = $a[2];

		if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
		{
			return true;
		}
		return false;
	}

	private function getNumberOfFilesInDir($dir){
		$count = 0;
		if(file_exists($dir)){
			$files = scandir($dir);
			foreach($files as $file){
				if(!$file || $file[0] == '.') {
					continue; // Ignore hidden files
				}
				$count += 1;
			}
		}

		return $count;
	}

	public function new_folder(){
		$new_folder = request('new_folder');
		$success = false;
		$error = '';


		if(file_exists($new_folder)){
			$error = 'Sorry that folder already exists, please delete that folder if you wish to re-create it';
		} else {
			if(mkdir($new_folder)){
				$success = true;
			} else{
				$error = 'Sorry something seems to have gone wrong with creating the directory, please check your permissions';
			}
		}

		return array('success' => $success, 'error' => $error);
	}


	public function delete_file_folder(){
		$file_folder = request('file_folder');
		$success = true;
		$error = '';

		if (is_dir($file_folder)) {
			if(!$this->rrmdir($file_folder)){
				$error = 'Sorry something seems to have gone wrong when deleting this folder, please check your permissions';
				$success = false;
			}
		} else {
			if(!unlink($file_folder)){
				$error = 'Sorry something seems to have gone wrong deleting this file, please check your permissions';
				$success = false;
			}
		}

		return array('success' => $success, 'error' => $error);
	}


	/********** recursively delete directory **********/
	private function rrmdir($dir) {
	   $deleted = true;
	   if (is_dir($dir)) {
	     $objects = scandir($dir);
	     foreach ($objects as $object) {
	       if ($object != "." && $object != "..") {
	         if (is_dir($dir."/".$object))
	           $this->rrmdir($dir."/".$object);
	         else
	           unlink($dir."/".$object);
	       }
	     }
	     if(!rmdir($dir)){
	     	$deleted = false;
	     }
	   }
	   return $deleted;
	 }


	 public function get_all_dirs(){
	 	$base_dir = './content/uploads';
	 	$directories = $this->expandDirectories($base_dir);
	 	return response()->json($directories);
	 }

	 public function expandDirectories($base_dir) {

	      $directories = array();
	      foreach(scandir($base_dir) as $file) {
	            if($file == '.' || $file == '..') continue;
	            $dir = $base_dir.DIRECTORY_SEPARATOR.$file;
	            if(is_dir($dir)) {
	                $directories []= str_replace('./content/uploads/', '', $dir);
	                $directories = array_merge($directories, $this->expandDirectories($dir));
	            }
	      }
	      return $directories;
	}

	public function move_file(){
		$source = request('source');
		$destination = request('destination');
		$success = false;
		$error = '';


		if(!file_exists($destination)){
			if(rename($source, $destination)){
				$success = true;
			} else {
				$error = 'Sorry there seems to be a problem moving that file/folder, please make sure you have the correct permissions.';
			}
		} else {
			$error = 'Sorry there is already a file/folder with that existing name in that folder.';
		}

		return array('success' => $success, 'error' => $error);
	}

	public function upload(){
		try {

			if(request()->has('file')){
				$upload_path = request('upload_path');
				$file = Request::file('file');
				$extension = $file->getClientOriginalExtension();
				$name = str_replace('.' . $extension, '-' . time() . '.' . $extension, $file->getClientOriginalName());

				$file->move($upload_path, $name);
				$success = true;
				$message = 'Successfully uploaded ' . $file->getClientOriginalName();
			} else {
				$success = false;
				$message = 'poop';
			}
		} catch(Exception $e){
			$success = false;
			$message = $e->getMessage();
		}

		return response()->json(array('success' => $success, 'message' => $message));
	}

    public function manage()
	{


		$users = User::with('countribute')->where('contribute' , 'contribute');
		if(request()->has('s')){
			$search = request('s');

			if(!empty($search)){
				$users->where('username' , $search);
			}
		}

		$temp = $users;
		$users = $users->get();

		$defaults = DB::select('explain contributer_tb');

		$defaults = (object)[
			'premium_video' => $defaults[1]->Default,
			'subscribe_video' => $defaults[2]->Default
		];

		$new = false;

		foreach ($users as 	$user) {
			if(is_null($user->countribute)){
				$new = true;
				Countribute::create([
					'user_id' => $user->id,
					'premium_video' => $defaults->premium_video,
					'subscribe_video' => $defaults->subscribe_video,
					'def' => 1
				]);
			}
		}

		$users = ($new) ? $temp->get() : $users;

	  return view('admin.manage.index' , compact('users' , 'defaults'));
	}

	public function create()
	{
	return view('admin.manage.create');
	}

	// public function add_revenue()
	// {
	// $premium=$_POST['premium_video'];
	// $subscribe=$_POST['subscribe_video'];
	// $users = DB::select("insert into contributer_tb(premium_video,subscribe_video)value('$premium','$subscribe')");
	// return redirect('admin/manage/manage')->with(array('note' => 'Contributor Revenue Successfully Added!', 'note_type' => 'success') );
	// }
	public function edit()
	{
		$id = request('id');

		$user = null;
		$defaults = null;

		if($id == 0){

			$defaults = DB::select('explain contributer_tb');

			$defaults = (object)[
				'premium_video' => $defaults[1]->Default,
				'subscribe_video' => $defaults[2]->Default
			];

		}else{
			$user = User::with('countribute')->where('id' , $id)->first();
		}


	return view('admin.manage.edit' , compact('user' , 'defaults'));
	}

	public function delete_revenue()
	{

		$note = 'Contributor Revenue Successfully Deleted!';

		$defaults = DB::select('explain contributer_tb');

		$defaults = (object)[
			'premium_video' => $defaults[1]->Default,
			'subscribe_video' => $defaults[2]->Default
		];

		Countribute::where('user_id' , request('id'))
		           ->update([
								 'def' => 1,
								 'premium_video' => $defaults->premium_video,
								 'subscribe_video'=> $defaults->subscribe_video
							 ]);

		return redirect('admin/manage/manage')->with(array('note' => $note, 'note_type' => 'success') );

	}
	public function edit_revenue()
	{

	 $premium_video = request('premium_video');
	 $subscribe_video = request('subscribe_video');
	 $id = request('user_id');

	 if($id == 0){
		 DB::select("alter table contributer_tb alter column premium_video set default '$premium_video'");
		 DB::select("alter table contributer_tb alter column subscribe_video set default '$subscribe_video'");

		 Countribute::where('def' , 1)->update(compact('premium_video' , 'subscribe_video'));

		 $note = 'Defaults Has Been Changed';
	 }else{
		 $def = 0;
		 Countribute::where('user_id' , $id)->update(compact('premium_video' , 'subscribe_video' , 'def'));
		 $note = 'Contributor Revenue Successfully Updated!';
	 }

	return redirect('admin/manage/manage')->with(array('note' => $note, 'note_type' => 'success') );
	}

	public function index1()
	{

	return view('admin.payment.index');
	}
	
	public function checkRevenue()
	{
	//phpinfo();
		/*$data = array();
		$all_plans = SubscriptionPlan::all()->toArray();
		
		$i=0;
		foreach($all_plans as $plan){
			$data[$i]['plan'] = $plan['title'];
			$data[$i]['amount'] = $plan['amount'];
			$i++;
		}*/
		$user_id = Auth::user()->id;
		
		$videoview = new VideoView();
		//subscribed video view data
		$get_user_video_month_view = $videoview->getUserMonthVideoViewSuscriber($user_id);
		$get_all_video_month_view = $videoview->getAllVideoMonthViewSuscriber();
		//premium video view data
		$get_user_video_month_view = $videoview->getUserMonthVideoViewPremium($user_id);
		$get_all_video_month_view = $videoview->getAllVideoMonthViewPremium();
		
		$month_wise_total_revenue = [];
		
		for($i=1; $i <= 12; $i++){
		    $month = date("F", strtotime(date("Y")."-".$i."-01"));
		    //echo"<pre>";
		    //print_r($month);die;
		    //premium video revenue monthly
		    $get_month_premium_video_revenue = $videoview->getMonthRevenueByViewPremiumVideo($month);
		    //subscribed video revenue monthly
		    $get_month_subscribed_video_revenue = $videoview->getMonthRevenueByViewsubscriberVideo($month);
		    $mondata = ['month' => $get_month_premium_video_revenue + $get_month_subscribed_video_revenue];
		    $month_wise_total_revenue[] = $mondata;
		}
		
		$month_chart_data = json_encode($month_wise_total_revenue);
		
		$month_wise_premium_revenue = [];
		for($i=1; $i <= 12; $i++){
		    $month = date("F", strtotime(date("Y")."-".$i."-01"));
		    //premium video revenue monthly
		    $get_month_premium_video_revenue = $videoview->getMonthRevenueByViewPremiumVideo($month);
		    
		    $predata = ['month' => $get_month_premium_video_revenue];
		    $month_wise_premium_revenue[] = $predata;
		}
		
		$month_premium_chart_data = json_encode($month_wise_premium_revenue);
		
		$month_wise_subscribed_revenue = [];
		for($i=1; $i <= 12; $i++){
		    $month = date("F", strtotime(date("Y")."-".$i."-01"));
		    //subscribed video revenue monthly
		     $get_month_subscribed_video_revenue = $videoview->getMonthRevenueByViewsubscriberVideo($month);
		    
		    $subsdata = ['month' => $get_month_subscribed_video_revenue];
		    $month_wise_subscribed_revenue[] = $subsdata;
		}
		$month_subs_chart_data = json_encode($month_wise_subscribed_revenue);
		
			// year total revenue
		$year_total_revenue = 0;
		for($i=1; $i <= 12; $i++){
		    $month = date("F", strtotime(date("Y")."-".$i."-01"));
		    //premium video revenue monthly
		    $get_month_premium_video_revenue = $videoview->getMonthRevenueByViewPremiumVideo($month);
		    
		    //subscribed video revenue monthly
		    $get_month_subscribed_video_revenue = $videoview->getMonthRevenueByViewsubscriberVideo($month);
		    
		    $year_total_revenue =  $year_total_revenue+$get_month_premium_video_revenue + $get_month_subscribed_video_revenue;
		   
		}
		
		$ydata = ['year' => $year_total_revenue];
		    $year_wise_revenue[] = $ydata;
		$year_chart_data = json_encode($year_wise_revenue);
		
		
		
		/*$user = new User();
		$get_current_month_subscribed_user = $user->getCurrentMonthSubscribedUser(date('Y-m-d'));
		$get_current_year_subscribed_user = $user->getCurrentYearSubscribedUser();
		
		$total_revenue = round($get_current_month_subscribed_user + ($get_current_year_subscribed_user*10/12), 2);
		
		$user_played_video_percentage = '';
		
		if($get_user_video_month_view == 0){
		    $user_played_video_percentage = 0;
		}else{
		    $user_played_video_percentage = $get_user_video_month_view/$get_all_video_month_view;
		}
		
		$gross_revenue = '';
		if($get_user_video_month_view == 0){
		    $gross_revenue = 0;
		}else{
		    $gross_revenue = $total_revenue*$user_played_video_percentage;
		}
		
		$user_revenu = '';
		if($get_user_video_month_view == 0){
		    $user_revenu = 0;
		}else{
		    $user_revenu = $gross_revenue*(40/100);
		}
		//echo"<pre>";
		//print_r($user_revenu);die('user revenue');
		
		$aflix_revenue = '';
		if($user_revenu == 0){
		    $aflix_revenue = $gross_revenue;
		}else{
		    $aflix_revenue = $gross_revenue-$user_revenu;
		}*/
		
		return view('admin.contributor.check_revenue', compact('month_chart_data', 'month_premium_chart_data', 'month_subs_chart_data', 'year_chart_data'));
	}

	public function contributorpay()
	{
	    return view('admin.payment.contributorpay');
	}
	
	public function managecontributorpayment(Request $request)
	{
		$current_month = date('m');
		$results = '';
		$month = '';
		$payout = new ContributorPayout();
		if ($request->isMethod('get')) {
            $month = $request->input('month');
			if($month != ''){
				if($month < $current_month){
					$results   = $payout->getcontributorPayoutData($month);
					if(count($results) <= 0){
						$calculate = $payout->calculateContributorMonthRevenue($month);
						if($calculate == 'success'){
							$results   = $payout->getcontributorPayoutData($month);
						}
					}
				}else{
					$month = $current_month - 1;
					$results   = $payout->getcontributorPayoutData($month);
					if(count($results) <= 0){
						$calculate = $payout->calculateContributorMonthRevenue($month);
						if($calculate == 'success'){
							$results   = $payout->getcontributorPayoutData($month);
						}
					}
				}
			}else{
				$month = $current_month - 1;
				$results   = $payout->getcontributorPayoutData($month);
				if(count($results) <= 0){
					$calculate = $payout->calculateContributorMonthRevenue($month);
					if($calculate == 'success'){
						$results   = $payout->getcontributorPayoutData($month);
					}
				}
			}
        }

		$contribute_id = Auth::user()->id;
		$user_contributor = Auth::user()->contribute ;

		if($user_contributor == 'contribute') {
			$re_results = clone $results;
			foreach($re_results as $re) {
				if($re->user_id == $contribute_id) {
					$results = array();
					$results[0] = $re;
					break;
				}
			}
		}

	    return view('admin.contributor.contributormonthpay', compact('results', 'month'));
	}
	
	public function makecontributorpayment(Request $request)
	{
		$data = $request->all();
		$month = $data['month'];
		$id  = $data['id'];
		$datapayment = ContributorPayout::where('month', $month)->whereIn('id', $id)->get();
		echo"<pre>";
		print_r($datapayment);die;
		
	}
	
	public function updatecontributorpayment(Request $request)
	{
		$data = $request->all();
		$payout = new ContributorPayout();
		$updatepayout = $payout->updateUserPayout($data);
		if($updatepayout){
			return 'success';
		}else{
			return 'error';
		}
	}
	
	public function updatecontributorpaymentstatus(Request $request)
	{
		$data = $request->all();
		
		$payout = new ContributorPayout();
		$updatepayout = $payout->updateUserPaymentStatus($data);
		if($updatepayout){
			return 'success';
		}else{
			return 'error';
		}
	}

	public function index2()
	{
		return view('admin.coupon.index2');
	}
	public function create_coupon()
	{
	$premium=$_POST['name'];
	$subscribe=$_POST['value'];
	$users = DB::select("insert into coupon_code(name,value)value('$premium','$subscribe')");
	return redirect('admin/coupon')->with(array('note' => 'Coupon Code Successfully Added!', 'note_type' => 'success') );
	}

	public function edit_coupon()
	{
	$id=$_POST['id'];
	$premium=$_POST['name'];
	$subscribe=$_POST['value'];
	$users = DB::select("update coupon_code set name='$premium',value='$subscribe' where id='$id'");
	return redirect('admin/coupon')->with(array('note' => 'Coupon Code Successfully Updated!', 'note_type' => 'success') );
	}
}
