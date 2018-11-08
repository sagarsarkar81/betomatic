<?php
use App\Users;
use App\news_feeds;
use App\news_feed_likes;
use App\news_feed_comments;
use App\comment_likes;
use App\comment_replies;

$user_id = Session::get('user_id');
?>
<div class="feed_social_wrap" id="PostCommentId<?php echo $post_id; ?>">
  <ul class="feed_social">
  <?php
  if($GetCountLikes == 0)
  {
  ?>
  <li>
    <a data-toggle="tooltip" data-placement="top" title="Like" href="javascript:void(0);" onclick="NewsFeedLikes('<?php echo $post_id; ?>','<?php echo $GetPostedUserId[0]['user_id']; ?>')">
     0
     <i class="fa fa-thumbs-up" aria-hidden="true"></i>
    </a>
  </li>
  <?php } else{ ?>
  <li class="<?php if(!empty($CheckLoggedUserMakeLike)) { echo "active"; } ?>">
    <i id="likepost" class="likepost_hover">
        <?php echo $GetCountLikes;?>
        <div class="live_user">
            <button type="button" data-toggle="modal" data-target="#LikeViewModal" onclick="PeopleLikeDeatils('<?php echo $post_id;; ?>')">People who liked</button>
        </div>
     </i>
   <a data-toggle="tooltip" data-placement="top" title="Like" href="javascript:void(0);" onclick="NewsFeedLikes('<?php echo $post_id; ?>','<?php echo $GetPostedUserId[0]['user_id']; ?>')">
    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
   </a>
 </li>
  <?php } ?>
  <!-- count comment -->
  <?php
  if($GetCount == 0)
  {
  ?>
  <li>
     <a data-toggle="tooltip" data-placement="top" title="Comment"  href="javascript:void(0);"> <?php echo $GetCount; ?> <i class="fa fa-comments" aria-hidden="true"></i></a>
  </li>
  <?php
  }else{
      if(empty($CheckLoggedUserMakeComment))
      {
      ?>
      <li class="">
         <a data-toggle="tooltip" data-placement="top" title="Comment"  href="javascript:void(0);"> <?php echo $GetCount; ?> <i class="fa fa-comments" aria-hidden="true"></i></a>
      </li>
      <?php
      }else{
      ?>
      <li class="active">
         <a data-toggle="tooltip" data-placement="top" title="Comment"  href="javascript:void(0);"> <?php echo $GetCount; ?> <i class="fa fa-comments" aria-hidden="true"></i></a>
      </li>
      <?php
      }
  }
  ?>
  <!-- count comment -->
  <!-- copy section -->
  <?php if($CountNumber == 0) { ?>
     <li class="" id="RemoveClass<?php echo $post_id; ?>">
       <a data-toggle="tooltip" data-placement="top" title="Copy" href="javascript:void(0);" onclick="BetSlipCopy(<?php echo $post_id; ?>)" id="CopyButton<?php echo $post_id; ?>">
         <!--i id="CountCopy<?php echo $post_id; ?>"><?php if($CountNumber == 0) { echo $CountNumber + 1; } ?></i-->
         <i id="CountCopy<?php echo $post_id; ?>">0</i>
         <i class="fa fa-clone" aria-hidden="true"></i>
       </a>
     </li>
  <?php } else{ ?>
    <li class="active" id="RemoveClass<?php echo $post_id; ?>">
       <a data-toggle="tooltip" data-placement="top" title="Copy" href="javascript:void(0);" onclick="BetSlipCopy(<?php echo $post_id; ?>)" id="CopyButton<?php echo $post_id; ?>" style="pointer-events:none">
         <!--i id="CountCopy<?php echo $post_id; ?>"><?php if($CountNumber == 0) { echo $CountNumber + 1; }else{ echo $CountNumber + 1; } ?></i-->
         <i id="CountCopy<?php echo $post_id; ?>"><?php echo $CountNumber; ?></i>
         <i class="fa fa-clone" aria-hidden="true"></i>
       </a>
     </li>
  <?php } ?>
  <!-- // -->
  <li>
     <a data-toggle="tooltip" data-placement="top" title="Facebook"  href="javascript:void(0)" class="icon-fb" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo urlencode($base_url.'/social-share-facebook/'.$post_id); ?>')">
       <i class="fa fa-facebook" aria-hidden="true"></i>
     </a>
  </li>
  <li>
     <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Twitter" onclick="javascript:genericSocialShare('http://twitter.com/share?url=<?php echo $base_url.'/social-share-twitter/'.$post_id;?>&amp;text=Social media sharing my bet')">
     <i class="fa fa-twitter" aria-hidden="true"></i>
     </a>
  </li>
      <div class="clearfix"></div>
  </ul>
