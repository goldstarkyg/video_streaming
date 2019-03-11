<?php

namespace HelloVideo\Http\Controllers;


use HelloVideo\User;
use HelloVideo\Models\Setting;
use HelloVideo\Models\Video;
use HelloVideo\Models\Post;
use HelloVideo\Models\VideoView;
use Illuminate\Http\Request;
use HelloVideo\Models\ContributorPayout;
use Auth;
use Carbon\Carbon as Carbon;

class AdminController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	public function index()
	{

		//die('success');
		$start = (new Carbon('now'))->hour(0)->minute(0)->second(0);
		$end = (new Carbon('now'))->hour(23)->minute(59)->second(59);

		$total_subscribers = count(User::where('active', '=', 1)->where('role', '=', 'subscriber')->where('stripe_active', '=', 1)->get());
		$new_subscribers = count(User::where('active', '=', 1)->where('role', '=', 'subscriber')->where('stripe_active', '=', 1)->whereBetween('created_at', [$start, $end])->get());
		$total_videos = count(Video::where('active', '=', 1)->get());
		$total_posts = count(Post::where('active', '=', 1)->get());

		$today_registered = User::where('role' , 'registered')
		                        ->whereDay('created_at', '=', date('d'))
														->whereMonth('created_at', '=', date('m'))
                            ->whereYear('created_at', '=', date('Y'))
														->count();

		$today_subscriberd = User::where('role' , 'subscriber')
		                        ->whereDay('created_at', '=', date('d'))
														->whereMonth('created_at', '=', date('m'))
                            ->whereYear('created_at', '=', date('Y'))
														->count();
		$user = new User();
		$free_registered_users = $user->getFreeRegisteredUser();
		$date = date('Y-m-t');
		$monthly_paid_subscribed_users = $user->getCurrentMonthSubscribedUser($date);
		$yearly_paid_subscribed_users = $user->getCurrentYearSubscribedUser();

		$settings = Setting::first();


		$data = array(
			'admin_user' => Auth::user(),
			'total_subscribers' => $total_subscribers,
			'new_subscribers' => $new_subscribers,
			'total_videos' => $total_videos,
			'total_posts' => $total_posts,
			'settings' => $settings,
			'today_registered' => $today_registered,
			'today_subscriberd' =>$today_subscriberd,
			'free_registered_users' =>$free_registered_users,
			'monthly_paid_subscribed_users' =>$monthly_paid_subscribed_users,
			'yearly_paid_subscribed_users' =>$yearly_paid_subscribed_users
			);
		return view('admin.index',$data );
	}


	public function settings_form(){
		$settings = Setting::first();
		$user = Auth::user();
		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			);
		return view('admin.settings.index', $data );
	}
	
	public function viwershipDashboard(Request $request)
	{
		$user_contributor = Auth::user()->contribute ;
		$user = new User();
		$videoview = new VideoView();
		$date       = '';
		$contributor = '';
		$month = '';
		if ($request->isMethod('get')) {
			$admin_request = $request->all();
			//echo"<pre>";
			//print_r($admin_request);die;
			if(count($admin_request) > 0){
				if($admin_request['month'] != ''){
					$month = $admin_request['month'];
					$date = date('Y-m-t', strtotime($admin_request['month']));
				}
				if($admin_request['contributor'] != ''){
					$contributor = $admin_request['contributor'];
				}
			}else{
				$date = date('Y-m-t');
			}
		}
		if($month == ''){
			$month = date('m');
		}
		
		//overalldata
		$free_registered_users = $user->getFreeRegisteredUser();
		$monthly_paid_subscribed_users = $user->getCurrentMonthSubscribedUser($date);
		$yearly_paid_subscribed_users = $user->getCurrentYearSubscribedUser();

		//echo"<pre>";
		//print_r($yearly_paid_subscribed_users);die;
       /* $videoview = new VideoView();
        
        // premium video data for viewr dashboard
        $premium = '[';
        
		    $month_wise_all_premium_video_view = $videoview->monthwiseallpremiumvideoview('premium');
		     $premium .= '{';
		     $premium .= 'data:'. $month_wise_all_premium_video_view.',';
             $premium .= 'label:'. '"All Premium video play"'.',';
             $premium .= 'borderColor:'.'"#3e95cd"'.',';
             $premium .= 'fill: false';
             $premium .= '},';
		    
		   $month_wise_all_premium_video_view_contributor = $videoview->monthwiseallpremiumcontributorvideoview('premium');
		   $premium .= $month_wise_all_premium_video_view_contributor;
        
         $premium .= ']';
         
       
		    // subscribed video data for viewr dashboard
            $subscribed = '[';
		    
		    $month_wise_all_subscribed_video_view = $videoview->monthwiseallsubscribedvideoview('subscriber');
		     $subscribed .= '{';
		     $subscribed .= 'data:'. $month_wise_all_subscribed_video_view.',';
             $subscribed .= 'label:'. '"All Subscribed video play"'.',';
             $subscribed .= 'borderColor:'.'"#3e95cd"'.',';
             $subscribed .= 'fill: false';
             $subscribed .= '},';
		    $month_wise_subscribed_video_view_contributor = $videoview->monthwiseallsubscribedcontributorvideoview('subscriber');
		    $subscribed .= $month_wise_subscribed_video_view_contributor;
		     
		 $subscribed .= ']';*/
		 
		//$month = date("m", strtotime($date)); 
		$video = new Video();
		if($user_contributor == 'contribute') $contributor = Auth::user()->id;
//		$results   = $video->getVideoViwershipData(date("m", strtotime($date)), $contributor);
		$input = $request->all();
		if(!empty($input['month']))
			$results   = $video->getVideoViwershipData($input['month'], $contributor);
		else
			$results   = $video->getVideoViwershipData(date('m'), $contributor);
		$total = 0;
		$total_subscribview = 0;
		$total_registerview = 0;
		$total_premiumview = 0;
		$total_guest = 0;
		foreach($results as $result){
		   	$subscribview = $result->monthsubscribeuserview;
			$total_subscribview += $subscribview;
			$registerview = $result->monthfreeregisteruserview;
			$total_registerview += $registerview;
			$premiumview = $result->monthpremiumuserview;
			$total_premiumview += $premiumview;
			$guestview = $result->monthguestuserview;
			$total_guest += $guestview;
		}
		$total = $total_subscribview + $total_registerview + $total_premiumview + $total_guest;
		//echo"<pre>";
		//print_r($month);die;
		 //$payout = new ContributorPayout();
		
		//$results   = $payout->getcontributorPayoutData(10);
		return view('admin.dashboard.viwership',
			compact('month', 'contributor', 'results', 'free_registered_users', 'monthly_paid_subscribed_users', 'yearly_paid_subscribed_users','total','total_subscribview','total_registerview','total_premiumview','total_guest'));
	}
	
	public function trackRevenue(Request $request)
	{
		$user_contributor = Auth::user()->contribute ;
		$user = new User();
		$videoview = new VideoView();
		$date       = '';
		$contributor = '';
		$month = '';
		if ($request->isMethod('get')) {
			$admin_request = $request->all();
			if(count($admin_request) > 0){
				if($admin_request['month'] != ''){
					$month = $admin_request['month'];
					//$date = date('Y-m-t', strtotime($admin_request['month']));
					$date = $month;
				}
				if($admin_request['contributor'] != ''){
					$contributor = $admin_request['contributor'];
				}
			}else{
				$date = date('Y-m-t');
			}
		}
		if($month == ''){
			$month = date('m');
			$date = $month;
		}
		
		//overalldata
		$free_registered_users = $user->getFreeRegisteredUser();
		$monthly_paid_subscribed_users = $user->getCurrentMonthSubscribedUser($date);
		$yearly_paid_subscribed_users = $user->getCurrentYearSubscribedUser();
		
		$video = new Video();
		if($user_contributor == 'contribute') $contributor = Auth::user()->id;
		$results   = $video->getPerVideoRevenueData($date, $contributor);

		return view('admin.dashboard.trackrevenue', compact('month', 'contributor', 'results', 'free_registered_users', 'monthly_paid_subscribed_users', 'yearly_paid_subscribed_users'));
	}


}
