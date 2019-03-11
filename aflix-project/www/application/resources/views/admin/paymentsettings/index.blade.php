@extends('admin.master')

@section('css')
	<style type="text/css">
	.has-switch .switch-on label {
			background-color: #FFF;
			color: #000;
			}
	.make-switch{
		z-index:2;
	}
	</style>
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->

	<div class="admin-section-title">
		<h3><i class="entypo-credit-card"></i> Payment Settings</h3>
	</div>
	<div class="clear"></div>



	<form method="POST" action="{{ URL::to('admin/payment_settings') }}" accept-charset="UTF-8" enctype="multipart/form-data">

		<div class="row">

			<div class="col-md-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title">Live Mode Or Test Mode</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;">
						<p>Payment Settings are in Live Mode:</p>

						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" @if(!isset($payment_settings[0]->live_mode) || (isset($payment_settings[0]->live_mode) && $payment_settings[0]->live_mode))checked="checked" value="1"@else value="0"@endif name="live_mode[0]" id="live_mode" />
				            </div>
						</div>

					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title">Stripe Payment API Keys (<a href="https://stripe.com/docs/tutorials/dashboard" target="_blank">https://stripe.com/docs/tutorials/dashboard</a>)</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;">
						<p>Test Secret Key:</p>
						<input type="text" class="form-control" name="test_secret_key[0]" id="test_secret_key" placeholder="Test Secret Key" value="@if(!empty($payment_settings[0]->test_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings[0]->test_secret_key }}@endif" />

						<br />
						<p>Test Publishable Key:</p>
						<input type="text" class="form-control" name="test_publishable_key[0]" id="test_publishable_key" placeholder="Test Publishable Key" value="@if(!empty($payment_settings[0]->test_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings[0]->test_publishable_key }}@endif" />

						<br />
						<p>Live Secret Key:</p>
						<input type="text" class="form-control" name="live_secret_key[0]" id="live_secret_key" placeholder="Live Secret Key" value="@if(!empty($payment_settings[0]->live_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings[0]->live_secret_key }}@endif" />

						<br />
						<p>Live Publishable Key:</p>
						<input type="text" class="form-control" name="live_publishable_key[0]" id="live_publishable_key" placeholder="Live Publishable Key" value="@if(!empty($payment_settings[0]->live_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings[0]->live_publishable_key }}@endif" />
						<br />
						<p>Test Buisness Id:</p>
						<input type="text" class="form-control" name="test_buisness_id[0]" id="test_buisness_id" placeholder="Test Buisness ID" value="@if(!empty($payment_settings[0]->test_buisness_id) && Auth::user()->role != 'demo'){{ $payment_settings[0]->test_buisness_id }}@endif" />
						<br />
						<p>Live Buisness Id:</p>
						<input type="text" class="form-control" name="live_buisness_id[0]" id="live_buisness_id" placeholder="Live Buisness ID" value="@if(!empty($payment_settings[0]->live_buisness_id) && Auth::user()->role != 'demo'){{ $payment_settings[0]->live_buisness_id }}@endif" />
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title">Live Mode Or Test Mode</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;">
						<p>Payment Settings are in Live Mode:</p>

						<div class="form-group">
									<div class="make-switch" data-on="success" data-off="warning">
												<input type="checkbox" @if(!isset($payment_settings[1]->live_mode) || (isset($payment_settings[1]->live_mode) && $payment_settings[1]->live_mode))checked="checked" value="1"@else value="0"@endif name="live_mode[1]" id="live_mode" />
										</div>
						</div>

					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title">Paypal Payment API Keys </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;">
						<p>Test Secret Key:</p>
						<input type="text" class="form-control" name="test_secret_key[1]" id="test_secret_key" placeholder="Test Secret Key" value="@if(!empty($payment_settings[1]->test_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings[1]->test_secret_key }}@endif" />

						<br />
						<p>Test Publishable Key:</p>
						<input type="text" class="form-control" name="test_publishable_key[1]" id="test_publishable_key" placeholder="Test Publishable Key" value="@if(!empty($payment_settings[1]->test_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings[1]->test_publishable_key }}@endif" />

						<br />
						<p>Live Secret Key:</p>
						<input type="text" class="form-control" name="live_secret_key[1]" id="live_secret_key" placeholder="Live Secret Key" value="@if(!empty($payment_settings[1]->live_secret_key) && Auth::user()->role != 'demo'){{ $payment_settings[1]->live_secret_key }}@endif" />

						<br />
						<p>Live Publishable Key:</p>
						<input type="text" class="form-control" name="live_publishable_key[1]" id="live_publishable_key" placeholder="Live Publishable Key" value="@if(!empty($payment_settings[1]->live_publishable_key) && Auth::user()->role != 'demo'){{ $payment_settings[1]->live_publishable_key }}@endif" />
						<br />
						<p>Test Buisness Id:</p>
						<input type="text" class="form-control" name="test_buisness_id[1]" id="test_buisness_id" placeholder="Test Buisness ID" value="@if(!empty($payment_settings[1]->test_buisness_id) && Auth::user()->role != 'demo'){{ $payment_settings[1]->test_buisness_id }}@endif" />
						<br />
						<p>Live Buisness Id:</p>
						<input type="text" class="form-control" name="live_buisness_id[1]" id="live_buisness_id" placeholder="Live Buisness ID" value="@if(!empty($payment_settings[1]->live_buisness_id) && Auth::user()->role != 'demo'){{ $payment_settings[1]->live_buisness_id }}@endif" />
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="submit" value="Update Payment Settings" class="btn btn-success pull-right" />

	</form>

	<div class="clear"></div>

</div><!-- admin-container -->

@section('javascript')
	<script src="{{ '/application/assets/admin/js/bootstrap-switch.min.js' }}"></script>
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				if($(this).is(":checked")) {
			    	$(this).val(1);
			    } else {
			    	$(this).val(0);
			    }
			});

		});

	</script>

@stop

@stop
