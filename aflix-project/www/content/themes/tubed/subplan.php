<link type="text/css" rel="stylesheet" href="<?= THEME_URL . '/assets/css1/q.css'; ?>" />
<link type="text/css" rel="stylesheet" href="<?= THEME_URL . '/assets/css1/e.css'; ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<style>
    #buyitnow {
        max-width: 840px;
        margin: 0 auto;
        margin-bottom: 60px;
    }

    #buyitnow .page-header h1 {
        margin-top: 56px;
        margin-bottom: 24px;
        font-size: 32px;
    }


    #buy_steps {
        margin-bottom: 30px;
    }



    #buyitnow_container .edit-plan {

    }

    #buyitnow_container .recurly .subscription {
        padding: 0;
        border-radius: 0;
    }
    #buyitnow_container .recurly .plan,
    #buyitnow_container .recurly .subplan {
        padding-top: 10px;
        padding-bottom: 5px;
    }
    #buyitnow_container .recurly .plan .name,
    #buyitnow_container .recurly .plan .recurring_cost .cost,
    #buyitnow_container .recurly .subplan .name,
    #buyitnow_container .recurly .subplan .recurring_cost .subcost,
    #buyitnow_container .recurly .plan .coupon .discount {
        font-size: 14px;
        color: #333;
        font-weight: normal;
    }
    /*
    #buyitnow_container .recurly .plan .recurring_cost,
    #buyitnow_container .recurly .subplan .recurring_cost,
    #buyitnow_container .recurly .coupon {
        padding-right: 30px;
        height: 110px;
    }
    */
    #buyitnow_container .recurly .plan .recurring_cost .interval,
    #buyitnow_container .recurly .subplan .recurring_cost .interval {
        padding-bottom: 0;
    }

    #buyitnow_container .box .recurly {
        width: auto;
    }

    #buyitnow_container .box .recurly .separator {
        background: none;
        background-color: #f1f3f5;
    }

    #buyitnow_container .box .recurly .subscribe {
        background-color: #f1f3f5;
    }

    #buyitnow_container .box .recurly .plan {
        border-top: solid 1px #ccc;
    }

    #buyitnow_container .box .recurly .due_now_total,
    #buyitnow_container .box .recurly .due_now_subtotal {
        left: 0;
        height: 65px;
        line-height: 48px;
        font-size: 16px;
        font-weight: bold;
        padding: 0 30px 0 20px;
        margin: 0;
        border-width: 0;

        background-color: #f1f3f5;
        color: #333;
        border-radius: 0;

    }

    #buy_steps .title {
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        padding: 5px;
        background: #eee;
        color: #aaa;
    }
    #buy_steps .title span.text {
        display: inline-block;
        font-size: 16px;
        padding: 10px;
    }
    #buy_steps .title span.text .number {
        font-size: 1.4em;
    }
    #buy_steps .enabled .title {
        background: #9dc8e2;
        color: #fff;
    }
    #buy_steps .active .title {
        color: #fff;
        background: #2184be;
    }

    #due_now_total {
        cursor: pointer;
        position: relative;
    }
    #due_now_total a.expandbutton{
        position: absolute;
        right: 5px;
        text-decoration: none;
        font-size: 18px;
        color: #999;
    }


    #buyitnow_container .edit-plan {
        padding: 10px 10px 10px 30px;
    }

    #buyheader {
        background-color: #fff;
        position: relative;
        max-width: 840px;
        padding:0;
    }

    #buyheader h2 {
        padding: 0;
        margin: 56px 0 24px;
        font-size: 32px;
    }

    .buytopnav {
        padding: 0;
        margin: 0;
        font-size: 0;
        border-radius: 4px;
        overflow:hidden;
        width: 840px;
    }

    .buytopnav li {
        list-style-type: none;
        padding: 0;
        display: inline-block;
    }

    .buytopnav .btn {

        font-size: 16px;
        text-align: left;
        line-height: 24px;
        padding: 14px 0 14px 30px;
        cursor: default;
        border-radius: 0;
        border:  0 none;
        color: #AAA;
        outline: 0 none;
        width: 280px;
    }

    .buytopnav .step1.step1-selected,
    .buytopnav .step2.step2-selected{
        background: #E8E8E8 url("https://d24cgw3uvb9a9h.cloudfront.net/static/90018/image/billing/step-1.png") right center no-repeat;
        color: #333;
        background-size:30px auto;
    }

    .buytopnav .step1.step2-selected,
    .buytopnav .step2.step3-selected{
        background: #F8F8F8 url("https://d24cgw3uvb9a9h.cloudfront.net/static/90018/image/billing/step-2.png") right center no-repeat;
        background-size:30px auto;
    }
    .buytopnav .step1.step3-selected,
    .buytopnav .step2.step1-selected{
        background: #F8F8F8 url("https://d24cgw3uvb9a9h.cloudfront.net/static/90018/image/billing/step-3.png") right center no-repeat;
        background-size:30px auto;
    }


    .buytopnav .step3{
        background: #F8F8F8 none;
    }

    .buytopnav .step3.step3-selected{
        background: #E8E8E8 none;
        color: #333;
    }


    #buyheader ul.buytopnav li .btn.roomconnector {
        width: 294px;

    }

    #buyheader ul.buytopnav li.active .btn {
        color: rgb(88,90,92);
        font-weight: bold;
        border-color: rgb(178,180,182);
    }

    #buyheader ul.buytopnav li.active {
        border-bottom-color: rgb(45,165,255);
    }

    .graySelect{
        height: 52px;
        background: #E9E9E9;
        border-width: 0px;
        color:#333333;
    }

    .whiteUnselect{
        height: 52px;
        background: #f8f8f8;
        border-width: 0px;
        color:#AAAAAA;
    }


    /*  less than 767px  */
    @media screen and (max-width : 767px) {
        #plan_form>.row {
            margin: 0;
        }
        #buyitnow {
            padding: 0 2px;
        }
        #buyitnow .page-header h1 {
            margin-top: 0;
        }

        .buytopnav {
            width: 100%;
        }

        .buytopnav li {
            width: 33.3%;
        }
        .buytopnav .btn {
            width: 100%;
        }

        .buytopnav .btn {
            font-size: 12px;
            padding: 14px 0 14px 6px;
        }

    }

    @media screen and (min-width : 768px)  and  (max-width : 1024px) {
        #plan_form>.row {
            margin: 0;
        }
        #buyitnow {
            padding: 0 2px;
        }
        #buyitnow .page-header h1 {
            margin-top: 0;
        }

        .buytopnav {
            width: 100%;
        }

        .buytopnav li {
            width: 33.3%;
        }
        .buytopnav .btn {
            width: 100%;
        }

        .buytopnav .btn {
            font-size: 12px;
            padding: 14px 0 14px 6px;
        }

    }
