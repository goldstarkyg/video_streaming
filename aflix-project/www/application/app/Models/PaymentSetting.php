<?php




namespace HelloVideo\Models;


use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model {
	protected $guarded = array();

	public static $rules = array();

	public $timestamps = false;

	protected $fillable = array('live_mode', 'test_secret_key', 'test_publishable_key', 'live_secret_key', 'live_publishable_key', 'test_buisness_id', 'live_buisness_id', 'created_at', 'updated_at');
}
