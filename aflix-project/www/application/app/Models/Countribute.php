<?php
namespace HelloVideo\Models;


use Illuminate\Database\Eloquent\Model;

class Countribute extends Model {

	protected $table = 'contributer_tb';
	protected $guarded = array();


  public function user()
  {

    return $this->belongsTo(User::class , 'user_id');
  }
}
