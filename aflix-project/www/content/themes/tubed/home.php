<?php include('includes/header.php'); ?>

    <style type="text/css">
        ul.video_list{
            margin:0px;
            padding:0px;
        }

        .video_list li{
            display:inline;
            list-style: none;
        }
    </style>

    <div class="container-fluid">
        <div id="home-content">
            <div class="row" >
                <?php //$featured_videos = HelloVideo\Models\Video::where('active', '=', 1)->where('featured', '=', 1)->orderBy('created_at', 'DESC')->get(); ?>
                <div class="col-md-10 col-md-offset-2 right-content-10" id="featured" style="padding-top:0px; min-height:0px !important;">
                    <?php include('banner.php');?>
                    <div id="featured_loader"></div>
                </div>
            </div>
            <div class="row">
                <?PHP
                $section=DB::select("select * from thumnail_section where id=1 and status=1");
                foreach($section as $sec)
                {
                    ?>
                    <div class="col-md-12 overflow-hidden">
                            <?php $popular_videos = HelloVideo\Models\Video::where('active', '=', 1)->orderBy('views', 'DESC')->take(4)->get(); ?>
                            <div class="mini-slider" data-index="0">
                                <h6><?php echo $sec->name;?></h6>
                                <div class="dot-nav top12">
                                    <!--<div class="dot active" data-index="0"></div>
                                    <div class="dot" data-index="1"></div>
                                    <div class="dot" data-index="2"></div>-->
                                    <b><a href="/allvideos" style="font-size:12px;">SEE ALL >></a></b>
                                </div>
                                <ul style="width:100%;">
                                    <?php foreach($popular_videos as $index => $video): ?>
                                <?php if( ($index%6==0 && $index != 0) ): ?>
                            <?php endif; ?>
                            <?php if($index%6==0): ?>
                        <li style="width:100%;">
                            <div class="row"><?php endif; ?>
                                    <div class="col-md-3 col-sm-2 col-xs-6" style="padding-left:5px; padding-right:5px;">
                                        <?php  include('partials/video-block.php');  ?>

                                    </div>

                                    <?php endforeach; ?>
                                </div>
                        </li>

                            </ul></div>
                        </div>
                    <?php
                }
                ?>

                <?PHP
                $section=DB::select("select * from thumnail_section where id=2 and status=1");
                foreach($section as $sec)
                {
                ?>
                <div class="col-md-12 overflow-hidden" style="background-color:#262425;">

                    <div class="mini-slider" data-index="1">
                        <h6><?php echo $sec->name;?></h6>
                        <?php $recent_videos = HelloVideo\Models\Video::where('active', '=', 1)->orderBy('id', 'DESC')->take(4)->get(); ?>

                        <div class="dot-nav top12">
                            <!--<div class="dot active" data-index="0"></div>
                            <div class="dot" data-index="1"></div>
                            <div class="dot" data-index="2"></div>-->
                            <b><a href="/allvideos" style="font-size:12px;">SEE ALL >></a></b>
                        </div>
                        <ul>
                            <?php foreach($recent_videos as $index => $video): ?>
                        <?php if( ($index%6==0 && $index != 0) ): ?>
                    <?php endif; ?>
                    <?php if($index%6==0): ?><li><div class="row"><?php endif; ?>
                            <div class="col-md-3 col-sm-2 col-xs-6" style="padding-left:5px; padding-right:5px;">
                                <?php include('partials/video-block.php');  ?>
                            </div>

                            <?php endforeach; ?>
                        </div></li>

                    </ul></div>
                </div><!-- .mini-slider -->
           <!-- .col-md-6 -->
            <?php
            }
            ?>
            <!--<div class="col-md-12">
					<?php // $free_videos = HelloVideo\Models\Video::where('active', '=', 1)->where('access', '=', 'guest')->orderByRaw("RAND()")->take(18)->get(); ?>
					<div class="mini-slider" data-index="1">
						<h6 class="no-padding">FREE VIDEOS</h6>
						<div class="dot-nav top12">
							<!--<div class="dot active" data-index="0"></div>
							<div class="dot" data-index="1"></div>
							<div class="dot" data-index="2"></div>-->
            <!--<b><a href="/allvideos">SEE ALL</a></b>
						</div>
						<ul>
							<?php /* foreach($free_videos as $index => $video): ?>
								<?php if( ($index%6==0 && $index != 0) ): ?></div></li><?php endif; ?>
								<?php if($index%6==0): ?><li><div class="row"><?php endif; ?>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<?php include('partials/video-block.php'); */ ?>
									</div>

							<?php //endforeach; ?>
								</div></li>

						</ul>
					</div><!-- .mini-slider -->
            <!--</div>-->

            <?PHP
            $section=DB::select("select * from thumnail_section where id=3 and status=1");
            foreach($section as $sec)
            {
            ?>
            <div class="col-md-12" style="background-color:#262425;">
                <?php $premium_videos = HelloVideo\Models\Video::where('active', '=', 1)->where('access', '=', 'subscriber')->orderByRaw("RAND()")->take(4)->get(); ?>
                <div class="mini-slider" data-index="1">
                    <h6 class="no-padding"><?php echo $sec->name;?></h6>
                    <div class="dot-nav top12">
                        <!--<div class="dot active" data-index="0"></div>
                        <div class="dot" data-index="1"></div>
                        <div class="dot" data-index="2"></div>-->
                        <b><a href="/allvideos?type=subscriber" style="font-size:12px;">SEE ALL >></a></b>
                    </div>
                    <ul>
                        <?php foreach($premium_videos as $index => $video): ?>
                        <?php if( ($index%6==0 && $index != 0) ): ?>

            <?php endif; ?>
                <?php if($index%6==0): ?>
                <li>
                    <div class="row"><?php endif; ?>
                        <div class="col-md-3 col-sm-2 col-xs-6" style="padding-left:5px; padding-right:5px;">
                            <?php include('partials/video-block.php');  ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </li>

                </ul></div>
            </div><!-- .mini-slider -->
        <?php
        }
        ?>

        <?PHP
        $section=DB::select("select * from thumnail_section where id=4 and status=1");
        foreach($section as $sec)
        {
        ?>
        <div class="col-md-12" style="background-color:#262425;">
            <?php $premium_videos = HelloVideo\Models\Video::where('active', '=', 1)->where('access', '=', 'premium')->orderByRaw("RAND()")->take(4)->get(); ?>
            <div class="mini-slider" data-index="1">
                <h6 class="no-padding"><?php echo $sec->name;?></h6>

                <div class="dot-nav top12">
                    <!--<div class="dot active" data-index="0"></div>
                    <div class="dot" data-index="1"></div>
                    <div class="dot" data-index="2"></div>-->
                    <b><a href="/allvideos?type=premium" style="font-size:12px;">SEE ALL >></a></b>
                </div>
                <ul>
                    <?php foreach($premium_videos as $index => $video): ?>
                    <?php if( ($index%6==0 && $index != 0) ): ?>
            <?php endif; ?>
            <?php if($index%6==0): ?><li><div class="row"><?php endif; ?>
                    <div class="col-md-3 col-sm-2 col-xs-6" style="padding-left:5px; padding-right:5px;">
                        <?php include('partials/video-block.php');  ?>
                    </div>

                    <?php endforeach; ?>
                </div></li>

            </ul></div>
        </div><!-- .mini-slider -->
    <?php
}
?>
<?PHP
$section=DB::select("select * from thumnail_section where id=5 and status=1");
foreach($section as $sec)
{
    ?>
    <div class="col-md-12" style="background-color:#262425;">
        <?php $premium_videos = HelloVideo\Models\Video::where('active', '=', 1)->where('access', '=', 'registered')->orderByRaw("RAND()")->take(4)->get(); ?>
        <div class="mini-slider" data-index="1">
            <h6 class="no-padding"><?php echo $sec->name;?></h6>

            <div class="dot-nav top12">
                <!--<div class="dot active" data-index="0"></div>
                <div class="dot" data-index="1"></div>
                <div class="dot" data-index="2"></div>-->
                <b><a href="/allvideos?type=registered" style="font-size:12px;">SEE ALL >></a></b>
            </div>
            <ul>
                <?php foreach($premium_videos as $index => $video): ?>
                <?php if( ($index%6==0 && $index != 0) ): ?>
        <?php endif; ?>
        <?php if($index%6==0): ?><li><div class="row"><?php endif; ?>
                <div class="col-md-3 col-sm-2 col-xs-6" style="padding-left:5px; padding-right:5px;">
                    <?php include('partials/video-block.php');  ?>
                </div>

                <?php endforeach; ?>
            </div></li>

        </ul></div>
    </div><!-- .mini-slider -->
    <?php
}
?>

