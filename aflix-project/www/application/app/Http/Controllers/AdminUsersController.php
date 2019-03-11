<?php

namespace HelloVideo\Http\Controllers;



use HelloVideo\User;
use HelloVideo\Libraries\ImageHandler;
use Mail;
use Hash;
use Auth;
use Excel;
use DB;
use Carbon\Carbon as Carbon;

class AdminUsersController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */

    public function index()
    {
		//echo"<pre>";
		//print_r(request('role'));die;
        $search_value = request('s');
        $paid = request('paid') || 0;
        $role = request('role');

        if(!empty($search_value)){
            $users = User::where('username', 'LIKE', '%'.$search_value.'%')
                          ->orWhere('email', 'LIKE', '%'.$search_value.'%');
        }else{
            //$users = User::all();
			$users = User::orderBy('created_at', 'DESC');
        }


        if(request()->has('role') && $role != 'all'){
			if($role == 'corporate_admin'){
				$users->where('corporate_user', "Corporate_Admin");
			}else if($role == 'corporate'){
				$users->where('corporate_user', '!=' , "Corporate_Admin")
                 ->where('corporate_user', '!=' , "");
			}else if($role == 'contributor'){
				$users->where('contribute', "contribute");
			}else{
				$users->where('role', $role)
                 ->where('corporate_user' , "");
			}
        }

       if($paid){
         $users->where('stripe_active', 1);
       }

        if(request()->has('export')){
             $users = $users->select('user_id' , 'username' , 'email' , 'profession' , 'dob' , 'nohouse' , 'mobile' , 'role' , 'gender' , 'income' )->get();
             return $this->downloadResults($users);

        }

        $users = $users->paginate(10);

        $data = array(
            'users' => $users
        );

        return view('admin.users.index',$data );
    }

	public function index1()
	{

	 return view('admin.users.index1');
	}

   public function downloadResults($users)
   {
     Excel::create('users', function($excel) use ($users) {

          $excel->sheet('users', function($sheet) use ($users) {

              $sheet->fromArray($users->toArray());

          });

      })->download('xls');
   }
    public function create(){
        $data = array(
            'post_route' => url('admin/user/store'),
            'user' => Auth::user(),
            'button_text' => 'Create User',
        );
        return view('admin.users.create_edit',$data );

    }

    public function store(){
        $input = request()->all();
        $input['status']=1;
        if(request()->has('avatar')){
            $input['avatar'] = ImageHandler::uploadImage(request()->file('avatar'), 'avatars');
        } else{ $input['avatar'] = 'default.jpg'; }

        $input['password'] = Hash::make(request('password'));
        // Mail::send('emails.email',
        //     array('username' => request('username'), 'password' => request('password')),
        //     function($message) {
        //     $message->to(request('email'), request('username'))->subject('Welcome To aflix.amlin.com');
        // });
        unset($input['id']);
        $input['contribute_req'] = 0;
        $input['contribute_req_status'] = 0;
        $input['user_id'] = Auth::user()->id;

        if(isset($input['organization_name'])){
          $input['contribute'] = 'contribute';
        }else{
          $input['role'] = 'registered';
        }
		
        if($input['email'] != ''){
			$userexist = User::where('email', $input['email'])->first();
			if(count($userexist) > 0){
				return redirect('admin/user/create')->with(array('note' => 'User Already Exist With This Email', 'note_type' => 'error') );
			}else{
				$user = User::create($input);
				return redirect('admin/users')->with(array('note' => 'Successfully Created New User', 'note_type' => 'success') );
			}
		}
    }

	public function create1(){
        $data = array(
            'post_route' => url('admin/user/store1'),
            'admin_user' => Auth::user(),
            'button_text' => 'Create Corporate Admin',
        );
        return view('admin.users.create_edit1',$data );

    }

    public function store1(){

        $input = request()->all();
        $this->validate(request() , [
          'email'  => 'required|email'
        ]);


        $add_as_corp = !! request('add_as_corp');
        $user = User::where('email' , request('email'))->first();

        if($add_as_corp){

          $user->update([
             'corporate_user' => 'Corporate_Admin',
             'adm'            => 'admin',
             'role'           => 'admin'
          ]);

          return redirect('admin/users')->with(array('note' => 'Successfully Created New User', 'note_type' => 'success') );

        }else{
          if(count($user)){
            return redirect()->back()->with(array('userExsist' => $user) );
          }
        }


        $input['status']=1;
        if(request()->has('avatar')){
            $input['avatar'] = ImageHandler::uploadImage(request()->file('avatar'), 'avatars');
        } else{ $input['avatar'] = 'default.jpg'; }

        $input['password'] = Hash::make(request('password'));
        // Mail::send('emails.email',
        //     array('username' => request('username'), 'password' => request('password')),
        //     function($message) {
        //     $message->to(request('email'), request('username'))->subject('Welcome To aflix.tv');
        // });

        $input = $this->assignFirstLastName($input);
        $input['activation_code'] = 5454;
        $input['plan'] = '1';
        $input['plan_price'] = 50;
//        $input['start_plan'] = "0000-00-00"; //Carbon::now()
//        $input['end_plan'] = "0000-00-00"; //Carbon::now()
        $input['contribute'] = '';
        $input['contribute_req'] = 0;
        $input['contribute_req_status'] = 0;
        $input['corporate_user'] = "Corporate_Admin";
        $input['adm'] = 'admin';
        $input['role1'] = 1;
        $input['demo'] = 0;
        $input['mail_status'] = 0;
        $input['login_status'] = 0;
        $input['login_status2'] = 0;

        unset($input['_token']);

        $user = User::forceCreate($input);

        return redirect('admin/users')->with(array('note' => 'Successfully Created New User', 'note_type' => 'success') );
    }

    public function edit($id){

        $user = User::find($id);
        $data = array(
            'user' => $user,
            'post_route' => url('admin/user/update'),
            'admin_user' => Auth::user(),
            'button_text' => 'Update User',
        );
        return view('admin.users.create_edit',$data );
    }
    public function editstatus($id)
    {
        $user = User::find($id);
        $user->status=1;
        $user->save();
        return redirect('admin/users')->with(array('note' => 'User Active Successfully', 'note_type' => 'success') );

        //return view('myform.edit')->with('user', myform::find($id));

    }
    public function editstatus1($id)
    {
        $user = User::find($id);
        $user->status=0;
        $user->save();
        return redirect('admin/users')->with(array('note' => 'User Block Successfully', 'note_type' => 'success') );

        //return view('myform.edit')->with('user', myform::find($id));

    }

	public function editstatus2($id)
    {
        $user = User::find($id);
        $user->status=1;
        $user->save();
        return redirect('admin/users/index1')->with(array('note' => 'User Active Successfully', 'note_type' => 'success') );

        //return view('myform.edit')->with('user', myform::find($id));

    }
    public function editstatus3($id)
    {
        $user = User::find($id);
        $user->status=0;
        $user->save();
        return redirect('admin/users/index1')->with(array('note' => 'User Block Successfully', 'note_type' => 'success') );

        //return view('myform.edit')->with('user', myform::find($id));

    }

    public function update(){
        $input = request()->all();
        $id = $input['id'];
        $user = User::find($id);

        if(request()->has('avatar')){
            $input['avatar'] = ImageHandler::uploadImage(request()->file('avatar'), 'avatars');
        } else { $input['avatar'] = $user->avatar; }

        if(empty($input['active'])){
            $input['active'] = 0;
        }


        if($input['password'] == ''){
            $input['password'] = $user->password;
        } else{ $input['password'] = Hash::make($input['password']); }

        if($input['role'] == 'subscriber') {
            $input['stripe_subscription'] = '1' ; //update for Subscriber middlware
        }else {
            $input['stripe_subscription'] = '(NULL)' ; //update for Subscriber middlware
        }

        foreach ($input as $key => $in) {

          if(is_null($in)){
            unset($input[$key]);
          }
        }

        $user->update($input);
        return redirect('admin/user/edit/' . $id)->with(array('note' => 'Successfully Updated User Settings', 'note_type' => 'success') );
    }

    public function destroy($id)
    {

        User::destroy($id);

        return redirect('admin/users')->with(array('note' => 'Successfully Deleted User', 'note_type' => 'success') );
    }
   public function contributor_req()
	{

    $by = request('s');
    $users = User::where('contribute_req' , 1);

    if($by){
      $users->where('username' , 'like' , "%$by%")
            ->orWhere('email' , 'like' , "%$by%");
    }

    $users = $users->get();

    $data = array(
        'post_route' => url('admin/user/store'),
        'user' => Auth::user(),
        'button_text' => 'Create User',
        'users' => $users
    );


	return view('admin.users.contribute_req' , $data);

	}

	 public function edit1($id){

        $user = User::find($id);
        $data = array(
            'user' => $user,
            'post_route' => url('admin/user/update1'),
            'admin_user' => Auth::user(),
            'button_text' => 'Update Corporate User',
        );
        return view('admin.users.create_edit1',$data );
    }
	public function update1(){
        $input = request()->all();
        $id = $input['id'];
        $user = User::find($id);

        if(request()->has('avatar')){
            $input['avatar'] = ImageHandler::uploadImage(request()->file('avatar'), 'avatars');
        } else { $input['avatar'] = $user->avatar; }

        if(empty($input['active'])){
            $input['active'] = 0;
        }

        if($input['password'] == ''){
            $input['password'] = $user->password;
        } else{ $input['password'] = Hash::make($input['password']); }

        $user->update($input);
        return redirect('admin/user/edit1/' . $id)->with(array('note' => 'Successfully Updated User Settings', 'note_type' => 'success') );
    }

	public function create2(){
        $data = array(
            'post_route' => url('admin/user/store2'),
            'admin_user' => Auth::user(),
            'button_text' => 'Create Corporate User',
        );
        return view('admin.users.create_edit2',$data );

    }

    public function store2(){
        $input = request()->all();
        $input['status']=1;
        if(request()->has('avatar')){
            $input['avatar'] = ImageHandler::uploadImage(request()->file('avatar'), 'avatars');
        } else{ $input['avatar'] = 'default.jpg'; }

        $input['password'] = Hash::make(request('password'));

//        Mail::send('emails.email',
//            array('username' => request('username'), 'password' => request('password')),
//            function($message) {
//            $message->to(request('email'), request('username'))->subject('Welcome To aflix.tv');
//        });


        $input['user_id'] = Auth::user()->id;
        $input['organization_name'] = Auth::user()->organization_name;

        $user = User::create($input);



        return redirect('admin/users/index1')->with(array('note' => 'Successfully Created New User', 'note_type' => 'success') );
   }
	public function edit2($id){

        $user = User::find($id);
        $data = array(
            'user' => $user,
            'post_route' => url('admin/user/update2'),
            'admin_user' => Auth::user(),
            'button_text' => 'Update Corporate User',
        );
        return view('admin.users.create_edit2',$data );
    }
	public function update2(){
        $input = request()->all();
        $id = $input['id'];
        $user = User::find($id);

        if(request()->has('avatar')){
            $input['avatar'] = ImageHandler::uploadImage(request()->file('avatar'), 'avatars');
        } else { $input['avatar'] = $user->avatar; }

        if(empty($input['active'])){
            $input['active'] = 0;
        }

        if($input['password'] == ''){
            $input['password'] = $user->password;
        } else{ $input['password'] = Hash::make($input['password']); }

        $user->update($input);
        return redirect('admin/user/edit2/' . $id)->with(array('note' => 'Successfully Updated User Settings', 'note_type' => 'success') );
    }

	 public function corporate_user()
	 {
        return view('admin.users.corporate_user');
    }

	public function upload()
{
//return view('Theme::upload');
return view('admin.users.upload');
}

