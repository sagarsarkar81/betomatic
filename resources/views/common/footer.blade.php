<div class="clearfix"></div>
<!-- footer part Start -->
    <footer>
        <div class="footer_wrap">
           <p><a href="<?php if(Session::get('user_id')) {?> {{url('home')}} <?php }else{?> {{url('login')}} <?php } ?>">solibet.se</a> <i class="fa fa-copyright" aria-hidden="true"></i> 2018</p>
           <div class="languages">
             <div class="dropdown languages_drop">
                  <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  {{__('label.Language')}} <i class="fa fa-angle-up" aria-hidden="true"></i>
                  </a>
                  <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    <li><a  href="javascript:void(0)" onclick="SelectLangauge('en')">English</a></li>
                    <li><a  href="javascript:void(0)" onclick="SelectLangauge('sek')">Swedish</a></li>
                  </ul>
              </div>
           </div>
           <ul class="footer_link">
              <li><a href="{{url('service')}}">{{__('label.Our service')}}</a></li>
              <li><a href="{{url('about-us')}}">{{__('label.About us')}}</a></li>
              <li><a href="{{url('contact')}}">{{__('label.Contact')}}</a></li>
              <li><a href="{{url('faq')}}">{{__('label.FAQ')}}</a></li>
           </ul>
        </div>
      <!-- footer design end-->
    </footer>
<a href="javascript:void(0);" class="showTop">
  <i class="fa fa-angle-up" aria-hidden="true"></i> 
</a>
<!-- Modal -->
    <div id="LikeViewModal" data-easein="expandIn" class="registration_modal modal fade message_UserSearch" role="dialog">
       <div class="modal-dialog">
          <!-- -loader- -->
          <div class="loader" style="display: none;" id="modal_loader">
             <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
          </div>
          <!-- ------------------- -->
          <!-- Modal content -->
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" id="ModalClose" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">People who liked</h4>
             </div>
             <div class="modal-body">
                <div class="search_wrap">
                         
                 <div class="" id="PeopleLikedDetails">
                 </div>
              </div>
                <div class="clearfix"></div>
             </div>
          </div>
       </div>
    </div>
<!-- modal end -->
<!-- Modal for comment like -->
    <div id="LikeViewModalForComment" data-easein="expandIn" class="registration_modal modal fade message_UserSearch" role="dialog">
       <div class="modal-dialog">
          <!-- -loader- -->
          <div class="loader" style="display: none;" id="modal_loader2">
             <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
          </div>
          <!-- ///////////// -->
          <!-- Modal content-->
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" id="ModalClose" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">People who liked</h4>
             </div>
             <div class="modal-body">
                <div class="search_wrap">
                         
                 <div class="" id="PeopleLikedDetails2">
                 </div>
              </div>
                <div class="clearfix"></div>
             </div>
          </div>
       </div>
    </div>
<!-- modal end -->
<!-- Comment update modal start -->
<!-- Modal -->
<div id="EditCommentModal" data-easein="expandIn" class="registration_modal modal fade informaion_modal" role="dialog">
  <div class="modal-dialog">
    <!---loader--->
    <div class="loader" style="display: none;" id="body_loader">
      <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
     </div>
     <!----------------------->
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="CloseCommentModal" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{__('label.Edit comment')}}</h4>
      </div>
      <div class="modal-body" id="DisplayOldComment">
      </div>
    </div>
  </div>
</div>
<!--  Comment update modal  end -->
<!-- reply update modal start -->
<!-- Modal -->
<div id="ReplyModal" data-easein="expandIn" class="registration_modal modal fade informaion_modal" role="dialog">
  <div class="modal-dialog">
    <!---loader--->
    <div class="loader" style="display: none;" id="body_loader">
      <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
     </div>
     <!----------------------->
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="CloseReplyModal" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{__('label.Edit reply')}}</h4>
      </div>
      <div class="modal-body" id="DisplayOldReply">
      </div>
    </div>
  </div>
</div>
<!--  reply update modal  end -->
<script>
function SelectLangauge(SelectedLangauge)
{
    $.ajax({
        type: "POST",
        url: "{{url('get-langauge')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'SelectedLangauge':SelectedLangauge},
        success: function(result)
        {
            //console.log(result);
            //alert(result);
            if(result == 1)
            {
                location.reload();
            }else{
                return false;
            }
            
        }
    });
    
}
</script>