</style>
<style>
    .or-line {
        background: #b7b7b7;
        border-bottom: 1px solid #fff;
        width: 100%;
        float: left;
        position: relative;
        height: 2px;
        text-align: center;
    }
    .or {
        position: absolute;
        margin: 0 auto;
        text-align: center;
        top: -8px;
        left: 45%;
        font-size: 16px;
        color: #747272;
        background: #fff;
        width: 50px;
    }
</style>
<div id="buyitnow_container">
    <div class="col-md-12">
        <div class="col-md-8" >
            <div  class="col-md-4 tdDiv selected" id="l" style="border: solid 1px #797b74; padding: 10px; margin: 5px;">
                <?php
                $plan1=DB::select("select * from subscribe_plane where validity=30");
                foreach($plan1 as $plan)
                {
                    ?>
                    <div><?php echo $plan->title; ?></div>
                    <div class="priceDivMonthly">
                        <label>$<?php echo $plan->amount; ?></label>
                        <label class="unitMonthly ng-scope">/monthly</label>
                    </div>
                    <div class="describleMonthly">Billed monthly</div>
                    <?php
                }
                ?>
            </div>
            <div  class="col-md-4 tdDiv" id="ll" style="border: solid 1px #797b74; padding: 10px; margin: 5px;">
                <?php
                $plan2=DB::select("select * from subscribe_plane where validity=365");
                foreach($plan2 as $plan2)
                {
                    ?>
                    <div><?php echo $plan2->title; ?></div>
                    <div class="priceDivMonthly">
                        <label>$ <?php echo $plan2->amount; ?></label>
                        <label class="unitMonthly ng-scope">/yearly</label>
                    </div>
                    <div class="describleMonthly">Billed annualy</div>
                    <div class="circle">
                        <label>Save</label>
                        <span ng-bind="(buyPlan.pro.month_amount*12-buyPlan.pro.yearly_amount)*buyPlan.pro.selectedHost/100| toInt" class="ng-binding">$2</span>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="rightCart ng-scope" ng-controller="rightCartController" id="z">
                <style>
                    .rightCart{
                        width: 243px;
                        display: inline-block;
                        float:right;
                        margin: 0 0 40px 20px;
                        border-radius: 4px;
                        background-color: #ffffff;
                    }

                    .rightCartOrder{
                        -moz-border-radius: 15px;
                        -webkit-border-radius: 15px;
                        border: solid 1px #e0e2e4;
                        margin-left: 40px;
                    }

                    .rightCart .headerLabel{
                        font-size: 18px;
                        padding-left: 20px;
                        padding-top: 12px;
                        padding-bottom: 12px;
                        border-bottom: 1px solid #e0e2e4;
                        width: 100%;

                    }

                    .rightCartOrder table{
                        width:100%;
                        margin: 15px 0;
                    }

                    .firstColumn {
                    }

                    .grayColor{
                        font-size: 12px;
                        color: #919191;
                    }

                    .planTitle{
                        color: #222222;
                    }

                    .secondColumn {
                        text-align: right;
                        white-space: nowrap;
                    }
                    .todayTotalDesc{
                        font-size: 12px;
                        color: #919191;
                        text-align: right;
                    }
                    .todayTotal{
                        font-size: 24px;
                        line-height: 1.3;
                        color: #222222;
                    }
                    .rightCart .accepted_cards{
                        display: inline-block;
                        width: 100px;
                        overflow: hidden;
                    }

                    .rightCartOrder hr{
                        margin: 20px 10px;
                    }

                    .rightCart .card {
                        background-position: right top;
                        background-repeat: no-repeat;
                        text-indent: -3000px;
                        width: 32px;
                        height: 32px;
                        margin: 0;
                        padding: 0;
                        display: inline-block;
                    }
                    .visa{
                        background-image: url("img/PayPal.png");
                    }

                    .payMethod{
                        text-align: center;
                        padding-bottom: 10px;
                    }

                    .payMethod h4{
                        font-size: 13px;
                        margin: 8px 0 4px;
                    }
                    .payMethod p{
                        font-size: 12px;
                        color: #999;
                        margin: 0 0 10px;
                    }
                    .payMethod p strong{
                        color: #333;
                    }

                    .recurringTitle{
                        font-size: 12px;
                        line-height: 1.7;
                        color: #222222;
                    }

                    .rightCart .telephone{
                        text-align: center;
                        margin-top: 20px;
                        border-radius: 3px;
                        background-color: #ffffff;
                        border: solid 1px #e0e2e4;
                        font-size: 13px;
                        color: 666;
                        padding: 10px;
                    }



                    .telephoneIcon{
                        background-image: url("https://d24cgw3uvb9a9h.cloudfront.net/static/90018/image/telephone.png");
                        width: 25px;
                        height: 26px;
                    }
                    .cartDeleteA {
                        font-size: 12px!important;
                        line-height: 1.7!important;
                        color: #9b9b9b!important;
                        cursor: pointer;
                    }

                    .rightCart .orderItem{
                        margin: 15px 20px;
                    }

                    .rightCart  .telephone  a{
                        text-decoration: none;
                        font-size: 16px;
                        color:#333;
                        font-size: 16px;
                        font-weight: 600;
                    }

                    @media screen and (max-width : 767px) {
                        .rightCart{
                            width:100%;
                            margin-top: 30px;
                        }

                        .rightCartCoupon .coupon div.coupon_code{
                        }
                        .rightCartCoupon .coupon input.coupon_code{
                            width:61%!important;
                        }
                        .rightCartCoupon .coupon .check{
                            width: 39%;
                        }
                        .recurly .accept_tos{
                            text-align: left;
                        }
                        .recurly .footer{
                            text-align: center;
                        }
                    }

                    @media screen and  (min-width : 768px) and  (max-width : 1024px){
                        .rightCart{
                            width:35%;
                        }

                        .rightCartCoupon .coupon div.coupon_code{
                            width: 98%;
                        }
                        .rightCartCoupon .coupon input.coupon_code{
                            width:61%!important;
                        }
                        .rightCartCoupon .coupon .check{
                            width: 38%;
                        }
                    }
                </style>
                    <div class="rightCartOrder">
                        <label class="headerLabel">Order Summary
                            <a ng-click="editCart()" style="float: right; margin: 4px 20px 0px 0px; font-size: 13px; font-weight: 300; display: none;" href="javascript:void(0)">Edit</a>
                        </label>
                        <?php
                        $plan1=DB::select("select * from subscribe_plane where validity=30");
                        foreach($plan1 as $plan)
                        {
                        ?>
                        <div ng-repeat="val in buyPlan |filterNavItems " class="orderItem ng-scope">
                            <div class="planItem ng-scope" ng-if="val.category=='pro'||val.category=='biz'||val.category=='education'">
                                <div ng-if="val.isYearlySelected" class="ng-scope">
                                    <label class="planTitle ng-scope" ng-if="val.category=='pro'"><?php echo $plan->title; ?></label><!-- end ngIf: val.category=='pro' -->
                                    <span class="planVal ng-binding" ng-bind="val.yearly_amount*val.selectedHost/100| currency">$<?php echo $plan->amount; ?></span>
                                </div>

                                <div class="planAttr">
                                    <label ng-if="val.isYearlySelected" class="planTitle ng-scope">
                                        <span ng-bind="(val.yearly_amount/100| currency)+'/yr/host'" class="ng-binding"></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div id="discountDiv" class="orderItem clearfix" style="display: none;">
                            <div class="planItem">
                                <label class="planTitle">Discount</label>
                                <div class="planVal discount" style="color: red;"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="orderItem">
                            <table>
                                <tbody><tr>
                                    <td class="planTitle firstColumn">Today's Charge </td>
                                    <td class="secondColumn todayTotal ng-binding" ng-bind="(todayTotalPrice()+discount)|currency">$<?php echo $plan->amount; ?></td>
                                </tr>
                                </tbody></table>
                        </div>
                        <hr>
                        <div class="payMethod">
                            <h4>
                                Charges auto-renew          </h4>
                            <p>
                                (unless cancelled before next renewal date)         </p>

                            <div class="accepted_cards">
                                <img src="/content/uploads/images/PayPal.png" style="width: 85%;">

                                <center><a href="<?php  echo '/user/' . @ucwords(Auth::user()->username) . '/renew_subscription?video_id='.$video->id.'&plan='.$plan->id.'';?>" style="float: inherit; padding: 7px;" id="button" class="btn btn-xs btn-info">Continue</a></center>
                            </div>
                            <p>
                                All amounts shown in <strong>U.S. dollars</strong>          </p>

                        </div>

                    <?php
                    }
                    ?>
                    </div>
                </div>
            <div class="rightCart ng-scope" ng-controller="rightCartController" id="zz">
                <style>
                    .rightCart{
                        width: 243px;
                        display: inline-block;
                        float:right;
                        margin: 0 0 40px 20px;
                        border-radius: 4px;
                        background-color: #ffffff;
                    }

                    .rightCart .headerLabel{
                        font-size: 18px;
                        padding-left: 20px;
                        padding-top: 12px;
                        padding-bottom: 12px;
                        border-bottom: 1px solid #e0e2e4;
                        width: 100%;

                    }

                    .rightCartOrder table{
                        width:100%;
                        margin: 15px 0;
                    }

                    .firstColumn {
                    }

                    .grayColor{
                        font-size: 12px;
                        color: #919191;
                    }
                    .planTitle{
                        color: #222222;
                    }

                    .secondColumn {
                        text-align: right;
                        white-space: nowrap;
                    }
                    .todayTotalDesc{
                        font-size: 12px;
                        color: #919191;
                        text-align: right;
                    }
                    .todayTotal{
                        font-size: 24px;
                        line-height: 1.3;
                        color: #222222;
                    }
                    .rightCart .accepted_cards{
                        display: inline-block;
                        width: 100px;
                        overflow: hidden;
                    }

                    .rightCartOrder hr{
                        margin: 20px 10px;
                    }

                    .rightCart .card {
                        background-position: right top;
                        background-repeat: no-repeat;
                        text-indent: -3000px;
                        width: 32px;
                        height: 32px;
                        margin: 0;
                        padding: 0;
                        display: inline-block;
                    }
                    .visa{
                        background-image: url("img/PayPal.png");
                    }

                    .payMethod{
                        text-align: center;
                        padding-bottom: 10px;
                    }

                    .payMethod h4{
                        font-size: 13px;
                        margin: 8px 0 4px;
                    }
                    .payMethod p{
                        font-size: 12px;
                        color: #999;
                        margin: 0 0 10px;
                    }
                    .payMethod p strong{
                        color: #333;
                    }

                    .recurringTitle{
                        font-size: 12px;
                        line-height: 1.7;
                        color: #222222;
                    }

                    .rightCart .telephone{
                        text-align: center;
                        margin-top: 20px;
                        border-radius: 3px;
                        background-color: #ffffff;
                        border: solid 1px #e0e2e4;
                        font-size: 13px;
                        color: 666;
                        padding: 10px;
                    }



                    .telephoneIcon{
                        background-image: url("https://d24cgw3uvb9a9h.cloudfront.net/static/90018/image/telephone.png");
                        width: 25px;
                        height: 26px;
                    }
                    .cartDeleteA {
                        font-size: 12px!important;
                        line-height: 1.7!important;
                        color: #9b9b9b!important;
                        cursor: pointer;
                    }

                    .rightCart .orderItem{
                        margin: 15px 20px;
                    }

                    .rightCart  .telephone  a{
                        text-decoration: none;
                        font-size: 16px;
                        color:#333;
                        font-size: 16px;
                        font-weight: 600;
                    }

                    @media screen and (max-width : 767px) {
                        .rightCart{
                            width:100%;
                            margin-top: 30px;
                        }

                        .rightCartCoupon .coupon div.coupon_code{
                        }
                        .rightCartCoupon .coupon input.coupon_code{
                            width:61%!important;
                        }
                        .rightCartCoupon .coupon .check{
                            width: 39%;
                        }
                        .recurly .accept_tos{
                            text-align: left;
                        }
                        .recurly .footer{
                            text-align: center;
                        }
                    }

                    @media screen and  (min-width : 768px) and  (max-width : 1024px){
                        .rightCart{
                            width:35%;
                        }

                        .rightCartCoupon .coupon div.coupon_code{
                            width: 98%;
                        }
                        .rightCartCoupon .coupon input.coupon_code{
                            width:61%!important;
                        }
                        .rightCartCoupon .coupon .check{
                            width: 38%;
                        }
                    }
                </style>
                    <div class="rightCartOrder">
                        <label class="headerLabel">Order Summary
                            <a ng-click="editCart()" style="float: right; margin: 4px 20px 0px 0px; font-size: 13px; font-weight: 300; display: none;" href="javascript:void(0)">Edit</a>
                        </label>
                        <?php
                        $plan2=DB::select("select * from subscribe_plane where validity=365");
                        foreach($plan2 as $plan2)
                        {
                        ?>
                        <div ng-repeat="val in buyPlan |filterNavItems " class="orderItem ng-scope">
                            <div class="planItem ng-scope" ng-if="val.category=='pro'||val.category=='biz'||val.category=='education'">
                                <div ng-if="val.isYearlySelected" class="ng-scope">
                                    <label class="planTitle ng-scope" ng-if="val.category=='pro'"><?php echo $plan2->title;?></label><!-- end ngIf: val.category=='pro' -->
                                    <span class="planVal ng-binding" ng-bind="val.yearly_amount*val.selectedHost/100| currency">$<?php echo $plan2->amount;?></span>
                                </div>

                                <div class="planAttr">
                                    <label ng-if="val.isYearlySelected" class="planTitle ng-scope">
                                        <span ng-bind="(val.yearly_amount/100| currency)+'/yr/host'" class="ng-binding"></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div id="discountDiv" class="orderItem clearfix" style="display: none;">
                            <div class="planItem">
                                <label class="planTitle">Discount</label>
                                <div class="planVal discount" style="color: red;"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="orderItem">
                            <table>
                                <tbody><tr>
                                    <td class="planTitle firstColumn">Today's Charge </td>
                                    <td class="secondColumn todayTotal ng-binding" ng-bind="(todayTotalPrice()+discount)|currency">$<?php echo $plan2->amount;?></td>
                                </tr>
                                </tbody></table>
                        </div>
                        <hr>
                        <div class="payMethod">
                            <h4>
                                Charges auto-renew          </h4>
                            <p>
                                (unless cancelled before next renewal date)         </p>

                            <div class="accepted_cards">
                                <img src="/content/uploads/images/PayPal.png" style="width: 85%;">
                                <center><a href="<?php  echo '/user/' . @ucwords(Auth::user()->username) . '/renew_subscription?video_id='.$video->id.'&plan='.$plan2->id.'';?>" style="float: inherit; padding: 7px;" id="button" class="btn btn-xs btn-info">Continue</a></center>
                            </div>
                            <p>
                                All amounts shown in <strong>U.S. dollars</strong>          </p>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="or-line">
    <div class="or">OR</div>
</div>
<script>
    $(document).ready(function() {
        $('#zz').hide();
        $('#ll').click(function () {
            $(this).toggleClass('tdDiv');
            $(this).toggleClass('tdDiv selected');
            $('#l').toggleClass('tdDiv selected');
            $('#l').toggleClass('tdDiv');
            $('#z').hide();
            $('#zz').show();


        });
        $('#l').click(function () {
            $(this).toggleClass('tdDiv');
            $(this).toggleClass('tdDiv selected');
            $('#ll').toggleClass('tdDiv selected');
            $('#ll').toggleClass('tdDiv');
            $('#zz').hide();
            $('#z').show();

        });
    });
</script>