<?PHP
$section=DB::select("select * from video_categories where status=1");
foreach($section as $sec)
{
    ?>
    <div class="col-md-12" style="background-color:#262425;">
        <?php //$premium_videos = HelloVideo\Models\Video::where('active', '=', 1)->where('access', '=', 'registered')->orderByRaw("RAND()")->take(4)->get();
        $premium_videos = DB::select("select * from videos where video_category_id='".$sec->id."' AND active=1 order by id desc limit 4");
        ?>
        <div class="mini-slider" data-index="1">
            <h6 class="no-padding"><?php echo $sec->name;?></h6>
            <div class="dot-nav top12">
                <!--<div class="dot active" data-index="0"></div>
                <div class="dot" data-index="1"></div>
                <div class="dot" data-index="2"></div>-->
                <b><a href="/allvideos?category=<?php echo $sec->id;?>" style="font-size:12px;">SEE ALL >></a></b>
            </div>
            <ul>
                <?php foreach($premium_videos as $index => $video): ?>
                <?php if( ($index%6==0 && $index != 0) ): ?>
       <?php endif; ?>
        <?php if($index%6==0): ?><li><div class="row"><?php endif; ?>
                <div class="col-md-3 col-sm-2 col-xs-6" style="padding-left:5px; padding-right:5px;">
                    <?php include('partials/video-block.php');  ?>
                </div>

                <?php endforeach; ?>
            </div></li>

        </ul> </div>
    </div><!-- .mini-slider -->

    <?php
}
?>
    </div>
            <!--<div class="col-md-2" id="home-right-sidebar">
				<h6>Recent Articles</h6>
				<?php $posts = HelloVideo\Models\Post::where('active', '=', 1)->orderBy('created_at', 'DESC')->take(4)->get(); ?>
				<?php foreach($posts as $post): ?>
					<?php include('partials/post-block.php'); ?>
				<?php endforeach; ?>
			</div>-->
        </div>
    </div>

<?php //include('partials/pagination.php'); ?>
    <script src="<?= THEME_URL . '/assets/js/mini-slider.jquery.js'; ?>"></script>
<?php include('includes/footer.php'); ?>
