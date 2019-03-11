<!DOCTYPE html>
<html lang="en">
<head>

    <?php $settings = HelloVideo\Models\Setting::first(); ?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Video Admin Panel" />
	<meta name="author" content="" />

	<title><?php echo e($settings->website_name . ' - ' . $settings->website_description); ?></title>

	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/font-icons/entypo/css/entypo.css'); ?>">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/font-icons/font-awesome/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/bootstrap.css'); ?>">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/animate.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/core.css'); ?>">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/theme.css'); ?>">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/forms.css'); ?>">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/custom.css'); ?>">
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/dataTables.min.css'); ?>">

    <?php $favicon = (isset($settings->favicon) && trim($settings->favicon) != "") ? $settings->favicon : '/favicon.png'; ?>
	<link rel="icon" href="<?= Config::get('site.uploads_dir') . '/settings/' . $favicon ?>" type="image/x-icon">
	<link rel="shortcut icon" href="<?= Config::get('site.uploads_dir') . '/settings/' . $favicon ?>" type="image/x-icon">

	<?php echo $__env->yieldContent('css'); ?>

	<script src="<?php echo e('/application/assets/admin/js/jquery-1.11.0.min.js'); ?>"></script>
	<script src="<?php echo e('/application/assets/admin/js/bootstrap-colorpicker.min.js'); ?>" id="script-resource-13"></script>
	<script src="<?php echo e('/application/assets/admin/js/vue.min.js'); ?>"></script>
	<script src="<?php echo e('/application/assets/admin/js/dataTables.min.js'); ?>"></script>

	<script>$.noConflict();</script>

	<!--[if lt IE 9]><script src="<?php echo e('/application/assets/admin/js/ie8-responsive-file-warning.js'); ?>"></script><![endif]-->

	<!-- HTML5 shim and Respond.js') }} IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js') }}/1.4.2/respond.min.js') }}"></script>
	<![endif]-->


</head>

<body class="page-body skin-black">

<a href="<?php echo e(URL::to('/')); ?>" class="top-left-logo">
	<img src="<?php echo e('/application/assets/admin/images/hv-tv.png'); ?>" />
</a>