public function add_file()
{
/*
$user_id=$_POST['user_id'];
$file = request()->file('data');
$handle = fopen($file, "r");
$c = 0;
while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
{
$FullName = $filesop[0];
$email = $filesop[1];
$password = $filesop[2];
$password1 = Hash::make($password);
$dob = $filesop[3];
$profession = $filesop[4];
$income = $filesop[5];
$mobile = $filesop[6];
$nohouse = $filesop[7];

$user = DB::select("insert into users(user_id,username,email,password,dob,profession,income,mobile,nohouse,status,corporate_user,demo)
value('$user_id','$FullName','$email','$password1','$dob','$profession','$income','$mobile','$nohouse','1','Corporate_User','$password')");

$c = $c + 1;
 /*Mail::send('emails.email',
            array('username' => $FullName, 'password' => $password),
            function($message) use ($email,$FullName) {
            $message->to($email,$FullName)->subject('Welcome To aflix.tv');
        });
}*/



 	if (request()->hasFile('data')){

        $file = request()->file('data');

        $name = time() . '-' . $file->getClientOriginalName();

        //check out the edit content on bottom of my answer for details on $storage

         $path = public_path();

        // Moves file to folder on server
        $file->move($path, $name);

		$csvFile=$path.'/'.$name;

     $this->csvToArray($csvFile);

		return redirect('admin/user/upload')->with(array('note' => 'Successfully Import CSV File', 'note_type' => 'success') );
     }

  return redirect('admin/user/upload')->with(array('note' => 'Something went wrong', 'note_type' => 'success') );
 }