</div>
<div class="comment_section">
    <div id="SeeComments<?php echo $post_id; ?>">
        <?php
        if(!empty($FetchComments))
        {
            foreach($FetchComments as $key=>$Comments)
            {
                //$user_id = Session::get('user_id');
                $user_name = Users::where('id',$Comments['user_id'])->get()->toArray();
                if(!empty($user_name))
                {
        ?>
        <div class="comment_wrap">
            <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>">
            <?php if(empty($user_name[0]['profile_picture'])) { ?>
                <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
            <?php } else{ ?>
                <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$user_name[0]['profile_picture']; ?>"/>
            <?php } ?>
            </a>
            <div class="">
                <p>
                    <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>"><?php echo $user_name[0]['name']; ?> </a>
                    <span><?php echo $PostingTime = date("h:i:sa, d.m.Y",strtotime($Comments['creation_date']))?></span>
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
                    <?php }elseif($GetPostedUserId[0]['user_id'] == $user_id){ ?>
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
                      <?php
                      $GetCountOfLikeOnComment = comment_likes::where('post_id',$post_id)->where('comment_id',$Comments['id'])->get()->toArray();
                      $CheckloggedUserLikeReply = comment_likes::where('post_id',$post_id)->where('from_user_id',$user_id)->get()->toArray();
                      $GetCountOnLike = count($GetCountOfLikeOnComment);
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
                        <li class="<?php if(!empty($CheckloggedUserLikeReply)) { echo "active"; } ?>">
                             <i id="likepost" class="likepost_hover">
                                <?php echo $GetCountOnLike; ?>
                                <div class="live_user">
                                   <button type="button" data-toggle="modal" data-target="#LikeViewModalForComment" onclick="PeopleLikeDeatilsOnComment('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>')">People who liked</button>
                                </div>
                             </i>
                             <a href="javascript:void(0);" onclick="NewsFeedCommentsLikes('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')"> <i class="fa fa-thumbs-up" aria-hidden="true"></i> <?php if($GetCountOnLike == 1) {echo "Like"; }else{ echo "Likes"; }?> </a>
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
                <?php if(empty($user_name[0]['profile_picture'])) { ?>
                    <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                <?php } else{  ?>
                    <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$user_name[0]['profile_picture']; ?>"/>
                <?php } ?>
                </a>
                <p>
                <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>"> <?php echo $user_name[0]['name']; ?> </a>
                <span><?php echo $PostingTime = date("h:i:sa, d.m.Y",strtotime($CommentValue['creation_date']))?></span>
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
               <?php }elseif($GetPostedUserId[0]['user_id'] == $user_id || $Comments['user_id'] == $user_id) { ?>
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
        <div class="SubCommentsInput" style="display: none;" id="SubComments<?php echo $Comments['id']; ?>">
            <?php //$user_id = Session::get('user_id');
            $logged_in_user_name = Users::select('id','name','profile_picture')->where('id',$user_id)->get()->toArray();
            if(empty($logged_in_user_name[0]['profile_picture'])) { ?>
                <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
            <?php } else{  ?>
                <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$logged_in_user_name[0]['profile_picture']; ?>"/>
            <?php } ?>
            <form id="SubCommentForm<?php echo $Comments['id']; ?>" action="javascript:void(0);" autocomplete="off">
                <input class="form-control input" type="text" name="ReplyComment" id="GetReply<?php echo $Comments['id']; ?>" placeholder="Add a Comment ..." onkeyup="SubCommentBlockId(event,<?php echo $Comments['id']; ?>)"/>
                <button type="button" style="display: block;" id="SubCommentButton<?php echo $Comments['id']; ?>" value="post" onclick="GetSubComments('<?php echo $post_id; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>','<?php echo $GetPostedUserId[0]['user_id']; ?>')"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </form>
        </div>
       <!-- replied against comment end -->
        <?php
                }
            }
            if($GetCount > 2)
            {
        ?>
        <a class="Comment_SeeAll" href="javascript:void(0);" id="Comments<?php echo $post_id; ?>" onclick="SeeAllComments('<?php echo $post_id; ?>')" >See All Comments</a>
        <?php

            }
        }
        ?>
    </div>
    <form id="CommentForm" action="javascript:void(0);" autocomplete="off">
    <input class="form-control" type="text" name="comment" id="comment<?php echo $post_id; ?>" placeholder="Add a Comment ..." onkeyup="PasingBlockId(event,<?php echo $post_id; ?>)"/>
    <button type="button" style="display: block;" id="CommentButton<?php echo $post_id;?>" value="post" onclick="GetComments('<?php echo $post_id; ?>','<?php echo $GetPostedUserId[0]['user_id'];?>')">
    <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </form>
</div>
<div class="dropdown feed_more">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
  <img src="{{asset('assets/front_end/images/arrow_down.png')}}"/>
  </a>
  <ul class="dropdown-menu" role="menu">
    <li><a data-toggle="modal" data-target="#report_abuse" href="#" onclick="setPostId('<?php echo $post_id; ?>')">Report</a></li>
  </ul>
</div>
<script>
function PasingBlockId(e,BlockId)
{
    if (e.keyCode == 13) {
        $("#CommentButton"+BlockId).trigger("click");
    }
}
</script>
<script type="text/javascript">
function genericSocialShare(url){
    var path="{{url('point-for-social-share')}}";
    $.ajax({
        type: "GET",
        url: path,
        success: function(result)
        {
          //console.log(result);
            
        }
     });
    window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
    return true;
}
</script>
