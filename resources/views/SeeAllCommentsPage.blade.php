<?php
use App\Users;
use App\comment_likes;
use App\comment_replies;
if(!empty($FetchComments)) 
{ 
foreach($FetchComments as $key=>$Comments) 
{ 
$user_name = Users::select('id','name','profile_picture')->where('id',$Comments['user_id'])->get()->toArray();
$user_id = Session::get('user_id');
?>
<div class="comment_wrap">
  <a href="#">
    <?php if(empty($user_name[0]['profile_picture'])) { ?>
    <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
    <?php }else{ ?>
    <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$user_name[0]['profile_picture']; ?>"/>
    <?php } ?>
  </a>
  <div class="">
    <p>
      <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>"> 
        <?php echo $user_name[0]['name']; ?> 
      </a>
     <span>
      <?php echo $PostingTime = date("h:i:sa, d.m.Y",strtotime($Comments['creation_date']))?>
     </span>
     <p><?php echo $Comments['comments']; ?></p>
     <!-- Comment Edit and Delete -->
     <?php if($Comments['user_id'] == $user_id) { ?>
       <div class="dropdown feed_more">
          <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
          </a>
          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
            <li><a data-toggle="modal" data-target="#EditCommentModal" href="javascript:void(0);" onclick="DisplayEditCommentModal('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>')">Edit</a></li>
            <li><a href="javascript:void(0);" onclick="DeleteComments('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>')">Delete</a></li>
          </ul>
       </div>
     <?php }elseif($blockData[0]['user_id'] == $user_id) { ?>
        <div class="dropdown feed_more">
          <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
          </a>
          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
            <li><a href="javascript:void(0);" onclick="DeleteComments('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>')">Delete</a></li>
          </ul>
       </div>
     <?php } ?>
     <!-- End edit and delete -->
    </p>
    <!-- Comment reply activity  -->
    <div class="comment_reply_activity">
      <ul>
          <?php $GetCountOfLikeOnComment = comment_likes::where('post_id',$post_id)->where('comment_id',$Comments['id'])->get()->toArray(); $GetCountOnLike = count($GetCountOfLikeOnComment); 
          if($GetCountOnLike == 0)
          {
          ?>
            <li class="">
                 <i id="likepost" class="likepost_hover">
                    <?php echo $GetCountOnLike; ?>
                 </i>
                 <a href="javascript:void(0);" onclick="NewsFeedCommentsLikes('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')">  <i class="fa fa-thumbs-up" aria-hidden="true"></i> Like </a>
            </li>
          <?php
          }else{ 
          ?>
            <li class="active">
                 <i id="likepost" class="likepost_hover">
                    <?php echo $GetCountOnLike; ?>
                    <div class="live_user">
                       <button type="button" data-toggle="modal" data-target="#LikeViewModalForComment" onclick="PeopleLikeDeatilsOnComment('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>')">People who liked</button>
                    </div>
                 </i>
                 <a href="javascript:void(0);" onclick="NewsFeedCommentsLikes('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')">  <i class="fa fa-thumbs-up" aria-hidden="true"></i> <?php if($GetCountOnLike == 1) {echo "Like"; }else{ echo "Likes"; }?> </a>
            </li>
          <?php
          }
          ?>
          <?php $GetCountOfReplyOnComment = comment_replies::where('post_id',$post_id)->where('comment_id',$Comments['id'])->get()->toArray(); $GetCountOnReply = count($GetCountOfReplyOnComment); 
          if($GetCountOnReply == 0)
          {
          ?>
            <li>
             <a href="javascript:void(0);" onclick="SubCommentReply('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')"> <?php echo $GetCountOnReply; ?>  <i class="fa fa-reply-all" aria-hidden="true"></i> Reply </a>
            </li>
          <?php }else{?>
          <li class="active">
             <a href="javascript:void(0);" onclick="SubCommentReply('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')"> <?php echo $GetCountOnReply; ?>  <i class="fa fa-reply-all" aria-hidden="true"></i> <?php if($GetCountOnReply == 1) { echo "Reply" ; }else{ echo "Replies"; }?> </a>
          </li>
          <?php } ?>
       </ul>
    </div>
  </div>
</div>
<!-- Comment reply -->
<?php
$GetReplyAgainstComment = comment_replies::where('post_id',$post_id)->where('comment_id',$Comments['id'])->get()->toArray();
if(!empty($GetReplyAgainstComment))
{
    foreach($GetReplyAgainstComment as $CommentKey=>$CommentValue)
    {
    $user_name = Users::select('id','name','profile_picture')->where('id',$CommentValue['from_user_id'])->get()->toArray();
    ?>
    <div class="comment_reply">
      <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>">
        <?php $user_id = Session::get('user_id'); 
        $logged_in_user_name = Users::select('id','name','profile_picture')->where('id',$user_id)->get()->toArray();
        if(empty($logged_in_user_name[0]['profile_picture'])) { ?>
            <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
        <?php } else{  ?>
        <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$logged_in_user_name[0]['profile_picture']; ?>"/>
        <?php } ?>
     </a>
      <p>
        <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>"> 
          <?php echo $user_name[0]['name']; ?> 
        </a>
       <span>
         <?php echo $PostingTime = date("h:i:sa, d.m.Y",strtotime($CommentValue['creation_date']))?>
       </span>
       <b><?php echo $CommentValue['replied_text']; ?></b>
      </p>
       <!-- Comment Edit and Delete -->
       <?php if($CommentValue['from_user_id'] == $user_id) { ?>
       <div class="dropdown feed_more">
          <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
          </a>
          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
            <li><a data-toggle="modal" data-target="#ReplyModal" href="javascript:void(0);" onclick="DisplayOldReply('<?php echo $post_id; ?>','<?php echo $CommentValue['comment_id']; ?>','<?php echo $CommentValue['id']; ?>')">Edit</a></li>
            <li><a href="javascript:void(0);" onclick="DeleteReply('<?php echo $post_id; ?>','<?php echo $CommentValue['id']; ?>')">Delete</a></li>
          </ul>
       </div>
       <?php }elseif($blockData[0]['user_id'] == $user_id || $Comments['user_id'] == $user_id) { ?>
       <div class="dropdown feed_more">
          <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
          </a>
          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
            <li><a href="javascript:void(0);" onclick="DeleteReply('<?php echo $post_id; ?>','<?php echo $CommentValue['id']; ?>')">Delete</a></li>
          </ul>
       </div>
       <?php } ?>
      <!-- End edit and delete -->
      
    </div>
<!-- Comment reply end-->
<?php
    }
} 
?>
<!-- replied against comment end -->
<div class="SubCommentsInput" style="display: none;" id="SubComments<?php echo $Comments['id']; ?>">
  <?php if(empty($user_name[0]['profile_picture'])) { ?>
  <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
  <?php } else{  ?>
  <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$user_name[0]['profile_picture']; ?>"/>
  <?php } ?>
  <form id="SubCommentForm<?php echo $Comments['id']; ?>" action="javascript:void(0);" autocomplete="off">
    <input class="form-control input" type="text" name="ReplyComment" id="GetReply<?php echo $Comments['id']; ?>" placeholder="Add a Comment ..." onkeyup="SubCommentBlockId(event,<?php echo $Comments['id']; ?>)"/>
    <button type="button" style="display: block;" id="SubCommentButton<?php echo $Comments['id']; ?>" value="post" onclick="GetSubComments('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>','<?php echo $blockData[0]['user_id']; ?>')"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
  </form>
</div>
<?php
}
}
?>