public function csvToArray($filename = '', $delimiter = ',')
{

  if(file_exists($filename) || is_readable($filename)){


     $all = [];

     Excel::filter('chunk')->load($filename)->chunk(250, function($results) use (&$all)
    {

            $results = $results
                        ->map(function($user){
                          $user['created_at'] = Carbon::now();
                          $user['updated_at'] = Carbon::now();
                          $user['dob'] = date('Y-m-d',strtotime($user['dob']));
                          $user['income'] = $this->getUserIncome($user['income']);
                          $user['password'] = \Hash::make($user['password']);
                          $user = $this->assignFirstLastName($user);
                          $user['role'] = (isset($user['role'])) ? $user['role'] : "registered";
                          //have to set default values for those into mysql
                          $user['activation_code'] = 5454;
                          $user['status'] = 1;
                          $user['gender'] = 'male';
                          $user['plan'] = '1';
                          $user['plan_price'] = 50;
                          $user['start_plan'] = (isset($user['start_plan'])) ? $user['start_plan'] : "1000-01-01";
                          $user['end_plan'] = (isset($user['end_plan'])) ? $user['end_plan'] : "2060-01-01";
                          $user['contribute'] = '';
                          $user['contribute_req'] = 0;
                          $user['contribute_req_status'] = 0;
                          $user['corporate_user'] = "0";
                          $user['adm'] = '';
                          $user['role1'] = 1;
                          $user['demo'] = 0;
                          $user['mail_status'] = "";
                          $user['login_status'] = 0;
                          $user['login_status2'] = 0;

                          $user['user_id'] = Auth::user()->id;

                          unset($user['0']);

                          return $user;
                        })->unique('email')
                        ->unique('mobile')->toArray();

                        $all = array_merge($all , $results);

                  foreach ($all as $user) {
                    $exsist = User::where('email' , $user['email'])->count();

                    if(! $exsist){
                      User::create($user);
                    }
                  }


    });



  }


}

 public function getUserIncome($income)
{

  if($income<=1000)
    $income="Below $1000";

  if($income>1000 && $income<=3000)
    $income="$1001-$3000";

  if($income>3000 && $income<=5000)
    $income="$3001-$5000";

  if($income>3000)
    $income="$5000 and above";

    return $income;
}