<script type="text/javascript">
  jQuery(document).ready(function($){
  // browser window scroll (in pixels) after which the "back to top" link is shown
  var offset = 300,
    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    //duration of the top scrolling animation (in ms)
    scroll_top_duration = 700,
    //grab the "back to top" link
    $back_to_top = $('.showTop');

  //hide or show the "back to top" link
  $(window).scroll(function(){
    ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
    if( $(this).scrollTop() > offset_opacity ) { 
      $back_to_top.addClass('cd-fade-out');
    }
  });

  //smooth scroll to top
  $back_to_top.on('click', function(event){
    event.preventDefault();
    $('body,html').animate({
      scrollTop: 0 ,
      }, scroll_top_duration
    );
  });

});
</script>
<script type="text/javascript">
$(document).ready(function() {
$("#BetComments").prop('disabled', true);
$("#PlaceBet").css('pointer-events','none');
SingleBetInfo();
AccumulatorBetInfo();
GetDetailsForSingleBet();
PageLoadCheckSession();
});
function NewsFeedCommentsLikes(PostId,CommnetsId,CommentedUserId)
{
    $.ajax({
        type: "POST",
        url: "{{url('news-feed-comments-like')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'PostId':PostId,'CommnetsId':CommnetsId,'CommentedUserId':CommentedUserId},
        success: function(result)
        {
            //console.log(result);
            //alert(result);
            newsfeedpost(PostId);
        }
    });
}
function SubCommentBlockId(e,CommnetsId)
{
     if (e.keyCode == 13) {
         $("#SubCommentButton"+CommnetsId).trigger("click");
     }
}
function SubCommentReply(PostId,CommnetsId,CommentedUserId)
{
    $("#SubComments"+CommnetsId).toggle('slow');
}
function GetSubComments(PostId,CommnetsId,CommentedUserId,PostedUserId)
{
    var reply = $("#GetReply"+CommnetsId).val();
    $.ajax({
             type: "POST",
             url: "{{url('get-reply-against-comment')}}",
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             data: {'PostId':PostId,'CommnetsId':CommnetsId,'CommentedUserId':CommentedUserId,'reply':reply,'PostedUserId':PostedUserId},
             success: function(result)
             {
                 //console.log(result);
                 newsfeedpost(PostId);
             }
     });
}
function PeopleLikeDeatilsOnComment(PostId,CommnetsId)
{
    $("#modal_loader2").show();
    $.ajax({
             type: "POST",
             url: "{{url('get-like-against-comment')}}",
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             data: {'PostId':PostId,'CommnetsId':CommnetsId},
             success: function(result)
             {
                 //console.log(result);
                 $("#PeopleLikedDetails2").html('');
                 $("#PeopleLikedDetails2").html(result);
                 $("#modal_loader2").hide();
                 //newsfeedpost(PostId);
             }
     });
}
</script>


