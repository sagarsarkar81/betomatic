<?php
use App\soccer_league_details;
?>
@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header')
   <!-- Page body content -->
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-sm-7" id="content">
            <!-- League showing start -->

            <div class="League_show_wrap" id="LeagueList">
            <!--div class="loader" style="display: none;" id="body_loader">
              <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
            </div-->
            <!---------foreach loop---------------->
            <?php
            if(!empty($GetOddsDetails))
            {
                foreach($GetOddsDetails as $key=>$Value)
                {
                    $GetLeagueName = soccer_league_details::select('league_name')->where('league_id',$key)->get()->toArray();
            ?>
            <div class="panel panel-default League_wrap">
              <div class="panel-heading accordion-opened" role="tab" id="">
                 <h4 class="panel-title">
                    <a class="accordion-toggle" role="button" data-toggle="collapse"  href="#League<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo $GetLeagueName[0][league_name]; ?>
                    </a>
                 </h4>
              </div>
              <div id="League<?php echo $key; ?>" class="panel-collapse collapse in" role="tabpanel">
                 <div class="panel-body">
                    <div class="row">
                       <div class="match_ins">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                             <h3>Match winner</h3>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                             <ul class="League_odd_list">
                                <li>
                                   <span data-original-title="" title="">Home</span>
                                </li>
                                <li>
                                   <span data-original-title="" title="">Draw</span>
                                </li>
                                <li>
                                   <span data-original-title="" title="">Away</span>
                                </li>
                             </ul>
                          </div>
                       </div>
                       <div class="clearfix"></div>
                       <?php
                       foreach($Value as $ArrayKey=>$ArrayValue)
                       {
                       ?>
                       <div class="match_holder">
                          <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                             <div class="match_title_time">
                                <span class="pre_match_time" data-original-title="" title=""><?php echo $EventTime = date("Y/m/d H:i",strtotime($ArrayValue[event_date])); ?></span>
                                <span class="pre_match_title" title="" data-original-title="<?php echo $ArrayValue[home_team] .'|'. $ArrayValue[away_team]; ?>"><?php echo $ArrayValue[home_team] .'|'. $ArrayValue[away_team]; ?></span>
                             </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                             <ul class="League_odd_list">
                                <li><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $ArrayValue[match_id]; ?>" BetFor="Home"><?php echo $ArrayValue[odds_home]; ?></a></li>
                                <li><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $ArrayValue[match_id]; ?>" BetFor="Draw"><?php echo $ArrayValue[odds_draw]; ?></a></li>
                                <li><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $ArrayValue[match_id]; ?>" BetFor="Away"><?php echo $ArrayValue[odds_away]; ?></a></li>
                             </ul>
                             <div class="Match_activity">
                                <span class="result_score_h2h" data-original-title="" title="">
                                <a data-toggle="modal" href="#headtohdad" class="btn btn-primary"  data-original-title="" title="">
                                <i class="fa fa-bar-chart" aria-hidden="true" data-original-title="" title=""></i>
                                </a>
                                </span>
                             </div>
                          </div>
                          <div class="clearfix"></div>
                       </div>
                       <?php
                       }
                       ?>
                    </div>
                 </div>
              </div>
            </div>
            <?php
                }
            }
            ?>
            <!-------------------------------------->
            </div>
            <!-- League showing end -->
         </div>
         <!-- rightbar part Start -->
         @include('common/rightbar')
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
<!-- Modal -->
<div id="headtohdad" data-easein="expandIn" class="modal fade headtohead_modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal">×</button>
            <h4 class="modal-title">Head To Head</h4>
         </div>
         <div class="modal-body">
            <div class="head2head_chat col-md-10 col-md-offset-1">
               <div class="chat_one">
                  <h3>Previous Meetings</h3>
                  <div id="chartdiv5"></div>
               </div>
               <div class="chat_one">
                  <h3>Statistic for Home and Away</h3>
                  <div id="chartdiv"></div>
               </div>
               <div class="chat_one">
                  <h3>Latest matches: Home</h3>
                  <div id="chartdiv1"></div>
               </div>
               <div class="chat_one">
                  <h3>Statistic for Home and Away</h3>
                  <div id="chartdiv2"></div>
               </div>
               <div class="chat_one">
                  <h3>Statistic Total Goals for Home and Away</h3>
                  <div id="chartdiv3"></div>
               </div>
               <div class="chat_one">
                  <h3>OverAll</h3>
                  <div id="chartdiv4"></div>
               </div>
               <br/>
               <br/>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</div>