public function assignFirstLastName($user)
{
  $name= explode(' ',$user['username']);

  $user['firstname'] = array_shift($name);
  $user['lastname'] = implode(' ' , $name);

  return $user;
}

 public function check_user($user){
	 	$user = User::where('username', '=', $user)->first();
		if(count($user)>0) return 1;
		else return 0;
	}

 public function user_actions()
{
	    $count = 0;
	    $count = count($_POST['check'])-1;

      if(request('action') == 'send_mail'){
        for($i = 0; $i <= $count; $i++){
        $user_email=$_POST['user_email'][$i];
        $user_pwd=$_POST['user_pwd'][$i];
        $username=$_POST['username'][$i];

        $this->sendMail($user_email , $user_pwd , $username);
        }

        $note = 'Mail Sent Successfully';

      }else if(request('action') == 'delete'){

        $emails = array_slice(request('user_email') , 0 , count(request('check')));
         User::whereIn('email' , request('user_email'))->delete();

         $note = 'User Deleted Successfully';
      }

		return redirect('admin/users/index1')->with(array('note' => $note, 'note_type' => 'success') );

}

public function sendMail($user_email , $user_pwd , $username)
{

  Mail::send('emails.email',
          array('username' => $username, 'password' => $user_pwd),
          function($message) use ($user_email,$username) {
          $message->to($user_email,$username)->subject('Welcome To aflix.tv');
      });
  $update_mailstatus=DB::select("update users set mail_status=1 where email='$user_email'");
}

}