<script type="text/javascript">
  $(document).ready(function() {

    // Detect ios 11_0_x affected 
    // NEED TO BE UPDATED if new versions are affected
    var ua = navigator.userAgent,
    iOS = /iPad|iPhone|iPod/.test(ua),
    iOS11 = /OS 11_0_1|OS 11_0_2|OS 11_0_3|OS 11_1|OS 11_1_1|OS 11_1_2|OS 11_2|OS 11_2_1/.test(ua);

    // ios 11 bug caret position
    if ( iOS && iOS11 ) {

        // Add CSS class to body
        $("body").addClass("iosBugFixCaret");
        
    }

});
</script>
<script type="text/javascript">
  $('*').bind('touchend', function(e){
   if ($(e.target).attr('rel') !== 'tooltip' && ($('div.tooltip.in').length > 0)){
     $('[rel=tooltip]').mouseleave();
     e.stopPropagation();
   } else {
     $(e.target).mouseenter();
   }
});
/**********comment edit and delete**************/
function DisplayEditCommentModal(postId,CommentsId)
{
    $.ajax({
        type: "POST",
        url: "{{url('display-comment-modal')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'postId':postId,'CommentsId':CommentsId},
        success: function(result)
        {
            //console.log(result);
            //$("#DisplayOldComment").html('');
            $("#DisplayOldComment").html(result);
        }
    });
}
function CheckBlankValue(comments)
{
    if(comments == '')
    {
        $("#SaveComment").css('pointer-events','none');
    }else{
        $("#SaveComment").css('pointer-events','auto');
    }
}
function SubmitEditComment(postId)
{
    //var NewComment = $("#InputComment").val();
    $.ajax({
        type: "POST",
        url: "{{url('submit-edit-comment')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $("#EditCommentForm").serialize(),
        success: function(result)
        {
            //console.log(result);
            $("textarea").val("");
            $("#CloseCommentModal").click();
            newsfeedpost(postId);
        }
    });
}
function DeleteComments(postId,CommentsId)
{
    if(postId !='' && CommentsId !='')
    {
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "red",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(){
            $.ajax({
                type: "POST",
                url: "{{url('delete-comment')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'PostId':postId,'CommentId':CommentsId},
                success: function(result)
                {
                    //console.log(result);
                    swal({title: "Deleted", confirmButtonColor: "red",text: "Comment has been deleted", type: "success"},
                        function(){
                           //location.reload();
                           newsfeedpost(postId);
                       }
                    );
                    
                }
            });
        });
    }
}
/**************reply edit and delete****************/
function DisplayOldReply(postId,CommentsId,replyId)
{
    if(postId !='' && CommentsId !='' && replyId !='')
    {
        $.ajax({
            type: "POST",
            url: "{{url('display-reply-modal')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'postId':postId,'CommentsId':CommentsId,'replyId':replyId},
            success: function(result)
            {
                //console.log(result);
                $("#DisplayOldReply").html(result);
            }
        });
    }
}
function CheckBlankReply(Reply)
{
    if(Reply == '')
    {
        $("#SaveReply").css('pointer-events','none');
    }else{
        $("#SaveReply").css('pointer-events','auto');
    }
}
function SubmitEditReply(postId)
{
    $.ajax({
        type: "POST",
        url: "{{url('submit-edit-reply')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $("#EditReplyForm").serialize(),
        success: function(result)
        {
            //console.log(result);
            $("textarea").val("");
            $("#CloseReplyModal").click();
            newsfeedpost(postId);
        }
    });
}
function DeleteReply(postId,RepliedId)
{
    if(RepliedId !='')
    {
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "red",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(){
            $.ajax({
                type: "POST",
                url: "{{url('delete-reply')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'RepliedId':RepliedId},
                success: function(result)
                {
                    //console.log(result);
                    //location.reload();
                    swal({title: "Deleted", confirmButtonColor: "red",text: "Comment has been deleted", type: "success"},
                       function(){
                           //location.reload();
                           newsfeedpost(postId);
                       }
                    );
                }
            });
        });
    }
}
function SingleBetInfo()
{
    $.ajax({
        type: "GET",
        url: "{{url('single-bet-info')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        //data: {},
        success: function(result)
        {
            //console.log(result);
            $("#SingleBetInfo").html(result);
        }
    });
}
function AccumulatorBetInfo()
{
    $.ajax({
        type: "GET",
        url: "{{url('accumulator-bet-info')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        //data: {},
        success: function(result)
        {
            //console.log(result);
            $("#AccumulatorInfo").html(result);
        }
    });
}
/***********Place betslip function***********/
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

