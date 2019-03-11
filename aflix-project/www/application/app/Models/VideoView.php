<?php

namespace HelloVideo\Models;
use GuzzleHttp\Psr7\Request;
use HelloVideo\Models\Video;
use HelloVideo\User;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class VideoView extends Model {

	
	protected $table = 'views';
	protected $guarded = array();
    public $hexcode;

	public static $rules = array();

	protected $fillable = array('user_id', 'video_id', 'video_type', 'user_email', 'views', 'view_date', 'year');
	
	public function checkvideolastmonth($videoid = null, $month = null){
         return VideoView::where([['video_id', $videoid],['month', $month]])->first();
    }
    
    public function checkvideocurrentmonth($videoid = null, $month = null){
         return VideoView::where([['video_id', $videoid],['month', $month]])->first();
    }
    
    public function getallvideoviewsum($videoid = null){
    
         $data = DB::table('video_monthly_views')
              ->select(DB::raw('sum(month_view) AS `totalview`'))
              ->where('video_id',$videoid)->get();
         return  $data;
    }
    
	/*public function createviewrecord($data = null){
         return VideoView::create($data);
    }
    
    public function updateviewrecord($data = null, $id = null){
         $videoview = VideoView::find($id);
         $videoview->month_view = $data;
         $videoview->save();
    }
    
    public function updatevideotabledate($id = null, $date = null){
         $video = Video::find($id);
         $video->video_view_updated_date = $date;
         $video->save();
    }*/
    
    public function getUserMonthVideoViewSuscriber($userid = null, $month = null){
         $nmonth = date("m", strtotime($month));
         $video_id = Video::where([['user_id', $userid],['access', 'subscriber']])->pluck('id')->toArray();
         $data = DB::table('video_monthly_views')
              ->select(DB::raw('sum(month_view) AS `totalview`'))
              ->where('month', $nmonth)
              ->where('year', date('Y'))
              ->whereIn('video_id',$video_id)->get();
         return  $data[0]->totalview;
    }
    
    public function getAllVideoMonthViewSuscriber(){
         $video_id = Video::where('access', 'subscriber')->pluck('id')->toArray();
         $data = DB::table('video_monthly_views')
              ->select(DB::raw('sum(month_view) AS `totalview`'))
              ->where('month', date('m'))
              ->where('year', date('Y'))
              ->whereIn('video_id',$video_id)->get();
         return  $data[0]->totalview;
    }
    
     public function getUserMonthVideoViewPremium($userid = null){
         $video_id = Video::where([['user_id', $userid],['access', 'premium']])->pluck('id')->toArray();
         $data = DB::table('video_monthly_views')
              ->select(DB::raw('sum(month_view) AS `totalview`'))
              ->where('month', date('m'))
              ->where('year', date('Y'))
              ->whereIn('video_id',$video_id)->get();
         return  $data[0]->totalview;
    }
    
    public function getAllVideoMonthViewPremium(){
         $video_id = Video::where('access', 'premium')->pluck('id')->toArray();
         $data = DB::table('video_monthly_views')
              ->select(DB::raw('sum(month_view) AS `totalview`'))
              ->where('month', date('m'))
              ->where('year', date('Y'))
              ->whereIn('video_id',$video_id)->get();
         return  $data[0]->totalview;
    }
    
    public function getMonthRevenueByViewPremiumVideo($month){
         $videos = Video::where('access', 'premium')->get();
         $premum_video_month_revene = 0;
         foreach($videos as $video){
              
             $result = VideoView::where('video_id', $video->id)->Where('view_date', 'like', '%' . $month . '%')->first();
             if(count($result) > 0){
                 if($result->month_view > 0){
                     $premum_video_month_revene = $premum_video_month_revene + ($result->month_view*$video->price);
                 }
             }
         }
         
         $user_revenu = $premum_video_month_revene*(70/100);
         return $user_revenu;
         //return $premum_video_month_revene;
    }
    
    public function getMonthRevenueByViewsubscriberVideo($month){
         $user_id = Auth::user()->id;
         //$videos = Video::where('access', 'premium')->pluck('id')->toArray();
         $videos = Video::where('access', 'subscriber')->get();
         $subscribed_video_month_revene = 0;
         $video_views = 0;
         foreach($videos as $video){
             $result = VideoView::where('video_id', $video->id)->Where('view_date', 'like', '%' . $month . '%')->first();
             if(count($result) > 0){
                 if($result->month_view > 0){
                     //$premum_video_month_revene = $premum_video_month_revene + ($result->month_view*$video->price);
                     //$this->getMonthSuscriberVideoView($month ,$year);
                     $video_views = $video_views+$result->month_view;
                 }
             }
         }
         $user = new User();
		 $get_current_month_subscribed_user = $user->getCurrentMonthSubscribedUser($month);
		 $get_current_year_subscribed_user = $user->getCurrentYearSubscribedUser();
		 $total_revenue = round($get_current_month_subscribed_user + ($get_current_year_subscribed_user*10/12), 2);
		
		
		$get_user_video_month_view = $this->getUserMonthVideoViewSuscriber($user_id, $month);
		$get_all_video_month_view  = $this->getAllVideoMonthViewSuscriber(); 
         $user_played_video_percentage = 0;
        if($video_views == 0){
		    $user_played_video_percentage = 0;
		}else{
		    if(($get_user_video_month_view != 0 || $get_user_video_month_view !=  '') && ($get_all_video_month_view != 0 || $get_all_video_month_view != '')){
		        $user_played_video_percentage = $get_user_video_month_view/$get_all_video_month_view;
		    }
		}
		
		$gross_revenue = '';
		if($get_user_video_month_view == 0 || $get_user_video_month_view == ''){
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
		
        return $user_revenu;
    }
    
     public function getMonthSuscriberVideoView($month = null, $year = null){
         $video_id = Video::where('access', 'subscriber')->pluck('id')->toArray();
         $data = DB::table('video_monthly_views')
              ->select(DB::raw('sum(month_view) AS `totalview`'))
              ->where('month', $month)
              ->where('year', date('Y'))
              ->whereIn('video_id',$video_id)->get();
         return  $data[0]->totalview;
    }
    
    //viewer ship dashboard functions
    
    public function monthwiseallpremiumvideoview($type = null){
        $video_id = Video::where('access', $type)->pluck('id')->toArray();
        $rdata = '[';
       for($i=1; $i <= 12; $i++){
            $month = date("F", strtotime(date("Y")."-".$i."-01"));
            $data = DB::table('views')
                  ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
                  ->where('view_date', 'like', '%' . $month . '%')
                  ->where('year', date('Y'))
                  ->whereIn('video_id',$video_id)->get();
                
            $rdata .= $data[0]->totalview;  
            if($i != 12){
                $rdata .= ','; 
            } 
         }  
         $rdata .= ']';   
         return  $rdata;
    }

    public function monthwiseallpremiumcontributorvideoview($type = null){
         $users = User::where('contribute', 'contribute')->get();
         $user_count = count($users);
         $finaldata = '';
         $j = 1;
         foreach($users as $user){
             $rdata = '{';
             $video_id = Video::where([['access', $type],['user_id', $user->id]])->pluck('id')->toArray();
             $arrdata = '[';
             for($i=1; $i <= 12; $i++){
                $month = date("F", strtotime(date("Y")."-".$i."-01"));
                $data = DB::table('views')
                       ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
                      ->where('view_date', 'like', '%' . $month . '%')
                      ->where('year', date('Y'))
                      ->whereIn('video_id',$video_id)->get();
                $arrdata .= $data[0]->totalview;  
                if($i != 12){
                    $arrdata .= ','; 
                }       
             } 
             $colorcode = $this->createrandomColorCode();
             $arrdata .= ']';  
             $rdata .= 'data:'. $arrdata.',';
             $rdata .= 'label:'. "'$user->username'".',';
             $rdata .= 'borderColor:' ."' $colorcode'".',';
             $rdata .= 'fill: false';
             $rdata .= '}';
             $finaldata .= $rdata;
             if($user_count > $j){
                 $finaldata .= ',';
             }
             $j++;        
             
         }
        return  $finaldata;
    }
    
    public function monthwiseallsubscribedvideoview($type = null){
        $video_id = Video::where('access', $type)->pluck('id')->toArray();
        $rdata = '[';
       for($i=1; $i <= 12; $i++){
            $month = date("F", strtotime(date("Y")."-".$i."-01"));
            $data = DB::table('views')
                  ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
                  ->where('view_date', 'like', '%' . $month . '%')
                  ->where('year', date('Y'))
                  ->whereIn('video_id',$video_id)->get();
                
            $rdata .= $data[0]->totalview;  
            if($i != 12){
                $rdata .= ','; 
            }  
         }  
         $rdata .= ']';   
         return  $rdata;
    }

    public function monthwiseallsubscribedcontributorvideoview(){
         $users = User::where('contribute', 'contribute')->get();
         $user_count = count($users);
         $finaldata = '';
         $j = 1;
         foreach($users as $user){
             $rdata = '{';
             $video_id = Video::where([['access', 'subscriber'],['user_id', $user->id]])->pluck('id')->toArray();
             $arrdata = '[';
             for($i=1; $i <= 12; $i++){
                $month = date("F", strtotime(date("Y")."-".$i."-01"));
                $data = DB::table('views')
                       ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
                      ->where('view_date', 'like', '%' . $month . '%')
                      ->where('year', date('Y'))
                      ->whereIn('video_id',$video_id)->get();
                $arrdata .= $data[0]->totalview;  
                if($i != 12){
                    $arrdata .= ','; 
                }       
             } 
             $colorcode = $this->createrandomColorCode();
             $arrdata .= ']';  
             $rdata .= 'data:'. $arrdata.',';
             $rdata .= 'label:'. "'$user->username'".',';
             $rdata .= 'borderColor:' ."'$colorcode'".',';
             $rdata .= 'fill: false';
             $rdata .= '}';
             $finaldata .= $rdata;
             if($user_count > $j){
                 $finaldata .= ',';
             }
             $j++; 
         }
        return  $finaldata;
    }
    
    
    public function createrandomColorCode(){
       
		$chars = 'ABCDEF0123456789';
		$color = '#';
		for ( $i = 0; $i < 6; $i++ ) {
			$color .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $color;
    }
 
	public function getVideoViews($id, $month, $type , $cond){
		$nmonth = date("F", strtotime(date("Y")."-".$month."-01"));
		if($type == 'Total'){
			$data = DB::table('views')
              ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
			  ->where('view_date', $nmonth)
              ->where('video_id', $id)->get();
            return  $data[0]->totalview;
		}elseif($type == 'MonthSub'){
			$user = new User();
            $input = request()->all();
            if(!empty($input['month']))
                $date = date("Y")."-".$input['month']."-"."01";
            else
                $date = date("Y")."-".date('m')."-"."01";
//			$userarray = $user->getCurrentMonthSubscribedUserList(date('Y-m-t', strtotime($month))); // subscriber
            $userarray = $user->getCurrentMonthSubscribedUserList($date); //subscriber
            if($cond == 'registered') $userarray = $user->getFreeRegisteredUserList();
			$data = DB::table('views')
              ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
			  ->where('view_date', $nmonth)
              ->where('video_id', $id)
              ->where('video_type', $cond)
			  ->whereIn('user_id', $userarray)
			  ->get();
            if($cond == 'premium' || $cond == 'guest')  {
                //all non playing like admin , contributor
//              $userarray = $user->getCurrentMonthPremiumUserList($date);
                $data = DB::table('views')
                    ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
                    ->where('view_date', $nmonth)
                    ->where('video_id', $id)
                    ->where('video_type', $cond)
                    ->get();
            }
            return  $data[0]->totalview;
			
		}else{
			$user = new User();
			$userarray = $user->getCurrentYearSubscribedUserList();
            if($cond == 'registered') $userarray = $user->getFreeRegisteredUserList();
			$data = DB::table('views')
              ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
			  ->where('year', date('Y'))
              ->where('video_id', $id)
              ->where('video_type', $cond)
			  ->whereIn('user_id', $userarray)
			  ->get();
            return  $data[0]->totalview;
		}
		
	}
	
	public function getVideosubsRevenue($id, $month, $count_types){
		$nmonth = date("F", strtotime(date("Y")."-".$month."-01"));
		if($count_types == 'MonthSub'){
			$user = new User();
			$userarray = $user->getCurrentMonthSubscribedUserList(date('Y-m-t', strtotime($month)));
            $video_total_view = 0;
            for($i = 0 ; $i < count($userarray) ; $i ++) {
                $first_user = $userarray[$i];
                $data = DB::table('views')
                    ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
                    ->where('view_date', $nmonth)
                    ->where('video_id', $id)
                    ->where('video_type', 'subscriber')
                    //->whereIn('user_id', $userarray)
                    ->where('user_id', $first_user)
                    ->get();
                //$video_total_view = $data[0]->totalview;
                if($data[0]->totalview > 0 ) $video_total_view++;
            }
			$revenue = 0;
			if($video_total_view > 0){
				$totalview     = $this->getmonthTotalSubscribedVideoView($nmonth);
                if($totalview > 0) {
                    $total_revenue = count($userarray);
                    //$contributorvideoplay = $totalview/$video_total_view;
                    $contributorvideoplay = $video_total_view / $totalview;
                    $gross_revenue = $total_revenue * $contributorvideoplay;
                    $revenue = $gross_revenue * 40 / 100;
                }
			}
            return  $revenue;
			
		}else{
			$user = new User();
			$userarray = $user->getCurrentYearSubscribedUserList();
            $video_total_view = 0;
            for($i = 0 ; $i < count($userarray) ; $i ++) {
                $first_user = $userarray[$i];
                $data = DB::table('views')
                    ->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
                    ->where('year', date('Y'))
                    ->where('video_id', $id)
                    ->where('video_type', 'subscriber')
                    //->whereIn('user_id', $userarray)
                    ->where('user_id', $first_user)
                    ->get();
                //$video_total_view = $data[0]->totalview;
                if($data[0]->totalview > 0 ) $video_total_view++;
            }
			$revenue = 0;
			if($video_total_view > 0){
				$totalview     = $this->getmonthTotalSubscribedVideoView($nmonth);

                if($totalview > 0) {
                    $total_revenue = count($userarray) * 0.83;
                    //$contributorvideoplay = $totalview/$video_total_view;
                    $contributorvideoplay = $video_total_view / $totalview;
                    $gross_revenue = $total_revenue * $contributorvideoplay;
                    $revenue = $gross_revenue * 40 / 100;
                }
			}
            return  $revenue;
		}
	}
	
	public function getVideopremiumRevenue($videodata, $month, $count_types){
		$nmonth = date("F", strtotime(date("Y")."-".$month."-01"));
		$data = DB::table('views')
					->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
					->where('view_date', $nmonth)
					->where('video_id', $videodata->id)
					->where('video_type', 'premium')
                    ->where('user_id','!=' , '1') //except admin
					->get();
		$video_total_view = $data[0]->totalview;  
		$revenue = 0;
		if($video_total_view > 0){
			$gross_revenue = $video_total_view*$videodata->price;
			$revenue = $gross_revenue*70/100;
		}
		return  $revenue;
	}
	
	public function getmonthTotalSubscribedVideoView($month = null){
		$data = DB::table('views')
						->select(DB::raw('COALESCE(sum(views), 0) AS `totalview`'))
						->where('view_date', $month)
						->where('video_type', 'subscriber')
						->get();
	    return $data[0]->totalview; 
	}

}
