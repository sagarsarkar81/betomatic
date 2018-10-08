<?php
use App\Users;

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
if(!empty($CheckReadNotification))
{
    foreach($CheckReadNotification as $Key=>$value)
    {
        $time = strtotime($value[creation_date]);
        $GetUserDetails = Users::select('id','name','profile_picture')->where('id',$value['from_userid'])->get()->toArray();
        $EncryptedKey = SetEncodedId($value[id]);
?>
<li>
    <?php if($value[incident_type] == 'Follow'){ ?>
    <a class="aflx" href="{{url('follow-following')}}/<?php echo $EncryptedKey; ?>">
    <?php } elseif($value[incident_type] == 'Post'){ ?>
    <a class="aflx" href="{{url('trending')}}/<?php echo $EncryptedKey; ?>">
    <?php } elseif($value[incident_type] == 'Post Comment'){ ?>
    <a class="aflx" href="{{url('trending')}}/<?php echo $EncryptedKey; ?>">
    <?php } elseif($value[incident_type] == 'Comment Like'){ ?>
    <a class="aflx" href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
    <?php } elseif($value[incident_type] == 'Reply'){ ?>
    <a class="aflx" href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
    <?php } elseif($value[incident_type] == 'Comment'){ ?>
    <a class="aflx" href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
    <?php }else{ ?>
    <a class="aflx" href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
    <?php } ?>
    <!--a class="aflx" href="javascript:void(0);"-->
        <div class="dp-profile-lft">
        <?php if(empty($GetUserDetails[0][profile_picture])) { ?>
            <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
        <?php }else{ ?>
            <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$GetUserDetails[0][profile_picture]; ?>" alt="Sample Profile Picture"/>
        <?php } ?>
        </div>
        <div class="dp-drp-rt">
            <div class="dp-drp-rt-top"><span><?php echo $value[text]; ?></span></div>
            <div class="dp-drp-rt-time"><?php echo humanTiming($time).' ago'; ?></div>
        </div>
    </a>
</li>
<?php
    }
?>
<li>
    <a class="btm-allbtn" href="{{url('visit-notification-detail')}}">See All</a>
</li>
<?php
} else{
?>
<div class="Blank_Message"> You have no notification</div>
<?php
} 
?>