$(document.body).on('click',".PlaceInBetSlip",function(){
//$(".PlaceInBetSlip").click(function(){
    $("#Open_bet_slip").click();
    var MatchId = $(this).attr("MatchId");
    var BetFor = $(this).attr("BetFor");
    var UniqueId = $(this).attr("id");
    var Bookmaker = $(this).attr("Bookmaker");
    var MatchTime = $(this).attr("MatchTime");
    var BetType = $(this).attr("BetType");
    var Market = $(this).attr("Market");
    var ExtraOdds = $(this).attr("ExtraOdds");
    var MatchIdArray = [];

    var OddsValue = $(this).attr("OddsValue");
    var homeTeam = $("#homeTeam").val();
    var awayTeam = $("#awayTeam").val();

    if($("#"+UniqueId).hasClass('active'))
    {
        $("#"+UniqueId).removeClass('active');
        RemoveBetSlip(UniqueId,MatchId);
        AccumultaorOdds();
    }
    else{
        $("#"+UniqueId).addClass('active');
        $.ajax({
            type: "POST",
            async: false,
            url: "{{url('CheckOdds')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //data: {'MatchId':MatchId,'BetFor':BetFor,'UniqueId':UniqueId,'Bookmaker':Bookmaker,'MatchTime':MatchTime,'BetType':BetType,'Market':Market,'ExtraOdds':ExtraOdds},
            data: {'MatchId':MatchId,'BetFor':BetFor,'UniqueId':UniqueId, 'OddsValue':OddsValue,'homeTeam':homeTeam,'awayTeam':awayTeam},
            success: function(result)
            {
                //console.log(result);
                $("#EmptyBetSlip").hide();
                $("#BetSlip").append(result);
                var Count = $('#BetSlip').children().length;
                $(".slip_count").html(Count);
                //$("#BetComments").prop('disabled', false);
                $(".Comments").prop('disabled', false);
                $("#PlaceBet").css('pointer-events','auto');
                $(".BetStake").each(function(){
                  var CheckStakeInput = $(this).val();
                  if(CheckStakeInput == '')
                  {
                      $("#PlaceBet").css('pointer-events','none');
                  }
                });
                
            }
        });
        $.ajax({
            type: "POST",
            async: false,
            url: "{{url('check-accumulator-odds')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'MatchId':MatchId,'BetFor':BetFor,'UniqueId':UniqueId,'Bookmaker':Bookmaker,'MatchTime':MatchTime,'BetType':BetType,'Market':Market,'ExtraOdds':ExtraOdds},
            success: function(result)
            {
                //console.log(result);
                $("#EmptyBetSlipAccu").hide();
                $("#BettingSlipAccumulator").append(result);
                AccumultaorOdds();
                $.ajax({
                    type: "POST",
                    url: "{{url('check-same-matchId')}}",
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'MatchId':MatchId},
                    success: function(res)
                    {
                        //console.log(res);
                        $("."+MatchId).addClass(res);
                    }
                });
            }
        });
    }
});
/**************Remove betslip function**************/
function RemoveStake()
{
    var count=0;
    var StakeValue = 0;
    $(".BetStake").each(function(){
        var CheckStakeInput = $(this).val();
        if(CheckStakeInput == '')
        {
           count++;
        }else{
            if(isNaN(CheckStakeInput) == false){
                StakeValue += parseFloat(CheckStakeInput);
            }
        }
    });
    $("#TotalStake").html(StakeValue.toFixed(2));
    var TotalPayout;
    var TotalPayouts = 0;
    $(".PotentialPayout").each(function(){
        TotalPayout = parseFloat($(this).val());
        if(!isNaN(TotalPayout)){
           TotalPayouts+=TotalPayout;
        }
    });
    $("#TotalReturn").html('');
    $("#TotalReturn").html(TotalPayouts.toFixed(2));
}
function RemoveBetSlip(BetslipId,MatchId)
{
   if(BetslipId != '')
   {
        $("#whole_slip"+BetslipId).remove();
        $("#whole_slip_accu"+BetslipId).remove();
        $("."+MatchId).removeClass('match_found');
        $("#"+BetslipId).removeClass('active');
        AccumultaorOdds();
        $.ajax({
            type: "POST",
            url: "{{url('Remove-Odds-From-Session')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'BetSlipId':BetslipId},
            success: function(result)
            {
                //console.log(result);
                if ( $('#BetSlip').children().length == 0 ) {
                    $("#EmptyBetSlip").show();
                    $("#EmptyBetSlipAccu").show();
                    //$("#BetComments").prop('disabled', true);
                    $(".Comments").prop('disabled', true);
                    $("#PlaceBet").css('pointer-events','none');
                    $(".slip_count").html(0);
                }else{
                    RemoveStake();
                    var Count = $('#BetSlip').children().length;
                    $(".slip_count").html(Count);
                    $("#BetComments").prop('disabled', false);
                    $("#PlaceBet").css('pointer-events','auto');
                }
            }
        });
   }
}
/**************stake input function**************/
function PotentialReturn(StakeAmount,UniqueId,OddsValue,OddsType)
{
    var count=0;
    var StakeValue = 0;
    $(".BetStake").each(function(){
        var CheckStakeInput = $(this).val();
        if(StakeAmount == '')
        {
            $("#Payment"+UniqueId).val('');
        }
        if(CheckStakeInput == '')
        {
           count++;
        }else{
            if(isNaN(CheckStakeInput) == false){
                StakeValue += parseFloat(CheckStakeInput);
                var PaymentReturn = parseFloat(OddsValue * StakeAmount);
                $("#Payment"+UniqueId).val('');
                $("#Payment"+UniqueId).val(PaymentReturn);
            }
        }
    });
    $("#TotalStake").html(StakeValue.toFixed(2));
    if(count==0){
        $("#PlaceBet").css('pointer-events','auto');
    }
    else{
        $("#PlaceBet").css('pointer-events','none');
    }
}
function BetStakeAmount(StakeAmount,UniqueId,OddsValue,OddsType)
{
    PotentialReturn(StakeAmount,UniqueId,OddsValue,OddsType);
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
        var TotalPayout;
        var TotalPayouts = 0;
        $(".PotentialPayout").each(function(){
            TotalPayout = parseFloat($(this).val());
            if(!isNaN(TotalPayout)){
               TotalPayouts+=TotalPayout;
            }
        });
        $("#TotalReturn").html('');
        $("#TotalReturn").html(TotalPayouts.toFixed(2));
    }else{
        $(".BetStake").each(function(){
            var CheckStakeInput = $(this).val();
            if(CheckStakeInput == '')
            {
                $("#PlaceBet").css('pointer-events','none');
            }
        });
        var x;
        var y = 0;
        $(".PotentialPayout").each(function(){
            x = parseFloat($(this).val());
            if(!isNaN(x)){
               y+=x;
            }
        });
        $("#TotalReturn").html('');
        $("#TotalReturn").html(y);
    }
}
/***********Place Bet*****************/
function PlaceBetConfirmation()
{
    $("#display_confirmation_alert").show();
}
function SelectPrivacy(value)
{
    if(value == 'Public')
    {
        $("#Private").removeClass('active');
        $("#Public").addClass('active');
        $("#PrivacyValue").val('');
        $("#PrivacyValue").val('1');
    }else{
        $("#Public").removeClass('active');
        $("#Private").addClass('active');
        $("#PrivacyValue").val('');
        $("#PrivacyValue").val('2');
    }
}

