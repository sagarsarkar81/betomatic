<?php 
if(!empty($ListOfFriend)) 
{ 
    foreach($ListOfFriend as $ListKey=>$ListValue)
    { 
?>
  <div class="message_list_user unread" id="Read<?php echo $ListValue[id]; ?>">
     <a href="javascript:void(0);" onclick="LoadUserChat('<?php echo $ListValue[id]; ?>')">
        <?php if(!empty($ListValue[profile_picture])) { ?>
        <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$ListValue[profile_picture]; ?>" alt="images" class="img-responsive"/>
        <?php } else{ ?>
        <img src="{{asset('assets/front_end/images/avatar.jpg')}}" />
        <?php } ?>
        <div class="messgae_user_content">
           <h3><?php echo $ListValue[name]; ?></h3>
           <p><?php if(empty($ListValue[message_text])) { echo "No message"; }else{ echo strip_tags($ListValue[message_text]); } ?></p>
           <span><?php if(!empty($ListValue[creation_date])) { echo date("F jS, Y H:i a",strtotime($ListValue[creation_date])); } ?></span>
           <!--span>September 18th 2017 at 1:41pm</span-->
        </div>
     </a>
  </div>
<?php } 
}else{ 
?>
  <div class="message_list_user"> 
     <p class="blank_chat">No chat available</p>
  </div>
<?php } ?>