<div class="page-container sidebar-collapsed"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

	<div class="sidebar-menu page-right-in">

		<div class="sidebar-menu-inner">

			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
					<a href="<?php echo e(URL::to('/')); ?>">

					</a>
				</div>

				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>


				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>

			</header>


			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				
		        <li>
		             <a href="<?php echo e(URL::to('admin')); ?>">
				          <i class="entypo-gauge"></i>
				          <span class="title">Analytics</span>
			         </a>
		            <ul>
		                <li>
			                <a href="<?php echo e(URL::to('admin')); ?>">
				                <span class="title">Dashboard</span>
			                </a>
			             </li>
						 <?php /*@$p=Auth::user()->username;
						if($p=='admin')
						{*/
						?>
			             <li>
			                <a href="<?php echo e(URL::to('admin/viewershipdashboard')); ?>">
				                <span class="title">Viewership Dashboard</span>
			                </a>
			             </li>
						<?php //} ?>
			        </ul>
		        </li>
		        <!--<li>
			        <a href="<?php echo e(URL::to('admin/viewershipdashboard')); ?>">
				        <i class="entypo-gauge"></i>
				        <span class="title">Viewership Dashboard</span>
			        </a>
		        </li>-->
				           
				
				<?php @$p=Auth::user()->username;
						if($p=='admin')
						{
						?>
				<li class="">
					<a href="<?php echo e(URL::to('admin/videos')); ?>">
						<i class="entypo-video"></i>
						<span class="title">Videos</span>
					</a>
					<ul>

						<li>
							<a href="<?php echo e(URL::to('admin/videos')); ?>">
								<span class="title">All Videos</span>
							</a>
						</li>

						<!--<li>
							<a href="<?php echo e(URL::to('admin/videos/index1')); ?>">
								<span class="title">All Videos</span>
							</a>
						</li>-->

						<li>
							<a href="<?php echo e(URL::to('admin/videos/create')); ?>">
								<span class="title">Add New Video</span>
							</a>
						</li>

						<!--<li>
							<a href="<?php echo e(URL::to('admin/videos/create1')); ?>">
								<span class="title">Add New Video</span>
							</a>
						</li>-->

						<li>
							<a href="<?php echo e(URL::to('admin/videos/categories')); ?>">
								<span class="title">Video Categories</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/videos/index3')); ?>">
								<span class="title">Add Ads</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/users/index4')); ?>">
								<span class="title">Assign Video List</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/videos/index6')); ?>">
								<span class="title">Manage Home Page Thumbnails</span>
							</a>
						</li>

					</ul>
				</li>
				<?php
				}
				else if(Auth::user()->corporate_user == "Corporate_Admin") {
				?>
				<li class="">
					<a href="<?php echo e(URL::to('admin/videos')); ?>">
						<i class="entypo-video"></i>
						<span class="title">Videos</span>
					</a>
					<ul>
						<li>
							<a href="<?php echo e(URL::to('admin/videos/index5')); ?>">
								<span class="title">My Corporate Videos</span>
							</a>
						</li>
					</ul>
				</li>
				<?php
				}else{
				?>
				<li class="">
					<a href="<?php echo e(URL::to('admin/videos')); ?>">
						<i class="entypo-video"></i>
						<span class="title">Videos</span>
					</a>
					<ul>
						<li>
							<a href="<?php echo e(URL::to('admin/videos')); ?>">
								<span class="title">All Videos</span>
							</a>
						</li>
						<li>
						  <a href="<?php echo e(URL::to('admin/videos/create')); ?>">
							<span class="title">Add New Video</span>
						  </a>
						</li>
						
							
								
							
						
					</ul>
				</li>
				<?php
				}
				?>
			<!--<li class="">
					<a href="<?php echo e(URL::to('admin/pages')); ?>">
						<i class="entypo-book-open"></i>
						<span class="title">Add Content</span>
					</a>
					<ul>
						<li>
							<a href="<?php echo e(URL::to('admin/content/create1')); ?>">
								<span class="title">Add About</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/pages/create')); ?>">
								<span class="title">Add Policy</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/posts')); ?>">
								<span class="title">All Posts</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/posts/create')); ?>">
								<span class="title">Add New Post</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/posts/categories')); ?>">
								<span class="title">Post Categories</span>
							</a>
						</li>
					</ul>
				</li>-->
				<?php @$p=Auth::user()->username;
						if($p=='admin')
						{
						?>
				<li class="">
					<a href="<?php echo e(URL::to('admin/pages')); ?>">
						<i class="entypo-book-open"></i>
						<span class="title">Subscription Plan</span>
					</a>
					<ul>
						<li>
							<a href="<?php echo e(URL::to('admin/Subscribe')); ?>">
								<span class="title">All Subscription Plan</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/Subscribe/create')); ?>">
								<span class="title">Add New Subscription Plan</span>
							</a>
						</li>

					</ul>
				</li>
				<!--
				<li class="" style="height: 51px;">
					<a href="<?php echo e(URL::to('admin/coupon')); ?>">
						<i class="fa fa-tags"></i>
						<span class="title">Add Coupon Code</span>
					</a>
				</li>
				-->
				<li class="">
					<a href="<?php echo e(URL::to('admin/manage/manage')); ?>">
						<i class="entypo-picture"></i>
						<span class="title">Manage / Revenue</span>
					</a>
				</li>
				<li class="">
					<a href="<?php echo e(URL::to('admin/menu')); ?>">
						<i class="entypo-list"></i>
						<span class="title">Menu</span>
					</a>
				</li>
				<?php
				}
				if(Auth::user()->role == 'registered' && Auth::user()->contribute == 'contribute'){ 
				}
				else{
				?>

				<li class="">
					<a href="<?php echo e(URL::to('admin/users')); ?>">
						<i class="entypo-users"></i>
						<span class="title">Users</span>
					</a>
					<ul>
					<?php @$p=Auth::user()->username;
						if($p=='admin')
						{
						?>
						<li>
							<a href="<?php echo e(URL::to('admin/users')); ?>">
								<span class="title">All Users</span>
							</a>
						</li>
						<?php
						}
						else
						{
						?>
						<li>
							<a href="<?php echo e(URL::to('admin/users/index1')); ?>">
								<span class="title">All Users</span>
							</a>
						</li>
						<?php
						}
						?>
						<?php @$p=Auth::user()->username;
						if($p=='admin')
						{
						?>
						<li>
							<a href="<?php echo e(URL::to('admin/user/create')); ?>">
								<span class="title">Add New User</span>
							</a>
						</li>

						<li>
							<a href="<?php echo e(URL::to('admin/user/create1')); ?>">
								<span class="title">Add Corporate Admin</span>
							</a>
						</li>
						<?php
						}
						else if(Auth::user()->corporate_user == 'Corporate_Admin')
						{
						?>
						<li>
							<a href="<?php echo e(URL::to('admin/user/create2')); ?>">
								<span class="title">Add Corporate User</span>
							</a>
						</li>
						<li>
							<a href="<?php echo e(URL::to('admin/user/upload')); ?>">
								<span class="title">Add Bulk User</span>
							</a>
						</li>
						<?php
						}
						?>
						<?php @$p=Auth::user()->username;
						if($p=='admin')
						{
						?>
						<li>
							<a href="<?php echo e(URL::to('admin/user/contributor_req')); ?>">
								<span class="title">Contributor / Request</span>
							</a>
						</li>
						<?php
						}
						?>
					</ul>
				</li>
				<?php }?>
			<!--<li class="">
					<a href="<?php echo e(URL::to('admin/themes')); ?>">
						<i class="entypo-monitor"></i>
						<span class="title">Themes</span>
					</a>
				</li>-->
				<?php @$p=Auth::user()->username;
				if($p=='admin')
				{
				?>
					<!--<li class="">
						<a href="<?php echo e(URL::to('admin/plugins')); ?>">
							<i class="fa fa-plug"></i>
							<span class="title">Plugins</span>
						</a>
						<ul>
							<li>
								<a href="<?php echo e(URL::to('admin/plugins')); ?>">All Plugins</a>
							</li>
	                        <?php $PluginsController = new HelloVideo\Http\Controllers\AdminPluginsController(); ?>
	                        <?php $plugins = $PluginsController->get_plugins(); ?>
							<?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                            <?php $this_plugin = HelloVideo\Models\Plugin::where('slug', '=', $plugin['slug'])->first(); ?>
	                            <?php if(isset($this_plugin->name) && isset($this_plugin->active) && $this_plugin->active == 1): ?>
								<li>
									<a href="/admin/plugin/<?php echo e($this_plugin->slug); ?>"><?php echo e($this_plugin->name); ?></a>
								</li>
	                            <?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</li>-->

					<li class="">
						<a href="#">
							<i class=""> $ </i>
							<span class="title">Payment</span>
						</a>
						<ul>
						    <li class="">
								<a href="<?php echo e(URL::to('admin/trackrevenue')); ?>">
									<span class="title">Revenue Tracking</span>
								</a>
							</li>
							<li class="">
								<a href="<?php echo e(URL::to('admin/payment/index1')); ?>">
									<span class="title">Manage Payment For Premium Video</span>
								</a>
							</li>
							<li class="">
								<a href="<?php echo e(URL::to('admin/payment/contributorpay')); ?>">
									<span class="title">Manage Payment For Subscribe Video</span>
								</a>
							</li>
                            <li class="">
								<a href="<?php echo e(URL::to('admin/payment/managecontributorpayment')); ?>">
									<span class="title">Manage Contributor Payment</span>
								</a>
							</li>

						</ul>
					</li>
				<?php }
				if(Auth::user()->role == 'registered' || Auth::user()->contribute == 'contribute'){?>
					<li class="">
						<a href="#">
							<i class=""> $ </i>
							<span class="title">Payment</span>
						</a>
						<ul>
							<li class="">
								<a href="<?php echo e(URL::to('admin/trackrevenue')); ?>">
									<span class="title">Revenue Tracking</span>
								</a>
							</li>
							
								
									
								
							
							
								
									
								
							
						</ul>
					</li>
				<?php } 
				if(Auth::user()->role == 'registered' && Auth::user()->contribute == 'contribute'){

				}else if(Auth::user()->role == 'admin' && Auth::user()->corporate_user =='' ){?>
				<li class="">
					<a href="<?php echo e(URL::to('admin/settings')); ?>">
						<i class="entypo-cog"></i>
						<span class="title">Settings</span>
					</a>
					<ul>
						<li class="">
							<a href="<?php echo e(URL::to('admin/settings')); ?>">
								<span class="title">Site Settings</span>
							</a>
						</li>
						<li class="">
							<a href="<?php echo e(URL::to('admin/payment_settings')); ?>">
								<span class="title">Payment Settings</span>
							</a>
						</li>
						<li class="">
							<a href="<?php echo e(URL::to('admin/theme_settings')); ?>">
								<span class="title">Theme Settings</span>
							</a>
						</li>
						<li class="">
							<a href="<?php echo e(URL::to('admin/videos/banner')); ?>">
								<span class="title">Manage Home Slider</span>
							</a>
						</li>
					</ul>
				</li>
              <?php }
			  
			  ?>

			</ul>

		</div>

	</div>

	<div class="main-content">

		<div class="row">

			<!-- Profile Info and Notifications -->
			<div class="col-md-6 col-sm-8 clearfix">

				<ul class="user-info pull-left pull-none-xsm">
					<!-- Profile Info -->
					<li class="profile"><!-- add class "pull-right" if you want to place this from right -->
						<img src="<?php echo e(Config::get('site.uploads_dir') . 'avatars/' . Auth::user()->avatar); ?>" alt="" class="img-circle" width="26" />
						<span>Howdy, <?php echo e(ucfirst(Auth::user()->username)); ?></span>
					</li>
				</ul>
			</div>


			<!-- Raw Links -->
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">

				<ul class="list-inline links-list pull-right">
					<li class="sep"></li>

					<li>
						<a href="<?php echo e(URL::to('logout')); ?>">
							Log Out <i class="entypo-logout right"></i>
						</a>
					</li>
				</ul>

			</div>

		</div>

		<hr />

		<div id="main-admin-content">

			<?php echo $__env->yieldContent('content'); ?>

		</div>

		<!-- Footer -->
		<footer class="main">

			&copy; 2017 <strong>aflix.tv</strong>

		</footer>
	</div>


