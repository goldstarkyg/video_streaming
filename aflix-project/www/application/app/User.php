<?php

namespace HelloVideo;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Cashier\Billable;
use HelloVideo\Models\PremiumVideo;


use Auth;
use DB;

class User extends Authenticatable implements CanResetPasswordContract{

  use CanResetPassword, Billable , Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	public static $rules = array('username' => 'required|unique:users|min:3',
						        'email' => 'required|email|unique:users',
						        'password' => 'required|confirmed|min:3'
						    );

	public static $update_rules = array('username' => 'unique:users|min:3',
						        'email' => 'email|unique:users'
						    );

    public function comments()
    {
        return $this->hasMany(\Laravelista\Comments\Comments\Comment::class);
    }
    public function countribute()
    {

      return $this->hasOne(Models\Countribute::class);
    }
    public function record($redirect = '')
    {
      $user = DB::select("select count(*) as logins from user_logins where user_id = $this->id")[0];

      if($user->logins == 5){
        return redirect('logoutall');
      }

      $session_id = str_random(20);

      session()->put('session_id' , $session_id);

      DB::table('user_logins')->insert([
        'session_id' => $session_id,
        'user_id'    => $this->id
      ]);
        return redirect($redirect)->with(array('note' => 'You have been successfully logged in.', 'note_type' => 'success'));
      }

      public function unRecord()
      {

        $session_id = session('session_id');

        DB::select("DELETE FROM user_logins where session_id = '$session_id' AND user_id = '$this->id' ");

        Auth::logout();

      }
      public function unRecordAll()
      {

        DB::select("DELETE FROM user_logins where user_id = '$this->id' ");

        Auth::logout();
      }
    public function getFreeRegisteredUser(){
        $data = DB::table('users')
              ->select(DB::raw('count(id) AS `monthuser`'))
              ->where('role', 'registered')->get();
        return $data[0]->monthuser;
    }
    public function getFreeRegisteredUserList(){
        $data = User::where('role', 'registered')
            ->orWhere('role', 'subscriber')
            ->pluck('id');
        return $data;
    }

    public function getCurrentMonthSubscribedUser($date = null){
        $data = DB::table('users')
              ->select(DB::raw('count(id) AS `monthuser`'))
              ->where('plan', 3)
              ->whereDate('end_plan', '>=', $date)->get();

        return $data[0]->monthuser;
    }
      
    public function getCurrentYearSubscribedUser(){
        $data = DB::table('users')
              ->select(DB::raw('count(id) AS `yearuser`'))
              ->where('plan', 1)
              ->whereDate('end_plan', '>', date('Y-m-d'))
              ->get();
              
        return $data[0]->yearuser;
    }
	
	 public function getCurrentMonthSubscribedUserList($date = null){
        $data = User::where('plan', 3)
               ->whereDate('end_plan', '>=', $date)
			   ->pluck('id');
        return $data;
    }

    public function getCurrentMonthPremiumUserList($date = null){
        $data =
        $data = PremiumVideo::where('premium_video', 'premium')
            ->whereDate('end_plan', '>=', $date)
            ->pluck('id');
        return $data;
    }
      
    public function getCurrentYearSubscribedUserList(){
        $data = User::where('plan', 1)
              ->whereDate('end_plan', '>', date('Y-m-d'))
              ->pluck('id');
			 // echo"<pre>";
//print_r($data);die;
        return $data;
    }


}
