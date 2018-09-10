<!--div class="dateClass"><?php echo date("F jS, Y",strtotime($Value[creation_date])); ?></div-->
<?php 
if(!empty($GetMessage))
{
    $msgDateVar = '';
    $currentDate = date("F jS, Y");
    foreach($GetMessage as $Key => $Value)
    {
        if($msgDateVar != date("F jS, Y",strtotime($Value[creation_date])))
        {
            $msgDateVar = date("F jS, Y",strtotime($Value[creation_date]));
            if($currentDate == $msgDateVar)
            { ?>
                <div class="dateClass today">Today</div>
            <?php } else { ?>
                <div class="dateClass"> <?php echo $msgDateVar; ?></div>
            <?php } 
        } ?>
        <?php if($Value[sender_id] == $sender_user_id)
        {
?>
<div class="chatRight pull-right <?php if(empty($Value[message_text])) { echo "deleted_message"; } ?>">

  <div class="checkbox chatDeleteLeft <?php echo $Value[id]; ?>" style="display: none;">
    <input id="checkbox<?php echo $Value[id]; ?>" type="checkbox" value="<?php echo $Value[id]; ?>"/>
    <label for="checkbox<?php echo $Value[id]; ?>">
    </label>
  </div>
  <?php if(!empty($Value[message_text])) { ?>
  <p><?php echo strip_tags($Value[message_text]); ?></p>
  <?php }else{ ?>
  <p><?php echo "This message has been removed".'<i class="fa fa-trash" aria-hidden="true"></i>'; }?></p>
 <span><?php echo date("H:i a",strtotime($Value[creation_date])); ?></span>              
</div>
<div class="clearfix"></div>
<?php   
    }else{ 
?>
<div class="chatLeft pull-left <?php if(empty($Value[message_text])) { echo "deleted_message"; } ?>"> 
  <div class="checkbox chatDeleteRight <?php echo $Value[id]; ?>" style="display: none;">
    <input id="checkbox<?php echo $Value[id]; ?>" type="checkbox" value="<?php echo $Value[id]; ?>" />
    <label for="checkbox<?php echo $Value[id]; ?>">
    </label>
  </div>
  <?php if(!empty($Value[message_text])) { ?>
  <p><?php echo strip_tags($Value[message_text]);?></p>
  <?php }else{ ?>
  <p><?php echo '<i class="fa fa-trash" aria-hidden="true"></i>'."This message has been removed"; }?></p>
  <span><?php echo date("H:i a",strtotime($Value[creation_date])); ?></span>              
</div>
<?php   } 
?>
<div class="clearfix"></div>
<?php 
    }
}
?>