</div>

<!-- Sample Modal (Default skin) -->
<div class="modal fade" id="sample-modal-dialog-1">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Widget Options - Default Modal</h4>
			</div>

			<div class="modal-body">
				<p>.</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- Sample Modal (Skin inverted) -->
<div class="modal invert fade" id="sample-modal-dialog-2">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Widget Options - Inverted Skin Modal</h4>
			</div>

			<div class="modal-body">
				<p>.</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- Sample Modal (Skin gray) -->
<div class="modal gray fade" id="sample-modal-dialog-3">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Widget Options - Gray Skin Modal</h4>
			</div>

			<div class="modal-body">
				<p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>




<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo e('/application/assets/admin/js/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
<link rel="stylesheet" href="<?php echo e('/application/assets/admin/js/rickshaw/rickshaw.min.css'); ?>">

<!-- Bottom scripts (common) -->
<script src="<?php echo e('/application/assets/admin/js/gsap/main-gsap.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/bootstrap.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/joinable.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/resizeable.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>


<!-- Imported scripts on this page -->
<script src="<?php echo e('/application/assets/admin/js/jvectormap/jquery-jvectormap-europe-merc-en.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/jquery.sparkline.min.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/rickshaw/vendor/d3.v3.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/rickshaw/rickshaw.min.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/raphael-min.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/morris.min.js'); ?>"></script>
<script src="<?php echo e('/application/assets/admin/js/toastr.js'); ?>"></script>


<!-- JavaScripts initializations and stuff -->
<script src="<?php echo e('/application/assets/admin/js/custom.js'); ?>"></script>


<!-- Demo Settings -->
<script src="<?php echo e('/application/assets/admin/js/main.js'); ?>"></script>

<!-- Notifications -->
<script>
    var opts = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    <?php if(session('note') != '' && session('note_type') != ''): ?>

    if('<?= session("note_type") ?>' == 'success'){
        toastr.success('<?= session("note") ?>', "Sweet Success!", opts);
    } else if('<?= session("note_type") ?>' == 'error'){
        toastr.error('<?= session("note") ?>', "Whoops!", opts);
    }
    <?php Session::forget('note');
    Session::forget('note_type');
    ?>
    <?php endif; ?>

    function display_mobile_menu(){
        if($(window).width() < 768){
            $('.sidebar-collapsed').removeClass('sidebar-collapsed');
        }
    }

    $(document).ready(function(){
        display_mobile_menu();
    });

</script>
<!-- End Notifications -->

<?php echo $__env->yieldContent('javascript'); ?>


</body>
</html>
