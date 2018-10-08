<?php

function humanTiming ($time)
{
    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}
if(!empty($ListOfFriend))
{
    foreach($ListOfFriend as $Key=>$Value)
    {
        $time = strtotime($Value[creation_date]);
        $EncryptedKey = SetEncodedId($Value[id]);
?>
<li>
    <!--a class="aflx" href="{{url('visit-message-page')}}/<?php echo $Value[id]; ?>" onclick="VisitMessagePage('<?php echo $Value[id]; ?>')"-->
    <a class="aflx" href="{{url('visit-message-page')}}/<?php echo $EncryptedKey; ?>">
        <div class="dp-profile-lft">
        <?php
        if(empty($Value[profile_picture]))
        {
        ?>
            <img src="{{asset('assets/front_end/images/avatar.jpg')}}" alt="Sample Profile Picture"/>
        <?php 
        }else{
        ?>
            <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$Value[profile_picture]; ?>" alt="Sample Profile Picture"/>
        <?php } ?>
        </div>
        <div class="dp-drp-rt msgbx">
            <div class="dp-drp-rt-top"><?php echo $Value[name]; ?></div>
            <div class="dp-drp-rt-msgbx-txt"><?php if(empty($Value[message_text])) { echo "No message"; }else{ $MessageText = $Value[message_text]; $description = (strlen($MessageText) > 3) ? substr($MessageText,0,20).' ....' : $MessageText; echo $description; } ?></div>
            <div class="dp-drp-rt-time"><?php echo humanTiming($time).' ago'; ?></div>
        </div>
    </a>
</li>
<?php
    } 
}else{
?>
<div class="Blank_Message">
    <h3>No new messages</h3>
</div>
<?php
}
?>
<li>
    <a class="btm-allbtn" href="{{url('visit-message-page')}}">Inbox</a>
</li>
<!--script>
function VisitMessagePage(SelectedUserId)
{
    if(SelectedUserId !='')
    {
        $("#MessageNotificationCount").html('');
        $("#MessageNotificationCount").hide();
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
                $(".Header_search_data").html('');
                $(".Header_search_data").hide();
                $("#ModalClose").click();
                $("#LeftSideMessageList").html('');
                $("#LeftSideMessageList").html(result);
            }
        });
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
                }
        });
    }
}
</script-->