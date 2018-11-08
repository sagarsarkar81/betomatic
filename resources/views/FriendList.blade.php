<?php
use App\Users;
use App\follow_users;

if(!empty($GetFriendList)) 
{
    foreach($GetFriendList as $Key=>$Value)
    {
        $GetFollowers = follow_users::where('to_user_id',$Value['id'])->get()->toArray();
        $CountFollowers = count($GetFollowers);
?>
<div class="Search_list">
    <?php if(!empty($Value['profile_picture'])) { ?>
    <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$Value['profile_picture']; ?>"/>
    <?php } else{ ?>
    <img src="{{asset('assets/front_end/images/avatar.jpg')}}" />
    <?php } ?>
    <!--a href="{{url('visit-message-page')}}<?php echo '/'.$Value['id']; ?>"-->
    <a href="javascript:void(0);" onclick="VisitMessagePage('<?php echo $Value['id']; ?>')"> 
    <?php echo $Value['name']; ?>
    <span><?php echo $CountFollowers; ?> <?php if($CountFollowers == 0 || $CountFollowers == 1) { echo 'follower'; }else{ echo 'followers'; }?></span>
    </a>
</div>
<?php } 
}else{
?>
<div class="ChatSearchEmty"> Your friendlist is empty</div>
<?php } ?>