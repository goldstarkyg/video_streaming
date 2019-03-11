<?php

namespace HelloVideo\Http\Controllers;
use HelloVideo\User;
use HelloVideo\Models\Video;
use HelloVideo\Models\VideoView;
use HelloVideo\Libraries\WistiaApi;
use DB; 

class UpdateVideoViewController extends Controller {

	public function __construct()
	{
		//$this->middleware('secure');
	}

	public function updateVideoViewsWistia()
	{

		
		$users = User::where('status' , 1)->get();
		
		foreach ($users as 	$user) {
		
		    //$videos = Video::where([['user_id' , $user->id],['video_view_updated_date', '<', date('Y-m-d')]])->get();
		     $videos = Video::where('user_id' , $user->id)
		                        ->where('video_view_updated_date', '<', date('Y-m-d'))
		                        ->orWhere('video_view_updated_date', '')
		                        ->get();
		    foreach ($videos as $video) {
		        $videohash = $video->embed_code;
		        $wishObj = new WistiaApi('71fbe2cac59753ae4eafb365da83c03586f6691e599b8c4c5ed70b7360db9fda');
		       
		        $params = array('start_date' => '2017-10-25', 'end_date' => '2017-11-01');
		        
		         $stats = $wishObj->mediaShowStats(trim($videohash), $params);
		         if($stats != '' && !isset($stats->error)){
		         
		         $videoplays = $stats->stats->plays;
		         
		         $user_updated = $user->updated_at;
                 $date = date('Y-m', strtotime($user_updated));
                 $update_date = strtotime($date);
                 $today       = strtotime(date('Y-m'));
                 
                 $videoview = new VideoView();
                
                 if($update_date < $today){
                     $get_lastrecord_exist = $videoview->checkvideolastmonth($video->id, date("m",strtotime("-1 month")));
                     if(count($get_lastrecord_exist) > 0){
                        
                        $get_crrentrecord_exist = $videoview->checkvideocurrentmonth($video->id, date("m"));
                         $get_allvideoviewrecord = $videoview->getallvideoviewsum($video->id); 
                        $thismonthvideoplay = '';
                        if(count($get_crrentrecord_exist) == 0){
                             $thismonthvideoplay     = $videoplays-$get_allvideoviewrecord[0]->totalview;
                             $savedata = array(
                                       'video_id'   => $video->id,
                                       'month'      => date("m"),
                                       'year'       => date("Y"),
                                       'month_view' => $thismonthvideoplay,
                                       'status'     => 1
                     
                                   );
                             $videoview->createviewrecord($savedata);
                             $videoview->updatevideotabledate($video->id, date('Y-m-d'));
                        }else{
                            $current_monthview_stored = $get_crrentrecord_exist->month_view;
                            $thismonthvideoplay     = $videoplays-($get_allvideoviewrecord[0]->totalview-$current_monthview_stored);
                                  
                             $videoview->updateviewrecord($thismonthvideoplay, $get_crrentrecord_exist->id);
                             $videoview->updatevideotabledate($video->id, date('Y-m-d'));
                        }
                             
                     }else{
                        $savedata = array(
                                       'video_id'   => $video->id,
                                       'month'      => date('m') != 1 ? date("m",strtotime("-1 month")) : 12,
                                       'year'       => date('m') != 1 ? date("Y") : date("Y",strtotime("-1 year")),
                                       'month_view' => $videoplays,
                                       'status'     => 1
                     
                                   );
                     
                         $videoview->createviewrecord($savedata);
                         $videoview->updatevideotabledate($video->id, date('Y-m-d',strtotime("-1 day")));
                     }
                 }else{
                    $savedata = array(
                                       'video_id'   => $video->id,
                                       'month'      => date('m'),
                                       'year'       => date("Y"),
                                       'month_view' => $videoplays,
                                       'status'     => 1
                     
                                   );
                     
                    $videoview->createviewrecord($savedata);
                    $videoview->updatevideotabledate($video->id, date('Y-m-d'));
                 }
                 
                 }
		    }
		   
		}
		
		//echo"All Data Updated successfully";die;
	}

}
