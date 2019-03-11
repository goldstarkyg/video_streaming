<?php




namespace HelloVideo\Models;


/*class Page extends Model {
	protected $guarded = array();


	public static $rules = array();

	protected $table = 'pages';

	protected $fillable = array('user_id', 'title', 'slug', 'image', 'body', 'active', 'created_at');

}*/

use Illuminate\Database\Eloquent\Model;

class Page extends Model {
	protected $guarded = array();


	public static $rules = array();

	protected $table = 'subscribe_plane';

	protected $fillable = array('id', 'title', 'amount', 'validity', 'active', 'created_at', 'updated_at');

}