@include('common/footer')
@include('common/footer_link')
<script type="text/javascript">
   $(document.body).on('click','.panel-heading',function(){
       if($(this).hasClass('accordion-opened')){
         $(this).removeClass('accordion-opened');
       }
       else{
          $(this).addClass('accordion-opened');
       }
   });
</script>
<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<!-- Chart code -->
<script>
   var chart = AmCharts.makeChart( "chartdiv", {
     "type": "serial",
     "addClassNames": true,
     "theme": "light",
     "autoMargins": false,
     "marginLeft": 30,
     "marginRight": 8,
     "marginTop": 10,
     "marginBottom": 26,
     "balloon": {
       "adjustBorderColor": false,
       "horizontalPadding": 10,
       "verticalPadding": 8,
       "color": "#ffffff"
     },
     "dataProvider": [ {
       "year": 2009,
       "income": 23.5,
       "expenses": 21.1
     }, {
       "year": 2010,
       "income": 26.2,
       "expenses": 30.5
     }, {
       "year": 2011,
       "income": 30.1,
       "expenses": 34.9
     }, {
       "year": 2012,
       "income": 29.5,
       "expenses": 31.1
     }, {
       "year": 2013,
       "income": 30.6,
       "expenses": 28.2,
       "dashLengthLine": 5
     }, {
       "year": 2014,
       "income": 34.1,
       "expenses": 32.9,
       "dashLengthColumn": 5,
       "alpha": 0.2,
       "additional": "(projection)"
     } ],
     "valueAxes": [ {
       "axisAlpha": 0,
       "position": "left"
     } ],
     "startDuration": 1,
     "graphs": [ {
       "alphaField": "alpha",
       "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
       "fillAlphas": 1,
       "title": "Income",
       "type": "column",
       "valueField": "income",
       "dashLengthField": "dashLengthColumn"
     }, {
       "id": "graph2",
       "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
       "bullet": "round",
       "lineThickness": 3,
       "bulletSize": 7,
       "bulletBorderAlpha": 1,
       "bulletColor": "#FFFFFF",
       "useLineColorForBulletBorder": true,
       "bulletBorderThickness": 3,
       "fillAlphas": 0,
       "lineAlpha": 1,
       "title": "Expenses",
       "valueField": "expenses",
       "dashLengthField": "dashLengthLine"
     } ],
     "categoryField": "year",
     "categoryAxis": {
       "gridPosition": "start",
       "axisAlpha": 0,
       "tickLength": 0
     },
   } );
</script>
<!-- Chart code 1 -->
<script>
   var chart = AmCharts.makeChart("chartdiv1", {
       "theme": "light",
       "type": "serial",
       "dataProvider": [{
           "country": "USA",
           "year2004": 3.5,
           "year2005": 4.2
       }, {
           "country": "UK",
           "year2004": 1.7,
           "year2005": 3.1
       }, {
           "country": "Canada",
           "year2004": 2.8,
           "year2005": 2.9
       }, {
           "country": "Japan",
           "year2004": 2.6,
           "year2005": 2.3
       }, {
           "country": "France",
           "year2004": 1.4,
           "year2005": 2.1
       }, {
           "country": "Brazil",
           "year2004": 2.6,
           "year2005": 4.9
       }, {
           "country": "Russia",
           "year2004": 6.4,
           "year2005": 7.2
       }, {
           "country": "India",
           "year2004": 8,
           "year2005": 7.1
       }, {
           "country": "China",
           "year2004": 9.9,
           "year2005": 10.1
       }],
       "valueAxes": [{
           "stackType": "3d",
           "unit": "%",
           "position": "left",
           "title": "GDP growth rate",
       }],
       "startDuration": 1,
       "graphs": [{
           "balloonText": "GDP grow in [[category]] (2004): <b>[[value]]</b>",
           "fillAlphas": 0.9,
           "lineAlpha": 0.2,
           "title": "2004",
           "type": "column",
           "valueField": "year2004"
       }, {
           "balloonText": "GDP grow in [[category]] (2005): <b>[[value]]</b>",
           "fillAlphas": 0.9,
           "lineAlpha": 0.2,
           "title": "2005",
           "type": "column",
           "valueField": "year2005"
       }],
       "plotAreaFillAlphas": 0.1,
       "depth3D": 60,
       "angle": 30,
       "categoryField": "country",
       "categoryAxis": {
           "gridPosition": "start"
       },
   });
   jQuery('.chart-input').off().on('input change',function() {
     var property  = jQuery(this).data('property');
     var target    = chart;
     chart.startDuration = 0;
     if ( property == 'topRadius') {
       target = chart.graphs[0];
           if ( this.value == 0 ) {
             this.value = undefined;
           }
     }
     target[property] = this.value;
     chart.validateNow();
   });
