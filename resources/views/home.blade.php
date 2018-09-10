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

            <div class="dashboard_left">
               <!-- top status section -->
               <div class="status_wrap">
                  <h3>{{__('label.Your Status')}}</h3>
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
                     <li class="{{ Request::path() == 'home' ? 'active' : '' }}" role="presentation"><a href="#news_feed" onclick="NeswFeedFunction()" aria-controls="news_feed" role="tab" data-toggle="tab">{{__('label.News Feed')}}</a></li>
                     <li class="{{ Request::path() == 'mybet' ? 'active' : '' }} mybet" id="MyBetTab" role="presentation"><a href="#bets" aria-controls="bets" role="tab" data-toggle="tab" onclick="MyBetFunctionTab()">{{__('label.My Bets')}} <!--span class="add_match"></span--></a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane {{ Request::path() == 'home' ? 'active' : '' }}" id="news_feed">
                        <div style="display: none;" id="nextData">0</div>
                        
                        <div class="row" id="ajaxData">
                        
                          <div class="desktop_feed">
                               <div class="no_bet empty_feed" style="display: block;" id="EmptyBetSlipId">
                                 <img src="{{asset('assets/front_end/images/empty.svg')}}"/>
                                 <h3>Sorry! you have no Feeds...</h3>
                               </div>
                               <div class="feed_loader" style="display: none;" id="body_loader">
                                  <img src="{{asset('assets/front_end/images/spinner.gif')}}"/>
                               </div>
                               <div class="col-md-6" id="leftPartAjaxData">
                               </div>
                               <div class="col-md-6" id="rightPartAjaxData">
                               </div>
                               <div class="clearfix"></div>
                                 <div class="feed_loader" style="display: none;" id="body_loader_scroll">
                                  <img src="{{asset('assets/front_end/images/spinner.gif')}}"/>
                                 </div>
                               <div class="clearfix"></div>
                          </div>
                        <div class="responsive_feed" id="ResponsiveFeed" style="display: none;">
                        </div>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane {{ Request::path() == 'mybet' ? 'active' : '' }}" id="bets">
                        <div class="Leaderboard_wrap">
                           <div class="LeaderHeader">
                              <h3>{{__('label.My Bets')}}</h3>
                              <div class="leaderboardFilter">
                                 <ul>
                                    <li dayamount="all_time" class="timing active" id="BetAllTime" value="365" onclick="SortMyBetResult(365,'BetAllTime')">{{__('label.All time')}}</li>
                                    <li dayamount="60_days" class="timing" id="BetSixty" value="60" onclick="SortMyBetResult(60,'BetSixty')">60 {{__('label.Days')}}</li>
                                    <li dayamount="30_days" class="timing" id="BetThirty" value="30" onclick="SortMyBetResult(30,'BetThirty')">30 {{__('label.Days')}}</li>
                                    <li dayamount="7_days" class="timing" id="BetSeven" value="7" onclick="SortMyBetResult(7,'BetSeven')">7 {{__('label.Days')}}</li>
                                 </ul>
                              </div>
                           </div>
                           <div style="display: none;" id="nextDataMyBet">0</div>
                            <div class="row" id="">
                                <div class="desktop_feed">
                                    <div class="no_bet empty_feed" style="display: block;" id="EmptyBetSlipMybet">
                                     <img src="{{asset('assets/front_end/images/empty.svg')}}"/>
                                     <h3>Sorry! you have no Feeds...</h3>
                                    </div>
                                <div class="col-md-6" id="leftPartAjaxMyBetData">
                                </div>
                                <div class="col-md-6" id="rightPartAjaxMyBetData">
                                </div>
                                <div class="feed_loader" style="display: none;" id="body_loader_mybet">
                                 <img src="{{asset('assets/front_end/images/spinner.gif')}}"/>
                                </div>
                                <div class="clearfix"></div>
                                </div>
                            <div class="responsive_feed" id="ResponsiveFeedMyBet" style="display: none;">
                            </div>
                            </div>
                        </div>
                     </div>
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
<!---modal for report abuse----->
<!--div id="report_abuse" data-easein="expandIn" class="registration_modal modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="loader" style="display: none;" id="modal_loader_report">
        <img src="http://betogram.com/assets/front_end/images/loading.gif"/>
    </div>

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Why You are Reporting this Post ?</h4>
      </div>
      <div class="modal-body">
       <form class="col-md-8 col-md-offset-2" id="SubmitReportForm" action="javascript:void(0);" autocomplete="off" enctype="multipart/form-data">
        <div class="form-group">
           <select class="selectpicker validate[required] ReportSelect" id="report" name="report" data-live-search="true">
               <option value="">Select</option>
               <?php
               if(!empty($GetReportItems))
               {
                    foreach($GetReportItems as $ReportItems)
                    {
               ?>
               <option value="<?php echo $ReportItems[id];?>"><?php echo $ReportItems[type_name];?></option>
               <?php
                    }
               }
               ?>
           </select>
        </div>
        <input name="postId" id="postId" value="" type="hidden"/>
        <button class="report_abuse_button" type="submit" class="btn"  id="SubmitReport">Save</button>
       </form>
       <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div-->
