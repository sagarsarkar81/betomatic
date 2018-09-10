<?php
use App\Users;
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
         <div class="col-md-4">
            <div class="messages_list_wrap">
               <h3>Messages list
                  <span><a href="#" data-toggle="modal" data-target="#message_UserSearch">
                  <i class="fa fa-plus-circle" aria-hidden="true"></i> 
                  New Messages</a>
                  </span>
               </h3>
               <div class="message_user_search">
                  <input class="form-control" type="text" name="" onkeyup="SearchPeopleFromList(this.value);" placeholder="Search People from list..." id="MessageSearch"/>
               </div>
               <div class="messages_list" id="LeftSideMessageList">
               </div>
            </div>
         </div>
         <div class="col-md-8">
            <div class="user_message_wrap">
               <div class="headingContainer">
                  <div id="SelectedUserId" style="display: none;"><?php echo $id; ?></div>
                  <div class="user_message_heading" id="ChatUserDetails">
                  </div>
                   <!-- dropdown More -->   
                  <div class="dropdown feed_more chat_settings">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                     <i class="fa fa-cog" aria-hidden="true"></i>
                     </a>
                     <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                        <li><a href="javascript:void(0);" onclick="DisplayDeleteConversationMeassage()">Delete Conversation</a></li>
                        <li><a href="javascript:void(0);" onclick="DisplayDeleteMeassae()">Delete Chat</a></li>
                     </ul>
                  </div>
                  <!-- dropdown More -->
               </div>
               <div class="user_message_body" id="MessageBody">
               <div class="clearfix"></div>
               </div>
               <div class="user_message_footer">
                  <textarea data-autoresize  type="text" row="2"  id="MessageText" disabled="disabled" class="form-control" placeholder="Enter your message..."></textarea>
                  <button type="button" class="send_messages" onclick="SendMessage('<?php echo $SelectedUserId; ?>')">
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>
                  </button>
                  <div class="DeleteChatIndividual" style="display: none;">
                    <p>Select Message To Delete  
                    <a class="DeleteChatIndividualCancel" href="javascript:void(0);" onclick="RemoveDisplayMessageBox()">Cancel</a> 
                    <a class="DeleteChatIndividualDelete" href="javascript:void(0);" onclick="DeleteIndividualChat()">Delete</a></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
<!-- Modal -->
<div id="message_UserSearch" data-easein="expandIn" class="registration_modal modal fade message_UserSearch" role="dialog">
   <div class="modal-dialog">
      <!---loader--->
      <div class="loader" style="display: none;" id="body_loader">
         <img src="http://betogram.com/assets/front_end/images/loading.gif"/>
      </div>
      <!----------------------->
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" id="ModalClose" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Search People</h4>
         </div>
         <div class="modal-body">
            <!------loader----->
            <div class="loader" style="display: none;" id="search_loader">
              <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
            </div>
            <!------loader----->
            <ul class="Messages_search_input">
               <li class="header_search">
                  <div class="search_wrap">
                     <div class="input-group">
                        <div class="input-group-btn">
                           <i class="fa fa-search"></i>
                        </div>
                        <input type="text" id="SearchInput" class="form-control" placeholder="Search for people..." name="SearchUsername" onkeyup="SearchByUsername(this.value)"/>
                     </div>
                     <div class="Header_search_data" id="SearchDataMessage" style="display: none;">
                     <?php 
                        if(!empty($GetFriendList)) 
                        {
                            foreach($GetFriendList as $Key=>$Value)
                            {
                                $GetNameOfFriends = Users::select('id','name','profile_picture')->where('id',$Value['to_user_id'])->get()->toArray();
                        ?>
                        <div class="Search_list">
                            <?php if(!empty($GetNameOfFriends[0][profile_picture])) { ?>
                            <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$GetNameOfFriends[0][profile_picture]; ?>"/>
                            <?php } else{ ?>
                            <img src="{{asset('assets/front_end/images/avatar.jpg')}}" />
                            <?php } ?>
                            <!--a href="{{url('visit-message-page')}}<?php echo '/'.$GetNameOfFriends[0][id]; ?>"-->
                            <a href="javascript:void(0);" onclick="VisitMessagePage('<?php echo $GetNameOfFriends[0][id]; ?>')">  
                            <?php echo $GetNameOfFriends[0][name]; ?>
                            <span>1 Follower</span>
                            </a>
                        </div>
                        <?php } 
                        }else{
                        ?>
                        <div> Your friendlist is empty</div>
                     <?php } ?>
                     </div>
                     <!--div class="Search_loader" style="display: none;" id="search_loader">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                     </div-->
                  </div>
               </li>
            </ul>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</div>