</script>
<!-- Chart code 2 -->
<script>
   var chart = AmCharts.makeChart("chartdiv2", {
     "type": "serial",
        "theme": "light",
     "categoryField": "year",
     "rotate": true,
     "startDuration": 1,
     "categoryAxis": {
       "gridPosition": "start",
       "position": "left"
     },
     "trendLines": [],
     "graphs": [
       {
         "balloonText": "Income:[[value]]",
         "fillAlphas": 0.8,
         "id": "AmGraph-1",
         "lineAlpha": 0.2,
         "title": "Income",
         "type": "column",
         "valueField": "income"
       },
       {
         "balloonText": "Expenses:[[value]]",
         "fillAlphas": 0.8,
         "id": "AmGraph-2",
         "lineAlpha": 0.2,
         "title": "Expenses",
         "type": "column",
         "valueField": "expenses"
       }
     ],
     "guides": [],
     "valueAxes": [
       {
         "id": "ValueAxis-1",
         "position": "top",
         "axisAlpha": 0
       }
     ],
     "allLabels": [],
     "balloon": {},
     "titles": [],
     "dataProvider": [
       {
         "year": 2005,
         "income": 23.5,
         "expenses": 18.1
       },
       {
         "year": 2006,
         "income": 26.2,
         "expenses": 22.8
       },
       {
         "year": 2007,
         "income": 30.1,
         "expenses": 23.9
       },
       {
         "year": 2008,
         "income": 29.5,
         "expenses": 25.1
       },
       {
         "year": 2009,
         "income": 24.6,
         "expenses": 25
       }
     ],
   });
</script>
<!-- Chart code 3 -->
<script>
   var chart = AmCharts.makeChart("chartdiv3", {
       "type": "serial",
     "theme": "light",
       "legend": {
           "horizontalGap": 10,
           "maxColumns": 1,
           "position": "right",
       "useGraphSettings": true,
       "markerSize": 10
       },
       "dataProvider": [{
           "year": 2003,
           "europe": 2.5,
           "namerica": 2.5,
           "asia": 2.1,
           "lamerica": 0.3,
           "meast": 0.2,
           "africa": 0.1
       }, {
           "year": 2004,
           "europe": 2.6,
           "namerica": 2.7,
           "asia": 2.2,
           "lamerica": 0.3,
           "meast": 0.3,
           "africa": 0.1
       }, {
           "year": 2005,
           "europe": 2.8,
           "namerica": 2.9,
           "asia": 2.4,
           "lamerica": 0.3,
           "meast": 0.3,
           "africa": 0.1
       }],
       "valueAxes": [{
           "stackType": "regular",
           "axisAlpha": 0.5,
           "gridAlpha": 0
       }],
       "graphs": [{
           "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
           "fillAlphas": 0.8,
           "labelText": "[[value]]",
           "lineAlpha": 0.3,
           "title": "Europe",
           "type": "column",
       "color": "#000000",
           "valueField": "europe"
       }, {
           "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
           "fillAlphas": 0.8,
           "labelText": "[[value]]",
           "lineAlpha": 0.3,
           "title": "North America",
           "type": "column",
       "color": "#000000",
           "valueField": "namerica"
       }, {
           "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
           "fillAlphas": 0.8,
           "labelText": "[[value]]",
           "lineAlpha": 0.3,
           "title": "Asia-Pacific",
           "type": "column",
       "color": "#000000",
           "valueField": "asia"
       }, {
           "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
           "fillAlphas": 0.8,
           "labelText": "[[value]]",
           "lineAlpha": 0.3,
           "title": "Latin America",
           "type": "column",
       "color": "#000000",
           "valueField": "lamerica"
       }, {
           "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
           "fillAlphas": 0.8,
           "labelText": "[[value]]",
           "lineAlpha": 0.3,
           "title": "Middle-East",
           "type": "column",
       "color": "#000000",
           "valueField": "meast"
       }, {
           "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
           "fillAlphas": 0.8,
           "labelText": "[[value]]",
           "lineAlpha": 0.3,
           "title": "Africa",
           "type": "column",
       "color": "#000000",
           "valueField": "africa"
       }],
       "rotate": true,
       "categoryField": "year",
       "categoryAxis": {
           "gridPosition": "start",
           "axisAlpha": 0,
           "gridAlpha": 0,
           "position": "left"
       },
   });