<!------------------------------->
<!---modal for privacy----->
<div id="Privacy" data-easein="expandIn" class="registration_modal modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="loader" style="display: none;" id="modal_loader_privacy">
        <img src="http://betogram.com/assets/front_end/images/loading.gif"/>
    </div>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Privacy Settings</h4>
      </div>
      <div class="modal-body">
       <form class="col-md-8 col-md-offset-2" id="SubmitPrivacyForm" action="javascript:void(0);" autocomplete="off" enctype="multipart/form-data">
        <div class="form-group" id="SettingsPrivacy">
        </div>
        <input name="postId2" id="postId2" value="" type="hidden"/>
        <button class="report_abuse_button" type="submit" class="btn"  id="SubmitPrivacy">Save</button>
       </form>
       <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<!-- ................................. -->
@include('common/footer')
@include('common/footer_link')

<script>
    var NewsFeed = 0;
    var MyBet = 0;
   $(document).ready(function(){
       $(document).scrollTop();
       setTimeout(function() {
       $('.alert-danger').fadeOut('fast');
             $('.alert-success').fadeOut('fast');
       }, 4000);
       NeswFeedFunction();
       SetFeaturedMatch();
   });
   function NeswFeedFunction()
   {
      var sendValue = $("#nextData").html();
         if(sendValue == 0)
         {
             $("#body_loader").show();
             $.ajax({
                 type: "POST",
                 async: false,
                 url: "{{url('display-block')}}",
                 headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 data: {'sendValue':sendValue},
                 success: function(result)
                 {
                     //console.log(result);
                     if(result == 'false')
                     {
                        $("#EmptyBetSlipId").show();
                     }else{
                        $("#EmptyBetSlipId").hide();
                        var leftPartData =  $($.parseHTML(result)).filter("#leftPartData");
                        var rightPartData =  $($.parseHTML(result)).filter("#rightPartData");
                        $("#leftPartAjaxData").html(leftPartData);
                        $("#rightPartAjaxData").html(rightPartData);
                        setTimeout(function() {
                             //var nextStartFrom =  $($.parseHTML(result)).find("div.nextDataAjax:last").html();
                             var nextStartFrom =  $("div.nextDataAjax:last").html();
                             $("#nextData").html(nextStartFrom);
                        }, 100);
                     }
                 }
             });
             $.ajax({
                 type: "POST",
                 async: false,
                 url: "{{url('display-block-responsive')}}",
                 headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 data: {'sendValue':sendValue},
                 success: function(result)
                 {
                     //console.log(result);
                     //-----------------------------//
                     if(result == 'false')
                     {
                        $("#EmptyBetSlipId").show();
                     }else{
                         $("#EmptyBetSlipId").hide();
                         $("#ResponsiveFeed").html(result);
                     }
                     //-----------------------------//
                 }
             });
         }
         if($("#report").val() == '')
         {
            $("#SubmitReport").css('pointer-events','none');
         }
         //--------------------------------------------------------------//
         $("#body_loader").hide();
   }
   /**************My bet********************************************/
   function MyBetFunctionTab()
   {
         var sendValue = $("#nextDataMyBet").html();
         if(sendValue == 0)
         {
            $.ajax({
               type: "POST",
               async: false,
               url: "{{url('my-bet-block')}}",
               headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: {'sendValue':sendValue},
               success: function(result)
               {
                   //console.log(result);
                   if(result == 'false')
                   {
                      $("#EmptyBetSlipId").show();
                   }else{
                      $("#EmptyBetSlipId").hide();
                       var leftPartMyBetData =  $($.parseHTML(result)).filter("#leftPartMyBetData");
                       var rightPartMyBetData =  $($.parseHTML(result)).filter("#rightPartMyBetData");
                       $("#leftPartAjaxMyBetData").html(leftPartMyBetData);
                       $("#rightPartAjaxMyBetData").html(rightPartMyBetData);
                       setTimeout(function() {
                           //var nextStartFrom =  $($.parseHTML(result)).find("div.nextDataAjax:last").html();
                           var nextStartFrom =  $("div.nextDataAjaxMyBet:last").html();
                           $("#nextDataMyBet").html(nextStartFrom);
                        }, 100);
                    }
               }
          });
          //alert(sendValue);
          $.ajax({
               type: "POST",
               async: false,
               url: "{{url('my-bet-block-responsive')}}",
               headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: {'sendValue':sendValue},
               success: function(result)
               {
                   //console.log(result);
                   //-----------------------------//
                   if(result == 'false')
                   {
                       $("#EmptyBetSlipMybet").show();
                   }else{
                       $("#EmptyBetSlipMybet").hide();
                       $("#ResponsiveFeedMyBet").html(result);
                   }
                   //-----------------------------//
               }
          });
        }
   }
    /****************************************************************/
   $("#report").on("change", function(){
        var Value = $("#report").val();
        if(Value != '')
        {
            $("#SubmitReport").css('pointer-events','auto');
        }else{
            $("#SubmitReport").css('pointer-events','none');
        }
   });
   var flag = true;
   $(window).scroll(function() {
    var x = document.documentElement.clientHeight + $(document).scrollTop();
    var y = document.body.offsetHeight;
    //flag = true;
    if (x == y && (flag))
     {
        flag = false;
         var SelectedTab = $('#unid').find('li.active').attr('id');
         if(SelectedTab == 'MyBetTab')
         {
            /**************My Bet ************************************/
             if( !$(".loadMoreMyBetData").is(':visible'))
             {
                 var sendValue = $("#nextDataMyBet").html();
                 $("#body_loader_mybet").show();
                 $.ajax({
                     type: "POST",
                     async: false,
                     url: "{{url('my-bet-block')}}",
                     headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     data: {'sendValue':sendValue},
                     success: function(result)
                     {
                        //console.log(result);
                        if(result == 'false'){
                            flag = false;
                            $("#body_loader_mybet").hide();
                            //$("#EmptyBetSlipMybet").show();
                            //console.log(result);
                         }else{
                             //$("#EmptyBetSlipMybet").hide();
                             $("#body_loader_mybet").hide();
                             var leftPartMyBetData =  $($.parseHTML(result)).filter("#leftPartMyBetData");
                             var rightPartMyBetData =  $($.parseHTML(result)).filter("#rightPartMyBetData");
                             $("#leftPartAjaxMyBetData").append(leftPartMyBetData);
                             $("#rightPartAjaxMyBetData").append(rightPartMyBetData);
                             setTimeout(function() {
                                    flag = true;
                                     //var nextStartFrom =  $($.parseHTML(result)).find("div.nextDataAjax:last").html();
                                     var nextStartFrom =  $("div.nextDataAjaxMyBet:last").html();
                                     $("#nextDataMyBet").html(nextStartFrom);
                             	}, 100);
                          }
                     }
                 });
             }
         /**********************************************************/
         }else{
             if( !$(".loadMoreData").is(':visible'))
             {
                 var sendValue = $("#nextData").html();
                 //console.log(sendValue);
                 $("#body_loader_scroll").show();
                 $.ajax({
                     type: "POST",
                     async: false,
                     url: "{{url('display-block')}}",
                     headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     data: {'sendValue':sendValue},
                     success: function(result)
                     {
                         if(result == 'false'){
                            flag = false;
                            $("#body_loader_scroll").hide();
                            //console.log(result);
                            //$("#EmptyBetSlipId").show();
                         }else{
                            //$("#EmptyBetSlipId").hide();
                            $("#body_loader_scroll").hide();
                             var leftPartData =  $($.parseHTML(result)).filter("#leftPartData");
                             var rightPartData =  $($.parseHTML(result)).filter("#rightPartData");
                             $("#leftPartAjaxData").append(leftPartData);
                             $("#rightPartAjaxData").append(rightPartData);
                             //$("#ajaxData").append(result);
                             setTimeout(function() {
                       		    //var nextStartFrom =  $($.parseHTML(result)).find("div.nextDataAjax:last").html();
                                 var nextStartFrom =  $("div.nextDataAjax:last").html();

                   		        $("#nextData").html(nextStartFrom);
                         	}, 100);
                         }

                     }
                 });
             }
         }
     }else{
        $("#body_loader_mybet").hide();
        $("#body_loader_scroll").hide();
     }
   });
   function newsfeedpost(blockId)
   {
         var post_id = blockId;
         $.ajax({
                 type: "POST",
                 url: "{{url('news-feed-post')}}",
                 headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 data: {'post_id':post_id},
                 success: function(result)
                 {
                     //console.log(result);
                     //alert(result);
                     $("#ajaxpostdata"+post_id).html(result);
                 }
             });
   }
   function NewsFeedLikes(blockId,ToUserId)
   {
         var post_id = blockId;
         $.ajax({
                 type: "POST",
                 url: "{{url('check-newsfeed-likes')}}",
                 headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 data: {'post_id':post_id,'to_user_id':ToUserId},
                 success: function(result)
                 {
                     //console.log(result);
                     newsfeedpost(blockId);
                 }
             });
   }
   function GetComments(blockId,ToUserId)
   {
         var comment = $("#comment"+blockId).val();
         $.ajax({
                 type: "POST",
                 url: "{{url('news-feed-comment')}}",
                 headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 data: {'post_id':blockId,'comment':comment,'to_user_id':ToUserId},
                 success: function(result)
                 {
                     //console.log(result);
                     newsfeedpost(blockId);
                 }
         });
   }
   function PasingBlockId(e,BlockId)
   {
     if (e.keyCode == 13) {
         $("#CommentButton"+BlockId).trigger("click");
     }
   }
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
   function FollowUser(FollowingUserId,FollowingUserName)
   {
        if(FollowingUserId != '')
        {
            $.ajax({
                  url:"{{url('Follwing-User')}}",
                  type:'POST',
                  headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                  data: {'FollowingUserId':FollowingUserId,'FollowingUserName':FollowingUserName},
                  success:function(result)
                  {
                        if(result == 'follow')
                        {
                            //$("#follow3").text('Unfollow');
                            $("#follow"+FollowingUserId).text('Unfollow');
                        }else{
                            $("#follow"+FollowingUserId).text('Follow');
                        }
                  }
            });
        }
   }
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
<script type="text/javascript">
function genericSocialShare(url){
    var path="{{url('point-for-social-share')}}";
    $.ajax({
        type: "GET",
        url: path,
        success: function(result)
        {
          //console.log(result);
            
        }
     });
    window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
    return true;
}
function setPostId(postId)
{
    $('#postId').val(postId);
}
function setPostId2(postId)
{
    $('#postId2').val(postId);
    $.ajax({
        type: "POST",
        url: "{{url('get-privacy-data')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'postId':postId},
        success: function(result)
        {
            //console.log(result);
            $("#SettingsPrivacy").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
    });
}
//function SubmitReport()
//{

    $("#SubmitReport").click(function(){
        //alert('ff');
        $("#modal_loader_report").show();
        $.ajax({
             type: "POST",
             url: "{{url('submit-report')}}",
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             data: $("#SubmitReportForm").serialize(),
             success: function(result)
             {
                 //console.log(result);
                 if(result == 'success')
                 {
                    $("#modal_loader_report").hide();
                    location.reload();
                 }
             }
        });
    });
//}
function SeeAllComments(BlockId)
{
    $.ajax({
         type: "POST",
         url: "{{url('see-all-comments')}}",
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data: {'post_id':BlockId},
         success: function(result)
         {
             //console.log(result);
             $("#SeeComments"+BlockId).html('');
             $("#SeeComments"+BlockId).html(result).hide();
             $("#SeeComments"+BlockId).html(result).fadeIn(3000);
             $("#Comments"+BlockId).fadeOut(3000);
         }
     });
}

function BetSlipCopy(PostId)
{
    $.ajax({
         type: "POST",
         url: "{{url('Check-betslip-existance')}}",
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data: {'post_id':PostId},
         success: function(result)
         {
             //console.log(result);
             if(result != '')
             {
                //alert(result);
                $("#BetSlipSetteled"+PostId).addClass('settledItem');
                $("#BetSlipSetteled"+PostId).html('Betslip settled can not be copied').show();
                setTimeout(function() {
            		$('#BetSlipSetteled'+PostId).fadeOut('fast');
            	}, 4000);
             }else{
                /************************************************/
                var CountValue = $("#CountCopy"+PostId).text();
                if(CountValue == 1)
                {
                   $("#CopyButton"+PostId).css('pointer-events','none');
                }else{
                    $.ajax({
                         type: "POST",
                         url: "{{url('bet-slip-copy')}}",
                         headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                         data: {'post_id':PostId},
                         success: function(result)
                         {
                             //console.log(result);
                             $("#EmptyBetSlip").html('');
                             $("#BetSlip").append(result);
                             //newsfeedpost(PostId);
                             $("#CountCopy"+PostId).html((parseInt(CountValue) + 1));
                             $("#RemoveClass"+PostId).addClass('active');
                             $("#RemoveClass"+PostId).css('pointer-events','none');
                         }
                    });
                }
             }
         }
     });
}
function BetStakeAmount(StakeAmount,UniqueId,OddsValue,OddsType)
{
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
    }
}
function PlaceBet()
{
    var BetComments = $("#BetComments").val();
    $.ajax({
            type: "POST",
            url: "{{url('Place-Bet')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'BetComments':BetComments},
            success: function(result)
            {
                //console.log(result);
                location.reload();
            }
        });
}
function RemoveBetSlip(BetslipId)
{
   if(BetslipId != '')
   {
        $("#slip"+BetslipId).remove();
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
                var blockId = result;
                var CountValue = $("#CountCopy"+blockId).text();
                $("#CountCopy"+blockId).html(parseInt(CountValue - 1));
                $("#RemoveClass"+blockId).removeClass('active');
                /*$("#EmptyBetSlip").html('');
                $("#BetSlip").append(result);
                $("#body_loader").hide();*/
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
function PeopleLikeDeatils(PostId)
{
    if(PostId != '')
    {
        $("#modal_loader").show();
        $.ajax({
            type: "POST",
            url: "{{url('get-poeple-likes')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'PostId':PostId},
            success: function(result)
            {
                //console.log(result);
                $("#PeopleLikedDetails").html('');
                $("#PeopleLikedDetails").html(result);
                $("#modal_loader").hide();
            }
        });
    }
}
$("#SubmitPrivacy").click(function(){
    $("#modal_loader_privacy").show();
    $.ajax({
        type: "POST",
        url: "{{url('my-bet-privacy-settings')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $("#SubmitPrivacyForm").serialize(),
        success: function(result)
        {
            //console.log(result);
            if(result == "success")
            {
                $("#modal_loader_privacy").hide();
                location.reload();
            }
        }
    });
});
</script>
