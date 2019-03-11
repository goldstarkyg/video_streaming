<?php




namespace HelloVideo\Models;


use Illuminate\Database\Eloquent\Model;

class VideoTag extends Model {

	protected $table = 'tag_video';
	protected $guarded = array();

	public static $rules = array();

}
