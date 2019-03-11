<?php

namespace HelloVideo\Http\Controllers;



use HelloVideo\Models\PaymentSetting;
use HelloVideo\Models\Setting;
use Auth;

class AdminPaymentSettingsController extends Controller {

	public function index()
	{

	 $payment = PaymentSetting::all();

	 $payment = (count($payment) == 0) ? null : $payment;

		$data = array(
			'admin_user' => Auth::user(),
			'settings' => Setting::first(),
			'payment_settings' => $payment,
			);

		return view('admin.paymentsettings.index',$data );
	}

	public function save_payment_settings(){

		$input = request()->except('_token');

		$insert = [];

		foreach ($input as $key => $payment) {

			if($key != 'live_mode'){
				$insert[0][$key] = $payment[0];
				$insert[1][$key] = $payment[1];
			}

			if($key == 'live_mode'){
				$insert[0][$key] = isset($payment[0]) ? $payment[0] : 0;
				$insert[1][$key] = isset($payment[1]) ? $payment[1] : 0;
			}

		}
		$payment_settings = PaymentSetting::all();


        if(count($payment_settings) == 0){
                    $insert[0]['created_at'] = date('Y-m-d H:i:s');
                    $insert[0]['updated_at'] = date('Y-m-d H:i:s');
                    $insert[1]['created_at'] = date('Y-m-d H:i:s');
                    $insert[1]['updated_at'] = date('Y-m-d H:i:s');
					PaymentSetting::insert($insert);
				}else{
					foreach ($payment_settings as $key => $setting) {
					    $insert[0]['updated_at'] = date('Y-m-d H:i:s');
					    $insert[1]['updated_at'] = date('Y-m-d H:i:s');
						$setting->update($insert[$key]);
					}
				}


        return redirect('admin/payment_settings')->with(array('note' => 'Successfully Updated Payment Settings!', 'note_type' => 'success') );

	}

}
