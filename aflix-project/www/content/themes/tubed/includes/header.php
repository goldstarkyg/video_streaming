<!DOCTYPE html>
<html>
<head>

    <?php include('head.php'); ?>
	<meta name="_token" content="<?php echo csrf_token();?>"/>
<style type="text/css">

#blah:hover {
filter: none;

	      transition: 0.5s all ease;

margin-left:-5px;
margin-right:-5px;
}


    </style>
	
</head>
<body <?php if(Request::is('/')) echo 'class="home"'; ?>>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">

        <div class="row">
            <div class="navbar-header col-md-8 col-sm-12">
                <div class="col-md-1 row">
                    <div class="menu-toggle">
                        <i class="fa fa-caret-left"></i><i class="fa fa-bars"></i><i class="fa fa-caret-right"></i>
                    </div>
                </div>
                <div class="col-md-4 hello" style="margin-top:20px; color:white;"><a href="/show" style="color:#fff;">SHOWS</a> |<a href="/live" style="color:#fff;"> LIVE</a></div>
                <div class="col-md-4">
                    <?php $logo = (!empty($settings->logo)) ? Config::get('site.uploads_dir') . 'settings/' . $settings->logo : THEME_URL . '/assets/img/logo.png'; ?>
                    <a href="/" class="navbar-brand">
                        <img src="<?= $logo ?>" style="height:40px;" />
                    </a></div>
            </div>
            <div class="col-sm-12 mobile-only" style="text-align: center; padding-top: 10px;background: #000; color: #fff">
                <a href="/show" style="color:#fff;">SHOWS</a> |
                <a href="/live" style="color:#fff;"> LIVE</a> |
                <?php
                if(@Auth::user()->role!= 'admin')
                {
                   if(@Auth::user()->email == '') { ?>
                        <a href="" data-toggle="modal" data-target="#register" style="color: #fff; font-weight: normal; text-decoration: none; font-size: 14px;">Contribute</a>
                   <?php }elseif(@Auth::user()->contribute_req =='0' OR @Auth::user()->contribute_req_status =='0')
                   { ?> <a href="#" data-toggle="modal" data-target="#myModal" style="color: #fff; font-weight: normal; text-decoration: none; font-size: 14px;">Contribute</a>
                   <?php }else{ ?>
                    <a href="/admin/videos/create" style="color: #fff; font-weight: normal; text-decoration: none; font-size: 14px;">Contribute </a>
                   <?php
                   }
                }
                ?>
            </div>
            <div class="col-md-2 search col-sm-12">
                <form role="search" action="/search" method="GET">
                    <input type="text" id="value" class="search1-only1" name="value" placeholder="Search..." style=" background-color:#333; color:#fff;height: 10px; margin-top: 15px;">
					 <i class="fa fa-search"></i>
                </form>
				<?php
				if(@Auth::user()->role!= 'admin')
				{
				?>
                <div class="col-md-2 col-sm-12" style="margin-top:-29px;margin-left: 61%;;color:white;">

                    <?php if(@Auth::user()->email == '') { ?>
                        <span class="signup-desktop">
            <a href="" data-toggle="modal" data-target="#register" style="color: #fff; font-weight: normal; text-decoration: none; font-size: 14px;">Contribute</a></span>
                    <?php }elseif(@Auth::user()->contribute_req =='0' OR @Auth::user()->contribute_req_status =='0'){ ?> <a href="#" data-toggle="modal" data-target="#myModal" style="color: #fff; font-weight: normal; text-decoration: none; font-size: 14px;">Contribute</a> <?php }else{ ?>
                       <!-- <a href="/addvideos" style="color: #fff; font-weight: normal; text-decoration: none; font-size: 14px;">Contribute </a>-->
                        <a href="/admin/videos/create" style="color: #fff; font-weight: normal; text-decoration: none; font-size: 14px;">Contribute </a>
                    <?php } ?></div>

              <?php
			  }
			  ?>
            </div>
            <div class="col-md-2 right-nav">
                <div class="row">
                    <ul class="nav navbar-nav navbar-right">

                        <?php if(Auth::guest()): ?>

                            <li class="login-desktop"><a href=""  data-toggle="modal" data-target="#mylogin" style="background-color: #000;color: #fff;"><i class="fa fa-lock"></i> Login<span class="border-bottom"></span></a></li>
                            <li class="signup-desktop"><a href="" data-toggle="modal" data-target="#register" style="background-color: #000;color: #fff;"> Signup<span class="border-bottom"></span></a></li>

                        <?php else: ?>

                            <li class="dropdown">
                                <a href="#_" class="user-link-desktop dropdown-toggle" data-toggle="dropdown"><img src="<?= Config::get('site.uploads_dir') . 'avatars/' . Auth::user()->avatar ?>" class="img-circle" /> <span><?= ucwords(Auth::user()->username) ?></span> <i class="fa fa-chevron-down"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?= ($settings->enable_https) ? secure_url('favorites') : URL::to('favorites') ?>">My Favorites</a></li>
                                    <?php if(Auth::user()->role=='admin')
                                    {
                                     ?>

                                    <?php
                                    }
									else
									{
                                    ?>
									<li><a href="<?= ($settings->enable_https) ? secure_url('my_purchase') : URL::to('my_purchase') ?>">My Purchase</a></li>
									<?php
									}
									?>
                                    <?php if(Auth::user()->contribute == 'contribute' || Auth::user()->contribute == 'contribute'):  ?>
                                        <li class="divider"></li>
                                        <li><a href="<?= ($settings->enable_https) ? secure_url('admin') : URL::to('admin') ?>">Contributor Dashboard</a></li>
                                        <li class="divider"></li>
                                        <!--<li><a href="<? //= ($settings->enable_https) ? secure_url('addvideos') : URL::to('addvideos') ?>">Contribute</a></li>-->
                                        <li><a href="<?= ($settings->enable_https) ? secure_url('my_video') : URL::to('my_video') ?>"> My Videos</a></li>
                                        <li><a href="<?= ($settings->enable_https) ? secure_url('my_payment') : URL::to('my_payment') ?>"> My Payment</a></li>

                                    <?php endif; ?>
                                    <?php if(Auth::user()->role == 'admin' || Auth::user()->corporate_user == 'Corporate_Admin'):  ?>
                                        <li class="divider"></li>
                                        <li><a href="<?= ($settings->enable_https) ? secure_url('admin') : URL::to('admin') ?>"> Admin 1</a></li>
                                    <?php endif; ?>
                                    <li class="divider"></li>
                                    <li><a href="<?= ($settings->enable_https) ? secure_url('logout') : URL::to('logout') ?>" id="user_logout_mobile"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </li>

                        <?php endif; ?>
                    </ul>
                </div>

                <!--form class="navbar-form navbar-right search" role="search"><div class="form-search search-only"><i class="fa fa-search"></i> <input class="form-control search-query" placeholder="search..."></div></form-->

            </div>
        </div><!-- .row -->

    </div>

    </div>
