@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header')
   <!-- Page body content -->
   <div class="container Leagues_by_league">
      <div class="row">
         <div class="col-md-12 game_heading">
            <h3><img width="25px" src="{{asset('assets/front_end/images/game_list/soccer.png')}}" alt=""> {{__('label.Soccer')}}</h3>
         </div>
         <div class="col-md-12 col-sm-12">
            <div class="loader" style="display: none;" id="body_loader">
                <img src="{{asset('assets/front_end/images/spinner.gif')}}"/>
            </div>
            <div class="row">
               <div class="league_wrap">
                  <!-- choose league -->
                  <div class="col-md-3 col-sm-12">
                     <div class="form-group league_calendar ">
                        <div class="datepicker" data-date=""></div>
                     </div>
                     <div class="top_league_wrap">
                        <h3>Top Leagues</h3>
                        <ul>
                           @foreach($competitions as $key=>$value)
                            <li><a href="javascript:void(0)" onclick="MoveToSelectedLeague({{ $value->competition->id }})">{{ $value->competition->name }}</a></li>
                           @endforeach
                        </ul>
                     </div>
                  </div>
                  <!-- choose league -->
                  <!-- choose league -->
                  <div class="col-md-9 col-sm-12">
                     <div class="clearfix"></div>
                     <div id="DataImport">
                        <div class="panel panel-default League_wrap">
                           <?php
                              if(!empty($leagues))
                              {
                                foreach($leagues as $key=>$value)
                                {
                                  if(!empty($LeagueWiseMatch))
                                  {
                                    foreach($LeagueWiseMatch as $matchkey=>$matchValue)
                                    {
                                      if($matchkey == $key)
                                      {
                              ?>
                           <div class="panel-heading accordion-opened" role="tab" id="">
                              <h4 class="panel-title">
                                 <a class="accordion-toggle" role="button" data-toggle="collapse" href="#League<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseOne">
                                 <img src="" />   <?php echo $value['country_name']; ?> - <?php echo $value['league_name']; ?>
                                 </a>
                              </h4>
                           </div>
                           <div id="League<?php echo $matchkey; ?>" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                              <div class="panel-body">
                                 <?php foreach($matchValue as $leagueKey=>$leagueValue) { 
                                    $UniqueKey = $leagueValue[0]['match_id'].'-'.'Full time';
                                    ?>
                                 <div class="match_holder">
                                    <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                                       <div class="match_title_time">
                                          <span class="pre_match_time" data-original-title="" title=""><?php echo date("Y/m/d h:i",strtotime($leagueValue[0]['match_time'])); ?></span>
                                          <span class="pre_match_title" title="" data-original-title="West Ham | Tottenham">
                                          <a data-toggle="tooltip" href="{{url('move-to-extra-odd-page')}}/<?php echo $leagueValue[0]['match_id']; ?>/<?php echo $leagueValue[0]['odd_bookmakers']; ?>"  title="<?php echo $leagueValue[0]['match_hometeam_name']; ?> | <?php echo $leagueValue[0]['match_awayteam_name']; ?>">
                                          <?php
                                             if(strlen($leagueValue[0]['match_hometeam_name']) > 10)
                                             {
                                               echo substr($leagueValue[0]['match_hometeam_name'],0,10)."...";
                                             } else{
                                               echo $leagueValue[0]['match_hometeam_name'];
                                             }
                                             ?> |
                                          <?php
                                             if(strlen($leagueValue[0]['match_awayteam_name']) > 10)
                                             {
                                               echo substr($leagueValue[0]['match_awayteam_name'],0,10)."...";
                                             } else{
                                               echo $leagueValue[0]['match_awayteam_name'];
                                             }
                                             ?>
                                          </a>
                                          </span>
                                       </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                                       <ul class="League_odd_list">
                                          <li><span>1</span><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip <?= in_array($UniqueKey.'-'.'Home',Session::get('BetSlipExtraData')) ? 'active': '';?>" MatchId="<?php echo $leagueValue[0]['match_id']; ?>" BetFor="Home" Bookmaker="<?php echo $leagueValue[0]['odd_bookmakers']; ?>" MatchTime="<?php echo $leagueValue[0]['match_time']; ?>" BetType="Full time"><?php echo $leagueValue[0]['odds_value']; ?></a></li>
                                          <li><span>X</span><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip <?= in_array($UniqueKey.'-'.'Draw',Session::get('BetSlipExtraData')) ? 'active': '';?>" MatchId="<?php echo $leagueValue[0]['match_id']; ?>" BetFor="Draw" Bookmaker="<?php echo $leagueValue[0]['odd_bookmakers']; ?>" MatchTime="<?php echo $leagueValue[0]['match_time']; ?>" BetType="Full time"><?php echo $leagueValue[1]['odds_value']; ?></a></li>
                                          <li><span>2</span><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip <?= in_array($UniqueKey.'-'.'Away',Session::get('BetSlipExtraData')) ? 'active': '';?>" MatchId="<?php echo $leagueValue[0]['match_id']; ?>" BetFor="Away" Bookmaker="<?php echo $leagueValue[0]['odd_bookmakers']; ?>" MatchTime="<?php echo $leagueValue[0]['match_time']; ?>" BetType="Full time"><?php echo $leagueValue[2]['odds_value']; ?></a></li>
                                       </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                                 <?php } ?>
                              </div>
                           </div>
                           <?php
                              }
                              }
                              }
                              }
                              } else {
                              ?>
                           <div class="no_data">
                             <img width="50px" src="{{asset('assets/front_end/images/warning.svg')}}"/>
                             Sorry! No data found...
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                     
                  </div>
                  <!-- choose league -->
                  <div class="clearfix"></div>
               </div>
            </div>
         </div> 
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/betting_slip')
@include('common/footer')
@include('common/footer_link')
<link rel="stylesheet" type="text/css" href="{{asset('assets/front_end/css/bootstrap-datetimepicker.min.css')}}">
<script src="{{asset('assets/front_end/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
   $(function () {
      //$('.datepicker').datepicker('show');
      var dateToday = new Date();
      $('.datepicker').datepicker({ 
        startDate: dateToday+7
      });
      /*$(".datepicker").on("changeDate", function(event) {
      });*/
    });
    //$('.datepicker').data('datepicker').hide = function () {};
</script>
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
<script>
$(document).ready(function(){
    $("#EmptyBetSlipAccu").show();
    $("#BetComments").val('');
    //$("#BetComments").prop('disabled', true);
    $(".Comments").prop('disabled', true);
    $("#PlaceBet").css('pointer-events','none');
    $("#AccumulatorId").css('pointer-events','none');
    SelectPrivacy('Public');
    SelectPrivacyForAccumulator('Public');
    PageLoadCheckSession();
    SetFeaturedMatch();
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
function GetBookmakerName(BookmakerName)
{
 if(BookmakerName != '')
 {
   $("#body_loader").show();
   $.ajax({
       type: "POST",
       url: "{{url('get-data-according-to-bookmaker')}}",
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       data: {'BookmakerName':BookmakerName},
       success: function(result)
       {
           //console.log(result);
           $("#DataImport").html('');
           $("#DataImport").html(result);
           $("#body_loader").hide();
       }
   });
 }
}
</script>