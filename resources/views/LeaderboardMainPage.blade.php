@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header')  
   @if (session('status'))
   <div class="alert alert-danger" style="text-align:center">
      {{ session('status') }}
   </div>
   @endif
   @if (session('success'))
   <div class="alert alert-success" style="text-align:center">
      {{ session('success') }}
   </div>
   @endif
   <!-- Page body content -->
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-sm-7" id="content">
            <div class="loader" style="display: none;" id="body_loader">
              <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
            </div>
            <div class="dashboard_left">
               <!-- top status section -->
               <div class="status_wrap">
                  <h3>Your Status</h3>
                  <ul class="status_content">
                     <li>
                        <h4>{{__('label.PRO')}}</h4>
                        <p>{{__('label.Level')}}</p>
                     </li>
                     <li>
                        <h4>67%</h4>
                        <p>{{__('label.Hit rate')}}</p>
                     </li>
                     <li>
                        <h4>200</h4>
                        <p>{{__('label.GramS')}}</p>
                     </li>
                     <li>
                        <h4>10</h4>
                        <p>{{__('label.Leaderboard')}}</p>
                     </li>
                  </ul>
                  <div class="clearfix"></div>
               </div>
               <!-- top status section end -->
               <!-- feed section start  -->
               <div class="all_feed_wrap">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist" id="unid">
                     <li class="{{ Request::path() == 'leaderboard' ? 'active' : '' }}" role="presentation"><a href="#leaderboard" aria-controls="leaderboard" role="tab" data-toggle="tab">{{__('label.Leaderboard')}}</a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                     <!-- Leader board start  -->
                     <div role="tabpanel" class="tab-pane {{ Request::path() == 'leaderboard' ? 'active' : '' }}" id="leaderboard">
                        <div class="Leaderboard_wrap">
                           <div class="LeaderHeader">
                              <h3>{{__('label.Leaderboard')}}</h3>
                              <div class="leaderboardFilter">
                                 <ul>
                                    <li dayamount="all_time" class="duration active" id="AllTime" value="365" onclick="LeaderboardDuration(365,'AllTime')">{{__('label.All time')}}</li>
                                    <li dayamount="60_days" class="duration" id="Sixty" value="60" onclick="LeaderboardDuration(60,'Sixty')">60 {{__('label.Days')}}</li>
                                    <li dayamount="30_days" class="duration" id="Thirty" value="30" onclick="LeaderboardDuration(30,'Thirty')">30 {{__('label.Days')}}</li>
                                    <li dayamount="7_days" class="duration" id="Seven" value="7" onclick="LeaderboardDuration(7,'Seven')">7 {{__('label.Days')}}</li>
                                 </ul>
                              </div>
                           </div>
                           <div class="leaderboard_body" id="LeaderboardDiv">
                           </div>
                        </div>
                     </div>
                     <!-- Leader board end  -->  
                  </div>
               </div>
               <!-- feed section end  -->
               <div class="clearfix"></div>
            </div>
         </div>
         <!-- rightbar part Start -->
         @include('common/rightbar')
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/footer')
@include('common/footer_link')
<script>
$(document).ready(function(){
//****************page load leaderboard data***********************//
 $.ajax({
        type: "GET",
        url: "{{url('get-all-leaderboard-data')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        //data: {''},
        success: function(result)
        {
            //console.log(result);
            $("#LeaderboardDiv").html(result);
            $(".duration").removeClass('active');
            $("#AllTime").addClass('active');
        }
   });
 //********************************************************************//
});
function LeaderboardDuration(days,DivId)
{
    if(days != 0)
    {
        //alert(days);
        $("#body_loader").show();
        $.ajax({
                type: "POST",
                url: "{{url('get-leaderboard-data-daywise')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {day:days},
                success: function(result)
                {
                    //console.log(result);
                    $("#LeaderboardDiv").html(result);
                    $(".duration").removeClass('active');
                    $("#"+DivId).addClass('active');
                    $("#body_loader").hide();
                }
       });
    }
}
function SortMyBetResult(days,DivId)
{
    if(days != 0)
    {
        //alert(days);
        $("#body_loader").show();
        var sendValue = $("#nextDataMyBet").html();
        $.ajax({
                type: "POST",
                url: "{{url('get-filtered-mybet-result')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'day':days},
                success: function(result)
                {
                    //console.log(result);
                    var leftPartMyBetData =  $($.parseHTML(result)).filter("#leftPartMyBetData");
                    var rightPartMyBetData =  $($.parseHTML(result)).filter("#rightPartMyBetData");
                    $("#leftPartAjaxMyBetData").html(leftPartMyBetData);
                    $("#rightPartAjaxMyBetData").html(rightPartMyBetData);
                    setTimeout(function() {
                         //var nextStartFrom =  $($.parseHTML(result)).find("div.nextDataAjax:last").html();
                         var nextStartFrom =  $("div.nextDataAjaxMyBet:last").html();
                         $("#nextDataMyBet").html(nextStartFrom);
                 	}, 100);
                    $(".timing").removeClass('active');
                    $("#"+DivId).addClass('active');
                    $("#body_loader").hide();
                }
       });
    }
}
</script>