<!-- Bio update modal end -->
@include('common/footer')
@include('common/footer_link')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    jQuery.noConflict();
    $("#MessageSearch").val('');
    $("#body_loader").show();
    //DetailMessageNotification();
    UnreadMessageNotification();
    var scrollBottom = $(window).scrollTop() + $(window).height(); //$("#MessageBody").height()
    $(".user_message_body").animate({ scrollTop: scrollBottom }, 1000);
    var SelectedUserId = $("#SelectedUserId").text();
    //alert(SelectedUserId);
    //VisitMessagePage(SelectedUserId);
    if(LeftSideMessageList()){
         $.ajax({
                type: "GET",
                url: "{{url('get-chat-details-first-appear')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result)
                {
                    //console.log(result);
                    $("#MessageBody").html(result);
                }
        });
        $.ajax({
            type: "GET",
            url: "{{url('get-chat-first-username')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result)
            {
                //console.log(result);
                $("#ChatUserDetails").html(result);
                CheckMessageText();
                //-------------checking UserId exist in Chat page----------------------//
                var userId = $("#UserId").text();
                if(userId == '')
                {
                    $("#MessageSettings").hide();
                }else{
                    $("#MessageSettings").show();
                    //$("#Read"+userId).removeClass('unread');
                }
                //---------------------------------------------------------------------//
            }
        });
    }
    $("#body_loader").hide();
});
function LeftSideMessageList()
{
    var status=0;
    $.ajax({
            type: "GET",
            async:false,
            url: "{{url('left-side-message-list')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result)
            {
                //console.log(result);
                $("#LeftSideMessageList").html(result);
                status=1;
            }
    });
    return status;
}
function SendMessage(receiver_user_id)
{
    var message = $("#MessageText").val();
    if(receiver_user_id == '')
    {
        var receiver_id = $("#UserId").text();
        $("#body_loader").show();
        $.ajax({
                type: "POST",
                url: "{{url('chat-page')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'receiver_user_id':receiver_id,'message':message},
                success: function(result)
                {
                    //console.log(result);
                    var MessageBody = $("#MessageBody").html();
                    $("#MessageText").val('');
                    if($("#MessageBody").find('.today').length == 0)
                    {
                        $("#MessageBody").append(result);
                        LeftSideMessageList();
                    }
                    else
                    {
                        $("#MessageBody").append(result);
                        $("#MessageBody .today:last").remove();
                        LeftSideMessageList();
                    }
                    var scrollBottom = $(window).scrollTop() + $(window).height(); //$("#MessageBody").height()
                    $(".user_message_body").animate({ scrollTop: scrollBottom }, 1000);
                }
        });
        $("#body_loader").hide();
    }else{
        $("#body_loader").show();
        $.ajax({
                type: "POST",
                url: "{{url('chat-page')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'receiver_user_id':receiver_user_id,'message':message},
                success: function(result)
                {
                    //console.log(result);
                    var MessageBody = $("#MessageBody").html();
                    $("#MessageText").val('');
                    if($("#MessageBody").find('.today').length == 0)
                    {
                        $("#MessageBody").append(result);
                        LeftSideMessageList();
                    }
                    else
                    {
                        $("#MessageBody").append(result);
                        $("#MessageBody .today:last").remove();
                        LeftSideMessageList();
                    }
                    var scrollBottom = $(window).scrollTop() + $(window).height(); //$("#MessageBody").height()
                    $(".user_message_body").animate({ scrollTop: scrollBottom }, 1000);
                }
        });
        $("#body_loader").hide();
    }
}
function LoadUserChat(ReceiverUserId)
{
    $("#body_loader").show();
    $.ajax({
            type: "POST",
            url: "{{url('load-chat-details')}}",
            data: {'receiver_user_id':ReceiverUserId},
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result)
            {
                //console.log(result);
                $.ajax({
                        type: "POST",
                        url: "{{url('load-user-details')}}",
                        data: {'receiver_user_id':ReceiverUserId},
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result)
                        {
                            //console.log(result);
                            $("#ChatUserDetails").html(result);
                            
                        }
                });
                $("#MessageBody").html(result);
                var scrollBottom = $(window).scrollTop() + $(window).height(); //$("#MessageBody").height()
                $(".user_message_body").animate({ scrollTop: scrollBottom }, 1000);
            }
    });
    $("#body_loader").hide();
}
function SearchPeopleFromList(UserName)
{
    if(UserName != '')
    {
        $.ajax({
            type: "POST",
            url: "{{url('search-people-from-list')}}",
            data: {'username':UserName},
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result)
            {
                //console.log(result);
                $("#LeftSideMessageList").html(result);
            }
        });
    }else{
        //$("#LeftSideMessageList").html('');
        $.ajax({
            type: "GET",
            url: "{{url('left-side-message-list')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result)
            {
                //console.log(result);
                $("#LeftSideMessageList").html(result);
            }
        });
    }
}
function SearchByUsername(username)
{
    $("#search_loader").show();
    if(username !='')
    {
        $.ajax({
            type: "POST",
            url: "{{url('message-search-username')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'username':username},
            success: function(result)
            {
                //console.log(result);
                $("#SearchDataMessage").html('');
                $("#SearchDataMessage").html(result).show();
            }
        });
    }else{
        $("#SearchDataMessage").html('');
        $("#SearchDataMessage").hide();
        //$("#ModalClose").click();
    }
    $("#search_loader").hide();
}
function VisitMessagePage(SelectedUserId)
{
    if(SelectedUserId !='')
    {
        $("#MessageNotificationCount").html('');
        $("#MessageNotificationCount").hide();
        $("#body_loader_search").show();
        $.ajax({
            type: "POST",
            url: "{{url('visit-selected-user')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'SelectedUserId':SelectedUserId},
            success: function(result)
            {
                //console.log(result);
                $("#SearchDataMessage").html('');
                $("#SearchDataMessage").hide();
                $("#ModalClose").click();
                $("#LeftSideMessageList").html('');
                $("#LeftSideMessageList").html(result);
                //$("#Read"+userId).removeClass('unread');
                
                //---- get chat details with friends ---//
                $.ajax({
                    type: "POST",
                    url: "{{url('get-chat-with-friend')}}",
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'SelectedUserId':SelectedUserId},
                    success: function(response)
                    {
                        //console.log(response);
                        $("#MessageBody").html('');
                        $("#MessageBody").html(response);
                    }
                });
                //---------------------------------------//
                //---- get friend details ---------------//
                $.ajax({
                    type: "POST",
                    url: "{{url('get-friend-details')}}",
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'SelectedUserId':SelectedUserId},
                    success: function(response)
                    {
                        //console.log(response);
                        $("#ChatUserDetails").html('');
                        $("#ChatUserDetails").html(response);
                        CheckMessageText();
                    }
                });
                //---------------------------------------//
                //---------- get other conversations ------//
                $.ajax({
                    type: "POST",
                    url: "{{url('get-other-conversations')}}",
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'SelectedUserId':SelectedUserId},
                    success: function(result)
                    {
                        //console.log(result);
                        $("#LeftSideMessageList").append(result); 
                    }
                });
                //---------------------------------------//
            }
        });
        $("#body_loader_search").hide();
        /*$.ajax({
                type: "POST",
                url: "{{url('get-chat-with-friend')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'SelectedUserId':SelectedUserId},
                success: function(response)
                {
                    //console.log(response);
                    $("#MessageBody").html('');
                    $("#MessageBody").html(response);
                }
        });*/
        /*$.ajax({
                type: "POST",
                url: "{{url('get-friend-details')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'SelectedUserId':SelectedUserId},
                success: function(response)
                {
                    //console.log(response);
                    $("#ChatUserDetails").html('');
                    $("#ChatUserDetails").html(response);
                    CheckMessageText();
                }
        });*/
        /*$.ajax({
                type: "POST",
                url: "{{url('get-other-conversations')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'SelectedUserId':SelectedUserId},
                success: function(result)
                {
                    //console.log(result);
                    $("#LeftSideMessageList").append(result); 
                }
        });*/
    }
    //$("#body_loader").hide();
}
   
