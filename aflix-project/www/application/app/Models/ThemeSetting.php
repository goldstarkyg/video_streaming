<?php




namespace HelloVideo\Models;


use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model {
	protected $guarded = array();

	public static $rules = array();

	protected $fillable = array('theme_slug', 'key', 'value');
}