function PlaceBet()
{
    var BetComments = $("#BetComments").val();
    var PrivacySettings = $("#PrivacyValue").val();
    var bet_type = "Single";
    $.ajax({
            type: "POST",
            async: false,
            url: "{{url('check-minimum-stake')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'bet_type':bet_type},
            success: function(result)
            {
                //console.log(result);
                if(result == "error")
                {
                    swal({
                        title: "Please provide minimum stake",
                        html : true,
                        type: "error",
                        confirmButtonColor: "red",
                        closeOnConfirm: false,
                        closeOnCancel: true
                      });
                    $("#display_confirmation_alert").hide();
                }else{
                    $.ajax({
                          type: "POST",
                          async: false,
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
    });
}
/*************Accumulator bet section*******************/
function SelectPrivacyForAccumulator(value)
{
    if(value == 'Public')
    {
        $("#Accu_private").removeClass('active');
        $("#Accu_public").addClass('active');
        $("#PrivacyValueAccu").val('');
        $("#PrivacyValueAccu").val('1');
    }else{
        $("#Accu_public").removeClass('active');
        $("#Accu_private").addClass('active');
        $("#PrivacyValueAccu").val('');
        $("#PrivacyValueAccu").val('2');
    }
}
function AccumulatorStake(Stake,UniqueId,OddsValue,OddsType)
{
    var TotalPayout = 0;
    if(Stake != '')
    {
        var TotalOdds = $("#Accu_odds").html();
        $("#Accu_stake").html(Stake);
        TotalPayout = parseFloat(Stake * TotalOdds);
        $("#Accu_payout").html('');
        $("#Accu_payout").html(TotalPayout.toFixed(2));
        $("#AccumulatorId").css('pointer-events','auto');
        /******stake into session*******/
        $.ajax({
            type: "POST",
            url: "{{url('stake-accu-session')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'Stake':Stake},
            success: function(result)
            {
                //console.log(result);
            }
        });
    }else{
        Stake = 0;
        TotalPayout = 0;
        $("#Accu_stake").html(Stake.toFixed(2));
        $("#Accu_payout").html(TotalPayout.toFixed(2));
        $("#AccumulatorId").css('pointer-events','none');
    }
}
function AccumultaorOdds()
{
    var Odds = 1;
    var TotalOdds = 1;
    $(".Accu_odds").each(function(){
        Odds = parseFloat($(this).html());
        if(!isNaN(Odds)){
           TotalOdds *= Odds;
        }
        
    });
    $("#Accu_odds").html('');
    $("#Accu_odds").html(TotalOdds.toFixed(2));
}
function AccumulatorBetPlaceConfirmation()
{
    $("#display_confirmation_alert_accu").show();
}
function PlaceAccumulatorBet()
{
    var BetComments = $("#BetCommentsAccu").val();
    var PrivacySettings = $("#PrivacyValueAccu").val();
    var bet_type = "Accumulator";
    var Count = $('#BetSlip').children().length;
    $.ajax({
            type: "POST",
            async: false,
            url: "{{url('check-minimum-stake')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'bet_type':bet_type},
            success: function(result)
            {
                //console.log(result);
                if(result == "error")
                {
                    swal({
                        title: "Please provide minimum stake",
                        html : true,
                        type: "error",
                        confirmButtonColor: "red",
                        closeOnConfirm: false,
                        closeOnCancel: true
                      });
                    $("#display_confirmation_alert_accu").hide();
                }else{
                    var combination = 'minimum';
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "{{url('minimum-combination')}}",
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {'combination':combination},
                        success: function(result)
                        {
                          if(result == "minimum_combination")
                          {
                          swal({
                                title: "Please provide minimum combination",
                                html : true,
                                type: "error",
                                confirmButtonColor: "red",
                                closeOnConfirm: false,
                                closeOnCancel: true
                              });
                            $("#display_confirmation_alert_accu").hide();
                          }else{
                              var combination = 'maximum';
                              $.ajax({
                                  type: "POST",
                                  async: false,
                                  url: "{{url('minimum-combination')}}",
                                  headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  },
                                  data: {'combination':combination},
                                  success: function(result)
                                  {
                                      if(result == 'maximum_combination')
                                      {
                                      swal({
                                          title: "Maximum combination exceed",
                                          html : true,
                                          type: "error",
                                          confirmButtonColor: "red",
                                          closeOnConfirm: false,
                                          closeOnCancel: true
                                        });
                                        $("#display_confirmation_alert_accu").hide();
                                      }else{
                                        if($(".CommonClass").hasClass('match_found'))
                                        {
                                            swal({
                                              title: "Some item from same match.Please select unique item!",
                                              html : true,
                                              type: "error",
                                              confirmButtonColor: "red",
                                              closeOnConfirm: false,
                                              closeOnCancel: true
                                            });
                                            $("#display_confirmation_alert_accu").hide();
                                        } else {
                                              $.ajax({
                                                  type: "POST",
                                                  async: false,
                                                  url: "{{url('Place-Accumulator-Bet')}}",
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
                                  }
                              });
                            }
                        }
                    });
                }
            }
    });
}
/************for extra odds page*******************/
function GetDetailsForSingleBet()
{
    $.ajax({
       type: "GET",
       async: false,
       url: "{{url('get-details-single-bet')}}",
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(result)
       {
          //console.log(result.Payout);
          if(result != '')
          {
              //var Data = JSON.parse(result);
              //var Stake = Data.Stake;
              //var payout = Data.Payout;
              $("#TotalStake").html('');
              $("#TotalStake").html(result.Stake.toFixed(2));
              $("#TotalReturn").html('');
              $("#TotalReturn").html(result.Payout.toFixed(2));
          }
       }
   });
}
function PageLoadCheckSession()
{
    $.ajax({
       type: "GET",
       async: false,
       url: "{{url('check-session-for-extra-odds')}}",
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       //data: {'BookmakerName':BookmakerName,'MatchId':MatchId},
       success: function(result)
       {
            //console.log(result);
            if(result == '')
            {
                $("#EmptyBetSlip").show();
            }else{
                $("#EmptyBetSlip").hide();
                $("#BetSlip").append(result);
                var Count = $('#BetSlip').children().length;
                $(".slip_count").html(Count);
                //$("#BetComments").prop('disabled', false);
                $(".Comments").prop('disabled', false);
                $("#PlaceBet").css('pointer-events','auto');
                $(".BetStake").each(function(){
                  var CheckStakeInput = $(this).val();
                  if(CheckStakeInput == '')
                  {
                      $("#PlaceBet").css('pointer-events','none');
                  }
                });
            }
       }
   });
   $.ajax({
        type: "GET",
        async: false,
        url: "{{url('check-session-for-accu-bet')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result)
        {
            //console.log(result);
            if(result == ''){
                $("#EmptyBetSlipAccu").show();
            }else{
                $("#EmptyBetSlipAccu").hide();
                $("#BettingSlipAccumulator").append(result);
                AccumultaorOdds();
            }
            /*$.ajax({
                type: "POST",
                url: "{{url('check-same-matchId')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'MatchId':MatchId},
                success: function(res)
                {
                    //console.log(res);
                    $("."+MatchId).addClass(res);
                }
            });*/
        }
    });
}
function SetFeaturedMatch()
{
  $.ajax({
      type: "GET",
      url: "{{url('set-featured-match')}}",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      //data: {'MatchId':MatchId},
      success: function(result)
      {
          //console.log(result);
          $("#FeaturedMatch").html('');
          $("#FeaturedMatch").html(result);
      }
  });
}
</script>
