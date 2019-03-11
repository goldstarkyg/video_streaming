<?php

namespace HelloVideo\Models;
use HelloVideo\Models\Video;
use HelloVideo\User;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class ContributorPayout extends Model {

	
	protected $table = 'contributor_month_payout';
	protected $guarded = array();
    public $hexcode;

	public static $rules = array();

	protected $fillable = array('user_id', 'total_views', 'subscribe_view', 'premimum_view', 'month', 'year', 'earned_amount', 'final_amount', 'paid_amount', 'payment_status', 'site_revenue_from_user', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by');
	
	public function calculateContributorMonthRevenue($month = null){
         $nmonth = date("F", strtotime(date("Y")."-".$month."-01"));
         $m_t_sub_view = DB::table('views')
              ->select(DB::raw(DB::raw('COALESCE(sum(views), 0) AS `totalview`')))
              ->where('video_type', 'subscriber')
              ->where('view_date', $nmonth)->get();
         $month_total_sub_view = $m_t_sub_view[0]->totalview;
         $user = new User();
         $last_day_this_month  = date('Y-'.$month.'-t');
       
         $month_subscribe_user = $user->getCurrentMonthSubscribedUser($last_day_this_month);
         $year_subscribe_user  = $user->getCurrentYearSubscribedUser($last_day_this_month);
         
         $users = User::where('contribute', 'contribute')->get();
         foreach($users as $user){
             $video_id = Video::where([['access', 'subscriber'],['user_id', $user->id]])->pluck('id')->toArray();
             $s_v_view = DB::table('views')
                             ->select(DB::raw(DB::raw('COALESCE(sum(views), 0) AS `totalsubview`')))
                             ->where('view_date', $month)
                             ->whereIn('video_id',$video_id)->get();; 
             $month_subs_view = $s_v_view[0]->totalsubview;
             
             $user_month_sub_video_revenue = '';
             $site_month_sub_video_revenue = '';
             if($month_subs_view == 0){
                $user_month_sub_video_revenue = 0;
				$site_month_sub_video_revenue = 0;
             }else{
                $avg_view           = $month_subs_view/$month_total_sub_view;
                $total_revenue      = $month_subscribe_user + 0.83 * $year_subscribe_user;
                $user_gross_revenue = $total_revenue * $avg_view;
                $user_month_sub_video_revenue = $user_gross_revenue * 40/100;
				$site_month_sub_video_revenue = $user_gross_revenue - $user_month_sub_video_revenue;
             
             }
             
             $total_premium_video_revenue = $this->getMonthPremiumVideoRevenue($user->id, $month);
             //echo"<pre>";
             //print_r($total_premium_video_revenue);die;
             $user_premium_video_revenue = $total_premium_video_revenue *70/100;
             $site_month_premium_revenue = $total_premium_video_revenue - $user_premium_video_revenue;
			 
			 $site_month_total_revenue = $site_month_premium_revenue + $site_month_sub_video_revenue;
             $createdata = array(
                                 'user_id' => $user->id,
                                 'total_views' => $month_total_sub_view,
                                 'subscribe_view' =>  $month_subs_view,
                                 'premimum_view' => 0,
                                 'month' => $month,
                                 'year' => date('Y'),
                                 'earned_amount' => $user_premium_video_revenue + $user_month_sub_video_revenue,
                                 'final_amount' => $user_premium_video_revenue + $user_month_sub_video_revenue,
                                 'paid_amount' => 0,
                                 'payment_status' => 6,
								 'site_revenue_from_user' => $site_month_total_revenue,
                                 'status' => 1,
                                 'created_at' => date("Y-m-d H:i:s"),
                                 'updated_at' => date("Y-m-d H:i:s"),
                                 'created_by' => Auth::user()->id,
                                 'updated_by' => Auth::user()->id
                                );
            ContributorPayout::create($createdata);                    
        }
		return 'success';
    }
    
    public function getMonthPremiumVideoRevenue($userid = null, $month = null){
         $videos = Video::where([['access', 'premium'], ['user_id', $userid]])->get();
         $pre_revenue = 0;
         $nmonth = date("F", strtotime(date("Y")."-".$month."-01"));
         foreach($videos as $video){
             $data = DB::table('views')
                     ->select(DB::raw('sum(views) AS `totalpreview`'))
                     ->where('view_date', $nmonth)
                     ->where('year', date('Y'))
                     ->where('video_id',$video->id)->get();
              $view = $data[0]->totalpreview;
              if($view != 0){
                  $pre_revenue = $pre_revenue + $view * $video->price;
              }       
         }
        
         return $pre_revenue;
    }
	
	public function getcontributorPayoutData($month = null){  
        //$nmonth = date("F", strtotime(date("Y")."-".$month."-01"));
		$videos = ContributorPayout::where('month', $month)->get(); 
		return $videos;
	}	 
	
	public function updateUserPayout($data = null){
		$id  = $data['id'];
		$contributorpayout = ContributorPayout::find($id);
		$contributorpayout->final_amount = $data['updated_paid_amount'];
		return $contributorpayout->save();
	}
	
	public function updateUserPaymentStatus($data = null){
		$id  = $data['id'];
		$contributorpayout = ContributorPayout::find($id);
		$contributorpayout->payment_status = $data['status'];
		return $contributorpayout->save();
	}
	
	public function getVideoViews($id, $type){
		$id  = $data['id'];
		$contributorpayout = ContributorPayout::find($id);
		$contributorpayout->payment_status = $data['status'];
		return $contributorpayout->save();
	}
    
}
