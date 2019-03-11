<?php




namespace HelloVideo\Models;


use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	protected $guarded = array();


	public static $rules = array();

	protected $table = 'subscribe_plane';

	protected $fillable = array('id','title','amount','validity','active');

	/*public function category(){
		return $this->belongsTo('PostCategory', 'post_category_id');
	}*/
}
/*class Subscribe extends Model {
	protected $guarded = array();

	public static $rules = array();

	protected $table = 'subscribe_plane';

	protected $fillable = array('id','title','amount','valid','creat_date');

	/*public function category(){
		return $this->belongsTo('PostCategory', 'post_category_id');
	}


	class Post extends Model {
	protected $guarded = array();


	public static $rules = array();

	protected $table = 'posts';

	protected $fillable = array('post_category_id', 'user_id', 'title', 'slug', 'image', 'body', 'body_guest', 'access', 'active', 'created_at');

	public function category(){
		return $this->belongsTo('PostCategory', 'post_category_id');
	}
}
}*/
