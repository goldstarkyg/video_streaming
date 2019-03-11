<?php




namespace HelloVideo\Models;

use HelloVideo\Models\Video;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	protected $guarded = array();

	public static $rules = array();

	public function videos(){
		return $this->belongsToMany(Video::class);
	}
}
