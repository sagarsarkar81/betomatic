<?php
use App\trending_posts;
use App\trending_replies;
use App\trending_actions;


if(!empty($GetTrendingPost))
{
    foreach($GetTrendingPost as $keyPost=>$valuePost)
    {
        $GetUserCredentials = trending_posts::select('name','profile_picture')->leftJoin('users', 'users.id', '=', 'trending_posts.posted_user_id')->where('posted_user_id',$valuePost[posted_user_id])->get()->toArray();
?>
<div class="post_box" id="PostId<?php echo $valuePost[id]; ?>">
   <div class="post_area_wrap">
    <div class="col-md-1 col-sm-2 col-xs-2 count">
    <?php if(empty($GetUserCredentials[0][profile_picture])) { ?>
    <img src="{{asset('assets/front_end/images/avatar.jpg')}}" alt=""/>
    <?php }else{ ?>
     <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$GetUserCredentials[0][profile_picture]; ?>" alt=""/>
    <?php } ?>
    </div>
    <div class="post_area col-md-10 col-sm-8 col-xs-8">
        <div class="post-title"><?php echo $valuePost[posted_text]; ?></div>
        <div class="clearfix"></div>
        <span class="posted_on"><label>Posted On :</label> <?php echo date("d-m-Y",strtotime($valuePost[posted_date])); ?> </span> <span class="posted_by"><label>Posted By : </label> <?php if(!empty($GetUserCredentials)){ echo $GetUserCredentials[0][name]; } ?></span>
        <div class="clearfix"></div>
        <div class="post-content"><?php if(!empty($valuePost[post_description])) { echo $valuePost[post_description]; } ?></div>
    </div> 
    <div class="col-md-1 col-sm-2 col-xs-2 comment_count">
        <span class="fa-stack fa-3x">
        <i class="fa fa-comment-o fa-stack-2x"></i>
        <strong class="fa-stack-1x fa-stack-text fa-inverse">
        <?php
        $GetCountOfReplies = trending_replies::where('trending_post_id',$valuePost[id])->count('trending_post_id');
        echo $GetCountOfReplies;
        ?>
        </strong>
        </span>
    </div>
    </div> 
    <div class="clearfix"></div>
    <div class="reply_share_block" id="PostData<?php echo $valuePost[id]; ?>">
        <div class="reply pull-left" id="OpenModal-<?php echo $valuePost[id]; ?>"onclick="OpenReplyModal('<?php echo $valuePost[id]; ?>')">Reply</div>
        <!---------Trending likes------------------------->
        <?php $GetLikesCount = trending_actions::where('post_id',$valuePost[id])->where('likes','1')->count('likes'); if($GetLikesCount == 0) { ?>
        <div class="upvote pull-left" id="TrendingLike<?php echo $valuePost[id]; ?>" onclick="LikesPost('<?php echo $valuePost[id]; ?>','<?php echo $valuePost[posted_user_id]; ?>')">0
        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
        </div>
        <?php }else { 
        $user_id = Session::get('user_id');
        $CheckUserLikePost = trending_actions::where('post_id',$valuePost[id])->where('from_user_id',$user_id)->where('likes','1')->get()->toArray(); 
        if(!empty($CheckUserLikePost))
        {
        ?>
        <div class="upvote pull-left active" >
        <i id="" class="liketrending_hover">
            <?php echo $GetLikesCount; ?>
            <div class="live_user">
                <button type="button" data-toggle="modal" data-target="#LikeViewModal" onclick="TrendingPeopleLikeDetails('<?php echo $valuePost[id]; ?>')">People who liked</button>
            </div> 
        </i>
        <span style="pointer-events: none;" onclick="LikesPost('<?php echo $valuePost[id]; ?>','<?php echo $valuePost[posted_user_id]; ?>')" class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
        </div>
        <?php }else{
        ?>
        <div class="upvote pull-left">
        <i id="" class="liketrending_hover">
            <?php echo $GetLikesCount; ?>
            <div class="live_user">
                <button type="button" data-toggle="modal" data-target="#LikeViewModal" onclick="TrendingPeopleLikeDetails('<?php echo $valuePost[id]; ?>')">People who liked</button>
            </div> 
        </i>
        <span class="glyphicon glyphicon-thumbs-up" onclick="LikesPost('<?php echo $valuePost[id]; ?>','<?php echo $valuePost[posted_user_id]; ?>')" aria-hidden="true"></span>
        </div>
        <?php } } ?>
        <!------------------------------------------------>
        <!--------------------Dislikes------------------------->
        <?php 
        $GetDislikeCount = trending_actions::where('post_id',$valuePost[id])->where('dislikes','1')->count('dislikes'); 
        if($GetDislikeCount == 0) {
        ?>
        <div class="upvote pull-left" onclick="DislikePost('<?php echo $valuePost[id]; ?>','<?php echo $valuePost[posted_user_id]; ?>')">0
        <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
        </div>
        <?php } else{ 
        $user_id = Session::get('user_id');
        $CheckUserDisLikePost = trending_actions::where('post_id',$valuePost[id])->where('from_user_id',$user_id)->where('dislikes','1')->get()->toArray(); 
        if(!empty($CheckUserDisLikePost))
        {
        ?>
        <div class="upvote pull-left active" style="pointer-events: none;" onclick="DislikePost('<?php echo $valuePost[id]; ?>','<?php echo $valuePost[posted_user_id]; ?>')">
        <?php echo $GetDislikeCount; ?>
        <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
        </div>
        <?php }else{ ?>
        <div class="upvote pull-left"  onclick="DislikePost('<?php echo $valuePost[id]; ?>','<?php echo $valuePost[posted_user_id]; ?>')">
        <?php echo $GetDislikeCount; ?>
        <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
        </div>
        <?php } } ?>
        <!---------------------------------------------------------->
        <div class="upvote pull-left">
        <?php 
        //$GetBitcoinsCount = trending_actions::where('to_user_id',$valuePost[posted_user_id])->where('post_id',$valuePost[id])->where('bitcoins','1')->count('bitcoins'); 
        $GetBitcoinsCount = trending_actions::where('post_id',$valuePost[id])->where('bitcoins','1')->count('bitcoins'); 
        ?>
        <?php if(!empty($GetBitcoinsCount)) { echo $GetBitcoinsCount; } ?> <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span>
        </div>
        <div class="social pull-right">
        <ul>
           <li class="facebook"><a href="javascript:void(0);" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo urlencode('http://127.0.0.1:8000/Social-Share-Trending').'/'.$valuePost[id];?>')"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
           <li class="twitter"><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
           <li class="googleplus"><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
        </ul>
        </div>
        <div class="share pull-right"><strong>0</strong> Share</div>
    </div>
    <div class="clearfix"></div>
    <div id="DisplayRepliedComments<?php echo $valuePost[id]; ?>">
    <!----------------get replied comments--------------------------------->
    <?php
    if(!empty($GetRepliedComments))
    {
        foreach($GetRepliedComments as $key=>$value)
        {
            if($valuePost[id] == $value[trending_post_id])
            {
                $GetUserdetails = trending_replies::select('name','profile_picture','replied_user_id')->leftJoin('users', 'users.id', '=', 'trending_replies.replied_user_id')->where('replied_user_id',$value[replied_user_id])->get()->toArray();
    ?>
        <div class="trending_comment_wrap">
        <?php if(empty($GetUserdetails[0][profile_picture])) { ?>
        <img src="{{asset('assets/front_end/images/avatar.jpg')}}" alt=""/>
        <?php }else{ ?>
         <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$GetUserdetails[0][profile_picture]; ?>"/>
        <div class="trending_comment">
        <?php } ?>
        <div class="trending_comment">
            <h3><a href="{{url('visit-user-profile')}}/<?php echo $GetUserdetails[0][replied_user_id]; ?>"><?php echo $GetUserdetails[0][name]; ?> </a><span><?php echo date("d-m-Y H:i:s",strtotime($value[replied_date])); ?></span></h3>
            <p><?php echo $value[replied_text]; ?></p>
        </div>
        </div>
       </div> 
    <?php
            }   
        }
    }
    ?>
    <!--------------------------------------------------------------------->
    </div>
    <div class="reply_box reply_box<?php echo $valuePost[id]; ?>" id="OpenBox-<?php echo $valuePost[id]; ?>">
        <form method="post" action="javascript:void(0);" id="reply">
        <textarea placeholder="Write your reply..." class="reply_content" id="ReplyText<?php echo $valuePost[id]; ?>"></textarea>
        <button type="submit" class="reply_button" onclick="ReplyFormSubmit('<?php echo $valuePost[id]; ?>','<?php echo $valuePost[posted_user_id];?>')">Reply</button>
        </form>
    </div>
</div>
<?php 
    }
}else{
?>
<div> No post available</div>
<?php
}
?>
<script>
function ReplyFormSubmit(postId,PostedUserId)
{
    var replytText = $("#ReplyText"+postId).val();
    $.ajax({
        type: "POST",
        url: "{{url('reply-form-submit')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'postId':postId,'replyText':replytText,'PostedUserId':PostedUserId},
        success: function(result)
        {
            //console.log(result);
            location.reload();
        }
    });
}
</script>