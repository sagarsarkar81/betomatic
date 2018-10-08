<div class="reply pull-left" id="OpenModal-<?php echo $PostId; ?>"onclick="OpenReplyModal('<?php echo $PostId; ?>')">Reply</div>
<!-----------likes--------------------------------->
<?php 
if($GetLikesCount > 0) { if(!empty($CheckUserLikePost)) { ?>
<div class="upvote pull-left active" >
<i id="" class="liketrending_hover 3">
    <?php echo $GetLikesCount; ?>
    <div class="live_user">
        <button type="button" data-toggle="modal" data-target="#LikeViewModal" onclick="TrendingPeopleLikeDetails('<?php echo $PostId; ?>')">People who liked</button>
    </div> 
</i>
<span style="pointer-events: none;" class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
</div>
<?php }else{ ?>
<div class="upvote pull-left">
<i id="" class="liketrending_hover 2">
    <?php echo $GetLikesCount; ?>
    <div class="live_user" >
        <button type="button" data-toggle="modal" data-target="#LikeViewModal" onclick="TrendingPeopleLikeDetails('<?php echo $PostId; ?>')">People who liked</button>
    </div> 
</i>
<span class="glyphicon glyphicon-thumbs-up" onclick="LikesPost('<?php echo $PostId; ?>','<?php echo $PostedUserId; ?>')" aria-hidden="true"></span>
</div> 
<?php } } else{ ?>
<div class="upvote pull-left">
<i id="" class="liketrending_hover 1">
    <?php echo $GetLikesCount; ?>
    <div class="live_user" >
        <button type="button" data-toggle="modal" data-target="#LikeViewModal" onclick="TrendingPeopleLikeDetails('<?php echo $PostId; ?>')">People who liked</button>
    </div> 
</i>
<span class="glyphicon glyphicon-thumbs-up" onclick="LikesPost('<?php echo $PostId; ?>','<?php echo $PostedUserId; ?>')" aria-hidden="true"></span>
</div>
<?php } ?>
<!-----------end likes--------------------------------->
<!-----------dislikes--------------------------------->
<?php if($GetDislikeCount > 0) { if(!empty($CheckUserDisLikePost)) { ?>
<div class="upvote pull-left active" style="pointer-events: none;">
<?php echo $GetDislikeCount; ?> 
<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
</div>
<?php } else{ ?>
<div class="upvote pull-left" onclick="DislikePost('<?php echo $PostId; ?>','<?php echo $PostedUserId; ?>')">
<?php echo $GetDislikeCount; ?> 
<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
</div>  
<?php } } else{ ?>
<div class="upvote pull-left" onclick="DislikePost('<?php echo $PostId; ?>','<?php echo $PostedUserId; ?>')">
<?php echo $GetDislikeCount; ?> 
<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
</div>
<?php } ?>
<!-----------end dislikes--------------------------------->
<div class="upvote pull-left"> 
<?php if(!empty($GetBitcoinsCount)) { echo $GetBitcoinsCount; } ?><span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span>
</div>
<div class="social pull-right">
<ul>
   <li class="facebook"><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
   <li class="twitter"><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
   <li class="googleplus"><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
</ul>
</div>
<div class="share pull-right"><strong>0</strong> Share</div>