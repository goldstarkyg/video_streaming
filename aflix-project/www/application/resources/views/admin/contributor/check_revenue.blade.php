@extends('admin.master')

@section('content')

  <!--[hook_admin_dashboard_widgets_start]-->

  <div class="row">
  <?php if(Auth::user()->role == 'registered' || Auth::user()->contribute == 'contribute'){ ?>
    <div class="col-md-4">
      <div class="tile-stats tile-aqua">
        <div class="icon"><i class="entypo-video"></i></div>
        <?php 
            $video=DB::select("select * from videos where access='subscriber' AND user_id=".Auth::user()->id."");
            
              $video5=0;
              foreach($video as $vid5)
              {
                   $video5=$video5+1;
              }
        ?>
        <div class="num" data-start="0" data-end="<?php echo $video5;?>" data-postfix="" data-duration="1500" data-delay="1200"><?php echo $video5;?></div>
        <h3>My Paid Subscriber Videos</h3>
      </div>
    </div><!-- column 1-->
    <div class="col-md-4">
      <div class="tile-stats tile-aqua">
        <div class="icon"><i class="entypo-video"></i></div>
        <?php $video=DB::select("select * from videos where access='premium' AND user_id=".Auth::user()->id."");
              $video5=0;
              foreach($video as $vid5)
              {
                   $video5=$video5+1;
              }
        ?>
        <div class="num" data-start="0" data-end="<?php echo $video5;?>" data-postfix="" data-duration="1500" data-delay="1200"><?php echo $video5;?></div>
        <h3>My Premium Videos</h3>  
      </div>
    </div><!-- column 2-->

    <div class="col-md-4">
      <div class="tile-stats tile-aqua">
        <div class="icon"><i class="entypo-video"></i></div>
        <?php $video=DB::select("select * from videos where (access='registered' OR access='guest') AND user_id=".Auth::user()->id."");
              $video5=0;
              foreach($video as $vid5)
              {
                   $video5=$video5+1;
              }
        ?>
        <div class="num" data-start="0" data-end="<?php echo $video5;?>" data-postfix="" data-duration="1500" data-delay="1200"><?php echo $video5;?></div>
        <h3>My Free Registered Videos</h3>
      </div>
    </div><!-- column 3-->
    
    <?php } ?>
    
  </div><!-- row -->

  <!--[hook_admin_dashboard_widgets_start]-->

  <br />

  <div id="google_analytics_login_container">
    <div id="google_analytics_login">

      <div id="embed-api-auth-container"></div>
    </div>
  </div>

  <script>
        (function(w,d,s,g,js,fs){
            g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
            js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
            js.src='https://apis.google.com/js/platform.js';
            fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
        }(window,document,'script'));
  </script>

  <script src="{{ URL::to('/') }}/application/assets/admin/js/ganalytics/Chart.min.js"></script>
  <script src="{{ URL::to('/') }}/application/assets/admin/js/ganalytics/moment.min.js"></script>
  <script src="{{ URL::to('/') }}/application/assets/admin/js/ganalytics/active-users.js"></script>
  <script src="{{ URL::to('/') }}/application/assets/admin/js/ganalytics/view-selector2.js"></script>

  <div class="row">
    

    <div class="col-sm-8">

      <div class="panel panel-primary" id="charts_env">
        <div class="panel-heading">
          <div class="panel-title">Monthly Revenue</div>
          <div class="panel-options">
            <div class="ViewSelector" id="view-selector-container"></div>
          </div>
        </div>
        <div style="position: relative;">
            <canvas id="myChart" height=115px></canvas>
        </div>
        
      </div><!-- .panel-primary -->

    </div><!-- .col-sm-8 -->

    <div class="col-sm-4">

      <div class="panel panel-primary" id="charts_env">
        <div class="panel-heading">
          <div class="panel-title">Premium Video Revenue</div>
        </div>

        <div class="panel-body active-users-panel">
          <div class="tab-content">
            <div id="active-users-container">
                 <div style="position: relative;">
            <canvas id="yearChart" ></canvas>
        </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- .col-sm-4 -->

  </div><!-- .row -->

  <div class="row">
    <div class="col-sm-6">

      <div class="panel panel-primary" id="charts_env">
        <div class="panel-heading">
          <div class="panel-title">Monthly Subscribed Video Revenue</div>
        </div>

        <div class="panel-body">
          <div class="tab-content">
            <div id="chart-3-container">
            <div style="position: relative;">
            <canvas id="sponseredChart" ></canvas>
        </div>
            </div>
           
          </div>
        </div>
      </div><!-- .panel-primary -->

    </div><!-- .col-sm-6 -->

    <div class="col-sm-6">

      <div class="panel panel-primary" id="charts_env">
        <div class="panel-heading">
          <div class="panel-title">Monthly Premium Video Revenue</div>
        </div>

        <div class="panel-body">
          <div class="tab-content">
            <div id="chart-4-container">
            <div style="position: relative;">
            <canvas id="premiumChart" ></canvas>
        </div>
            </div>
           
          </div>
        </div>
      </div><!-- .panel-primary -->

    </div><!-- .col-sm-6 -->

  </div><!-- .row -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
<script>
$(document).ready(function(){
    var ctx = $('#myChart');
    var json = $.parseJSON('<?php echo $month_chart_data;?>');
    var displaydata = []; 
	for(var i in json) {
		displaydata.push(json[i].month);
	}
   
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: 'Monthly Revenue From Premium & Sposored Video',
                //data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 1000, 0, 0],
                data: displaydata,
                backgroundColor: "rgba(75,192,192,0.4)",
            strokeColor: "rgba(220,220,220,0.8)", 
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
                borderWidth: 1
            }]
        },
    });
    
     // premium video data chart  
     var pmjson = $.parseJSON('<?php echo $month_premium_chart_data;?>');
     var pmdata = []; 
	 for(var i in pmjson) {
		pmdata.push(pmjson[i].month);
	 }
    var poptions = {}
    var pdata = {
       labels: ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
            {
                label: "Revenue From Premium Video",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                //data: [65, 59, 80, 81, 56, 55, 40, 89, 99, 88, 88, 78],
                 data: pmdata,
                spanGaps: false,
            }
        ]
    };
    var ctx1 = document.getElementById("premiumChart");
    var pmyChart = new Chart(ctx1,{
        type: 'line',
        data: pdata,
        options: poptions
    })
    
  // sponsered video data chart  
    var subjson = $.parseJSON('<?php echo $month_subs_chart_data;?>');
    var subdata = []; 
	for(var i in subjson) {
		subdata.push(subjson[i].month);
	}
    var soptions = {}
    var sdata = {
       labels: ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
            {
                label: "Revenue From Sponsered Video",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                //data: [65, 59, 80, 81, 56, 55, 40, 89, 99, 88, 88, 78],
                data: subdata,
                spanGaps: false,
            }
        ]
    };
    var ctx2 = document.getElementById("sponseredChart");
    var pmyChart = new Chart(ctx2,{
        type: 'line',
        data: sdata,
        options: soptions
    })
    
    //year revenue
    var yjson = $.parseJSON('<?php echo $year_chart_data;?>');
    var ydata = []; 
	for(var i in yjson) {
		ydata.push(yjson[i].year);
	}
    var soptions = {}
    var sdata = {
       labels: ["2017"],
        datasets: [
            {
                label: "Current Year Revenue",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: ydata,
                spanGaps: false,
            }
        ]
    };
    var ctx3 = document.getElementById("yearChart");
    var pmyChart = new Chart(ctx3,{
        type: 'line',
        data: sdata,
        options: soptions
    })
});
</script>
@stop
