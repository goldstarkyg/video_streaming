<?php




namespace HelloVideo\Models;


use DB;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
	protected $guarded = array();

	protected $table = 'menu';

	public static $rules = array();

	public function hasChildren(){
		if(DB::table('menu')->where('parent_id', '=', $this->id)->count() >= 1){
			return true;
		} else {
			return false;
		}
	}

}