</script>
<!-- Chart code 4 -->
<script>
   var chart = AmCharts.makeChart("chartdiv4",
   {
       "type": "serial",
       "theme": "light",
       "dataProvider": [{
           "name": "John",
           "points": 35654,
           "color": "#7F8DA9",
           "bullet": "https://www.amcharts.com/lib/images/faces/A04.png"
       }, {
           "name": "Damon",
           "points": 65456,
           "color": "#FEC514",
           "bullet": "https://www.amcharts.com/lib/images/faces/C02.png"
       }, {
           "name": "Patrick",
           "points": 45724,
           "color": "#DB4C3C",
           "bullet": "https://www.amcharts.com/lib/images/faces/D02.png"
       }, {
           "name": "Mark",
           "points": 13654,
           "color": "#DAF0FD",
           "bullet": "https://www.amcharts.com/lib/images/faces/E01.png"
       }],
       "valueAxes": [{
           "maximum": 80000,
           "minimum": 0,
           "axisAlpha": 0,
           "dashLength": 4,
           "position": "left"
       }],
       "startDuration": 1,
       "graphs": [{
           "balloonText": "<span style='font-size:13px;'>[[category]]: <b>[[value]]</b></span>",
           "bulletOffset": 10,
           "bulletSize": 52,
           "colorField": "color",
           "cornerRadiusTop": 8,
           "customBulletField": "bullet",
           "fillAlphas": 0.8,
           "lineAlpha": 0,
           "type": "column",
           "valueField": "points"
       }],
       "marginTop": 0,
       "marginRight": 0,
       "marginLeft": 0,
       "marginBottom": 0,
       "autoMargins": false,
       "categoryField": "name",
       "categoryAxis": {
           "axisAlpha": 0,
           "gridAlpha": 0,
           "inside": true,
           "tickLength": 0
       },
   });
</script>
<!-- Chart code 5 -->
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script>
   var chart = AmCharts.makeChart( "chartdiv5", {
     "type": "pie",
     "theme": "light",
     "dataProvider": [ {
       "country": "Lithuania",
       "litres": 501.9
     }, {
       "country": "UK",
       "litres": 99
     }, {
       "country": "Belgium",
       "litres": 60
     }, {
       "country": "The Netherlands",
       "litres": 50
     } ],
     "valueField": "litres",
     "titleField": "country",
      "balloon":{
      "fixedPosition":true
     },
   } );