function DisplayDeleteMeassae()
{
    $(".checkbox").show();
    $(".DeleteChatIndividual").show();
}
function RemoveDisplayMessageBox()
{
    $(".DeleteChatIndividual").hide();
    $(".checkbox").hide();
}
function DisplayDeleteConversationMeassage()
{
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this chat!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "red",
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function(){
        var SelectedUserId = $("#UserId").text();
        $.ajax({
            type: "POST",
            url: "{{url('delete-entire-conversations')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'SelectedUserId':SelectedUserId},
            success: function(result)
            {
                //console.log(result);
                //if(result == 'success')
                //{
                    swal({title: "Deleted", confirmButtonColor: "red",text: "Entire conversations has been deleted!", type: "success"},
                       function(){
                           $("#ChatUserDetails").html('');
                           location.reload();
                       }
                    );
                //}
            }
        });
        
    });
}
function DeleteIndividualChat()
{
    $("#body_loader").show();
    var ReceiverUserId = $("#UserId").text();
    var ChatId = [];
    //if(ChatId.length > 0)
    //{
        $(':checkbox:checked').each(function(i){
            ChatId[i] = $(this).val();
        });
        $.ajax({
            type: "POST",
            url: "{{url('delete-individual-chat')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{'ChatId':ChatId,'ReceiverUserId':ReceiverUserId},
            success: function(result)
            {
                //console.log(result);
                /*$("#MessageBody").html('');
                $("#MessageBody").html(result);
                LeftSideMessageList();*/
                $(".DeleteChatIndividual").hide();
                VisitMessagePage(ReceiverUserId);
            }
        });
    //}
    $("#body_loader").hide();
        
}
</script>