</nav>

<div class="container-fluid">
    <div class="row" style="position:relative; height:100%;">
        <div class="col-md-2 col-xs-8" id="left-sidebar">
            <div class="background"></div>
            <h4>Guide</h4>
            <div class="guide-menu">
                <a href="/"><i class="hv-home-house-streamline"></i> Home</a>
                <a href="/allvideos"><i class="hv-tv"></i> Videos</a>
                <a href="/posts"><i class="hv-book-read-streamline"></i> Articles</a>
            </div>
            <h4>Menu</h4>
            <?php include('menu.php'); ?>
            <ul>
            </ul>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <form method="post" action="/send_request">
                    <div class="modal-content">
                        <div class="modal-header">
                            <input type="hidden" name="req_email" value="<?php echo @Auth::user()->email; ?>">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">You Want to become a contributer.</h4>
                        </div>
                        <div class="modal-body">

                            <p> Please Send a Request to become a contributer
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                                <?php if(@Auth::user()->contribute_req =='0' AND @Auth::user()->contribute_req_status =='0')
                                {
                                    ?>
                                    <input type="submit" name="btnreq" class="btn btn-primary" value="Send Request">
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <input type="button" name="btnreq" class="btn btn-primary" value="Request Already Send">
                                    <?php
                                }
                                ?>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="main-content">
