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
                        <h3>Top Countries</h3>
                        <ul>
                           @foreach($countryCode as $key=>$value)
                           <li>
                              <a href="javascript:void(0)" onclick="MoveToSelectedLeague({{ $value->countryCode }})">
                              <span  class="flag-icon flag-icon-{{ strtolower($value->countryCode) }}"></span> {{ countryCodeToCountry($value->countryCode) }}
                              </a>
                           </li>
                           @endforeach
                        </ul>
                     </div>
                  </div>
                  <!-- choose league -->
                  <!-- choose league -->
                  <div class="col-md-8 col-sm-12">
                     <div class="Select_odds">
                        <select>
                           <option>Odds from Bet 365</option>
                           <option>Odds from Bet 365</option>
                           <option>Odds from Bet 365</option>
                        </select>
                     </div>
                     <div class="clearfix"></div>
                     @foreach($eventByCountry as $leagueId=>$matches)
                     <div class="panel panel-default League_wrap">
                        <div class="panel-heading accordion-opened" role="tab" id="">
                           <h4 class="panel-title">
                              <a class="accordion-toggle" role="button" data-toggle="collapse" href="#League" aria-expanded="true" aria-controls="collapseOne">
                              <span  class="flag-icon flag-icon-{{ strtolower($matches[0]->event->countryCode) }}"></span>   {{ countryCodeToCountry($matches[0]->event->countryCode) }} - {{ $competitions[$leagueId] }}
                              </a>
                           </h4>
                        </div>
                        <div id="League" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                           <div class="panel-body">
                              @foreach($matches as $matchKey=>$matchValue)
                              @isset($marketDetails[$matchValue->event->id])
                                 @php 
                                  $matchDetails = $marketDetails[$matchValue->event->id][0];
                                 @endphp
                                  <div class="match_holder">
                                    <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                                        <div class="match_title_time"> 
                                          <span class="pre_match_time" data-original-title="" title="">1396/07/01 15:00</span>
                                          <span class="pre_match_title" title="" data-original-title="{{ $matchDetailsValue[0]->runnerDetails[0]->selectionName }} | Tottenham">
                                          <a href="#">{{ $matchDetails->runnerDetails[0]->selectionName }} | {{ $matchDetails->runnerDetails[2]->selectionName }}</a></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                                        <ul class="League_odd_list">
                                          <li><a id="" href="javascript:void(0);" data-original-title="" title="">{{ number_format($matchDetails->runnerDetails[0]->winRunnerOdds->decimal,2) }}</a></li>
                                          <li><a id="" href="javascript:void(0);" data-original-title="" title="">{{ number_format($matchDetails->runnerDetails[1]->winRunnerOdds->decimal,2) }}</a></li>
                                          <li><a id="" href="javascript:void(0);" data-original-title="" title="">{{ number_format($matchDetails->runnerDetails[2]->winRunnerOdds->decimal,2) }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                  </div>
                                  
                              @endisset
                              @endforeach
                           </div>
                        </div>
                     </div>
                     @endforeach
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