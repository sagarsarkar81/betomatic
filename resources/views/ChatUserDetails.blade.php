<?php 
if(empty($GetUserName)){ ?>
  <img src="{{asset('assets/front_end/images/avatar.jpg')}}" />
  <div class="user_message_name">
     <a href="javascript:void(0);">
        <h3>No user available</h3>
     </a>
  </div>
<?php } else{ 
    if(empty($GetUserName[0]['profile_picture']))
    {
?>
    <img src="{{asset('assets/front_end/images/avatar.jpg')}}" />
<?php
    }else{
?>
  <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$GetUserName[0]['profile_picture']; ?>" alt="images" class="img-responsive"/>
<?php } ?>
  <div class="user_message_name">
     <a href="{{url('visit-user-profile')}}/<?php echo $GetUserName[0]['id']; ?>">
        <div id="UserId" style="display: none;"><?php echo $GetUserName[0]['id'];?></div>
        <h3><?php echo $GetUserName[0]['name']; ?></h3>
     </a>
  </div>
<?php } ?>