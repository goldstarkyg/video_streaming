<?php 
    @$message   = @$_POST['message']; 
   @$user   = @$_POST['user']; 
	@$video  = @$_POST['video']; 
	@$query=DB::select("insert into live_chat(user_id,message,video_id)values('".$user."','".$message."','".$video."')");
	
	
	?>