<?php




namespace HelloVideo\Models;


use Illuminate\Database\Eloquent\Model;

class Theme extends Model {
	protected $guarded = array();

	public static $rules = array();

	public $timestamps = false;

	protected $fillable = array('name', 'description', 'version', 'slug', 'active');
}