$(document).ready(function(){
    $("#BetComments").val('');
    /*$("#body_loader").show();
    $.ajax({
        type: "GET",
        url: "{{url('soccer-odds-loading-page')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: '',
        success: function(result)
        {
            //console.log(result);
            $("#LeagueList").html(result);
            $("#body_loader").hide();
        }
    });*/
});
$(".PlaceInBetSlip").click(function(){
    var MatchId = $(this).attr("MatchId");
    var BetFor = $(this).attr("BetFor");
    var UniqueId = $(this).attr("id");
    if($("#"+UniqueId).hasClass('active'))
    {
        $("#"+UniqueId).removeClass('active');
        RemoveBetSlip(UniqueId);
    }
    else{
        $("#"+UniqueId).addClass('active');
        //$("#body_loader").show();
        $.ajax({
            type: "POST",
            url: "{{url('CheckOdds')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'MatchId':MatchId,'BetFor':BetFor,'UniqueId':UniqueId},
            success: function(result)
            {
                //console.log(result);
                $("#EmptyBetSlip").html('');
                $("#BetSlip").append(result);
                $("#BetComments").prop('disabled', false);
                //$("#PlaceBet").css('pointer-events','auto');
                $(".BetStake").each(function(){
                    var CheckStakeInput = $(this).val();
                    //alert(CheckStakeInput);
                    if(CheckStakeInput == '')
                    {
                        $("#PlaceBet").css('pointer-events','none');
                    }
                });
                //$("#body_loader").hide();
            }
        });
    }

});
function RemoveBetSlip(BetslipId)
{
   if(BetslipId != '')
   {
        $("#whole_slip"+BetslipId).remove();
        $("#"+BetslipId).removeClass('active');
        $.ajax({
            type: "POST",
            url: "{{url('Remove-Odds-From-Session')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'BetSlipId':BetslipId},
            success: function(result)
            {
                if($(".bet_slip_content").length==0){
                    $("#EmptyBetSlip").html('<p>Your Bet Slip Empty</p>');
                    $("#BetComments").prop('disabled', true);
                    $("#PlaceBet").css('pointer-events','none');
                }else{
                    $("#PlaceBet").css('pointer-events','auto');
                }
                //console.log(result);
            }
        });
   }
}


function BetStakeAmount(StakeAmount,UniqueId,OddsValue,OddsType)
{
    /*alert(StakeAmount);
    alert(UniqueId);
    alert(OddsValue);*/
     var count=0;
    $(".BetStake").each(function(){
            var CheckStakeInput = $(this).val();
            //alert(CheckStakeInput);
            if(CheckStakeInput == '')
            {
               count++;
                //$("#PlaceBet").css('pointer-events','none');
            }
        });
       if(count==0){
        $("#PlaceBet").css('pointer-events','auto');
       }
       else{
        //return;
        $("#PlaceBet").css('pointer-events','none');
       }
    if(StakeAmount !='')
    {
        $.ajax({
            type: "POST",
            url: "{{url('Stake-Value')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'StakeAmount':StakeAmount,'UniqueId':UniqueId,'OddsValue':OddsValue,'OddsType':OddsType},
            success: function(result)
            {
                //console.log(result);
            }
        });
        var PaymentReturn = parseInt(OddsValue * StakeAmount);
        $("#Payment"+UniqueId).html('Payment : '+PaymentReturn);
       // $("#PlaceBet").css('pointer-events','auto');
    }else{
        $(".BetStake").each(function(){
            var CheckStakeInput = $(this).val();
            //alert(CheckStakeInput);
            if(CheckStakeInput == '')
            {
                $("#PlaceBet").css('pointer-events','none');
            }
        });
        //$("#PlaceBet").css('pointer-events','none');
    }
}
function PlaceBet()
{
    //alert($(".BetStake").length);

    if($("#BetStake").val() != '')
    {
        var BetComments = $("#BetComments").val();
        var PrivacySettings = $("#PrivacySettings").val();
        $.ajax({
                type: "POST",
                url: "{{url('Place-Bet')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'BetComments':BetComments,'PrivacySettings':PrivacySettings},
                success: function(result)
                {
                    //console.log(result);
                    location.reload();
                }
        });
    }
}
function RemoveTotalBetSlip()
{
    $.ajax({
            type: "GET",
            url: "{{url('remove-total-betslip')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //data: {'BetSlipId':BetslipId},
            success: function(result)
            {
                if(result == 'success')
                {
                    $("#BetSlip").html('');
                    $(".PlaceInBetSlip").removeClass('active');
                    $("#EmptyBetSlip").html('<p>Your Bet Slip Empty</p>');
                    $("#BetComments").prop('disabled', true);
                    $("#PlaceBet").css('pointer-events','none');
                }
            }
        });
}
</script>
