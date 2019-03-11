<?php

namespace HelloVideo\Models;
use Illuminate\Database\Eloquent\Model;
use HelloVideo\Models\VideoView;
use Laravelista\Comments\Comments\Traits\Comments;
use DB;

class Video extends Model {

	use Comments;
	protected $guarded = array();


	public static $rules = array();

	protected $fillable = array('user_id', 'video_category_id', 'title', 'type', 'access', 'details', 'description', 'active', 'featured', 'duration', 'image', 'ads' ,'ass','subtitle','ads_link', 'delbycontri','embed_code', 'mp4_url', 'webm_url', 'ogg_url', 'created_at','price','validate1','trailor_embed_code','live','type1','subtitle','bannerImg','video_type');

	public function tags(){
		return $this->belongsToMany(Tag::class);
	}

	public function ad()
	{
		return $this->hasOne(Ad::class ,'id', 'ads');
	}
	
	public function updatedWebsiteVideoView($videodata = null, $userdata = null)
	{
		DB::table('videos')->where('id', $videodata['id'])->increment('views');
		$time  = strtotime(date('Y-m-d'));
        $month = date("F",$time);
        $year  = date("Y",$time);
		$viewstabledata = array(
		                        'user_id' => $userdata->id,
								'video_id' => $videodata['id'],
								'video_type' => $videodata['access'],
								'user_email' => $userdata->email,
								'views'=> 1,
								'view_date' => $month,
								'year' => $year
		                       );
		DB::table('views')->insert($viewstabledata);
	}
	
	public function updatedWebsiteGuestVideoView($videodata = null)
	{
		DB::table('videos')->where('id', $videodata['id'])->increment('views');
	}
	
	public function getVideoViwershipData($month = null, $contributor = null)
	{
		
		$query = DB::table('videos')
		                             ->select('videos.id','videos.title','videos.access','video_categories.name as category','users.username')
		                             ->join('video_categories','video_categories.id','=','videos.video_category_id')
		                             ->join('users','users.id','=','videos.user_id')
									 ->where('videos.active', 1);
		if($contributor != ""){
			                         $query->where('videos.user_id', $contributor);
		}							 
									 
		$results =	$query->get();
		foreach($results as $result){
			$count_types = array(1 => 'MonthSub', 2 => 'YearSub', 3 => 'Total');
			foreach($count_types as $key => $value){
				$videoview = new VideoView();
				if($key == 1){
					$viewcount_subscriber = $videoview->getVideoViews($result->id, $month, $value,'subscriber');
					$viewcount_register = $videoview->getVideoViews($result->id, $month, $value,'registered');
					$viewcount_premium = $videoview->getVideoViews($result->id, $month, $value,'premium');
					$viewcount_guest = $videoview->getVideoViews($result->id, $month, $value,'guest');
					$result->monthsubscribeuserview = $viewcount_subscriber;
					$result->monthfreeregisteruserview = $viewcount_register;
					$result->monthpremiumuserview = $viewcount_premium;
					$result->monthguestuserview = $viewcount_guest;
				}elseif($key == 2){
					$viewcount_subscriber = $videoview->getVideoViews($result->id, $month, $value,'subscriber');
					$viewcount_register = $videoview->getVideoViews($result->id, $month, $value,'registered');
					$result->yearsubscribeuserview = $viewcount_subscriber;
					$result->yearfreeregisteruserview = $viewcount_register;
				}else{
					$viewcount = $videoview->getVideoViews($result->id, $month, $value,'');
					$result->totalview = $viewcount;
				}
			}
		}							 
		return $results;
	}
	
	public function getPerVideoRevenueData($month = null, $contributor = null)
	{
		
		$query = DB::table('videos')
					 ->select('videos.id','videos.price','videos.title','videos.access','video_categories.name as category','users.username')
					 ->join('video_categories','video_categories.id','=','videos.video_category_id')
					 ->join('users','users.id','=','videos.user_id')
					 //->where('videos.access', 'subscriber')
					 ->where('videos.active', 1);
		if($contributor != ""){
			         $query->where('videos.user_id', $contributor);
		}

		$results =	$query->get();
		foreach($results as $result){
			$count_types = array(1 => 'MonthSub', 2 => 'YearSub', 3 => 'Total');
			foreach($count_types as $key => $value){
				$videoview = new VideoView();
				if($result->access == 'subscriber'){
					$viewcount = $videoview->getVideosubsRevenue($result->id, $month, $value);					
					if($key == 1){
						$result->monthsubscriberevenue = $viewcount;
					}elseif($key == 2){
						$result->yearsubscriberevenue = $viewcount;
					}else{
						$result->totalrevenue = $result->monthsubscriberevenue + $result->yearsubscriberevenue;
					}
				}elseif($result->access == 'premium'){
					$viewcount = $videoview->getVideopremiumRevenue($result, $month, $value);
					$result->monthsubscriberevenue = $viewcount;
					$result->yearsubscriberevenue = 0;
					$result->totalrevenue = $viewcount;
				}else{
					$result->monthsubscriberevenue = 0;
					$result->yearsubscriberevenue = 0;
					$result->totalrevenue = 0;
				}
			}
		}	
       // echo"<pre>";
//print_r($results);die;		
		return $results;
	}
}
