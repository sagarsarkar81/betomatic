<!-- for responsive feed -->
<?php
use App\Users;
use App\news_feeds;
use App\news_feed_likes;
use App\news_feed_comments;
use App\bet_place_histories;
use App\comment_likes;
use App\comment_replies;

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
$user_id = Session::get('user_id');
if(!empty($FeedData))
{
  foreach($FeedData as $blockLeftKey => $blockLeftValue)
  {
 ?>
    <div class="col-sm-12 feed_left" id="leftData<?php echo $blockLeftValue['id']; ?>">
      <div class="feed_wrapper">
         <?php
            $GetUserData = Users::select('name','profile_picture')->where('id',$blockLeftValue['user_id'])->get()->toArray();
            $time = strtotime($blockLeftValue['match_betting_date']);
            /****************Checking copied post****************************/
            if($blockData['copied_post_id'] != NULL)
            {
              //$GetUserId = news_feeds::select('user_id')->where('id',$blockData[copied_post_id])->get()->toArray();
              //$GetUserName = Users::select('name')->where('id',$GetUserId[0]['user_id'])->get()->toArray();
            ?>
         <div class="copyItem" id="CopyComments<?php echo $blockData['id']; ?>"><?php echo 'Copied from '.$GetUserName[0]['name'];?></div>
         <?php
            }
            /*********************************************************************/
            ?>
         <div class="feed_content_wrapper">
            <div id="BetSlipSetteled<?php echo $blockLeftValue['id']; ?>" style="display: none;"></div>
            <div class="feed_profile_details">
               <div class="feed_img">
                  <?php
                 if($GetUserData[0]['profile_picture'] =='')
                 {
                 ?>
                  <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                  <?php
                     }else{
                     ?>
                  <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$GetUserData[0]['profile_picture']; ?>" />
                  <?php
                     }
                     ?>
               </div>
               <div class="feed_user_name">
                  <a href="{{url('visit-user-profile')}}/<?php echo $blockData['user_id']; ?>">
                     <h4><?php echo $GetUserData[0]['name']; ?> <?php //echo $blockData[id]; ?> <span><?php echo humanTiming($time).' ago'; ?></span></h4>
                  </a>
               </div>
            </div>
            <?php
               foreach($blockLeftValue['details'] as $blockData)
               {
            ?>
            <div class="feed_body">
               <h4><?php echo $blockData['home_team'] .' vs '. $blockData['away_team']; ?></h4>
               <p>Match Betting : <span><?php echo $MatchbettingDate = date("jS F",strtotime($blockData['match_betting_date'])) .'|'. date("H:i",strtotime($blockData['match_betting_date'])) ;?></span></p>
               <!-- difference according to odds -->
               <?php if($blockData['Odds_type'] == 'Home'){ ?>
               <h3><?php echo $blockData['home_team']; ?><span>@<?php echo $blockData['odds_value']; ?></span></h3>
               <?php }elseif($blockData['Odds_type'] == 'Draw'){ ?>
               <h3><?php echo $blockData['home_team']; ?> | <?php echo $blockData['away_team']; ?> <span>@<?php echo $blockData['odds_value']; ?></span></h3>
               <?php }elseif($blockData['Odds_type'] == 'Away'){ ?>
               <h3><?php echo $blockData['away_team']; ?><span>@<?php echo $blockData['odds_value']; ?></span></h3>
               <?php } else { ?>
               <h3><?php echo $blockData['Odds_type']; ?><span>@<?php echo $blockData['odds_value']; ?></span></h3>
               <?php } ?>
            </div>
            <?php
               }
            ?>
            <div class="feed_chart">
               <p class="BettingSlipComment"><i class="fa fa-comments" aria-hidden="true"></i> <?php echo $blockLeftValue['bet_text']; ?></p>
               <h3>Return <span>@<?php echo number_format($blockData['total_return'], 2, '.', ''); ?></span></h3>
            </div>
            <!-- difference according to odds end -->
         </div>
         <div id="ajaxpostdata<?php echo $blockData['id']; ?>">
            <div class="feed_social_wrap">
               <ul class="feed_social">
                  <!-- count like -->
                  <?php
                     $CountLikes = news_feed_likes::where('post_id',$blockData['id'])->get()->toArray();
                     $GetCountLikes = count($CountLikes);
                     if($GetCountLikes == 0)
                     {
                     ?>
                  <li>
                     <a data-toggle="tooltip" data-placement="top" title="Like" href="javascript:void(0);" onclick="NewsFeedLikes('<?php echo $blockData['id']; ?>','<?php echo $blockData['user_id']; ?>')">
                     0
                     <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                     </a>
                  </li>
                  <?php }else{
                     $CheckLoggedUserMakeLike = news_feed_likes::where('post_id',$blockData['id'])->where('user_id',$user_id)->get()->toArray();
                     ?>
                  <li class="<?php if(!empty($CheckLoggedUserMakeLike)) { echo "active"; } ?>">
                     <i id="likepost" class="likepost_hover">
                        <?php echo $GetCountLikes;?>
                        <div class="live_user">
                           <button type="button" data-toggle="modal" data-target="#LikeViewModal" onclick="PeopleLikeDeatils('<?php echo $blockData['id']; ?>')">People who liked</button>
                        </div>
                     </i>
                     <a data-toggle="tooltip" data-placement="top" title="Like" href="javascript:void(0);" onclick="NewsFeedLikes('<?php echo $blockData['id']; ?>','<?php echo $blockData['user_id']; ?>')">
                     <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                     </a>
                  </li>
                  <?php } ?>
                  <!-- count like -->
                  <!-- count comment -->
                  <?php
                     $CountComments = news_feed_comments::where('post_id',$blockData['id'])->get()->toArray();
                     $GetCount = count($CountComments);
                     if($GetCount == 0)
                     {
                     ?>
                  <li>
                     <a data-toggle="tooltip" data-placement="top" title="Comment"  href="javascript:void(0);"> <?php echo $GetCount; ?> <i class="fa fa-comments" aria-hidden="true"></i></a>
                  </li>
                  <?php
                     }else{
                         $CheckLoggedUserMakeComment = news_feed_comments::where('post_id',$blockData['id'])->where('user_id',$user_id)->get()->toArray();
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
                  <?php
                     $GetCountDetails = news_feeds::where('copied_post_id',$blockData['id'])->get()->toArray();
                     $CountNumber = count($GetCountDetails);
                     if($CountNumber == 0)
                     {
                     ?>
                  <li class="Copy<?php echo $blockData['id']; ?>" id="RemoveClass<?php echo $blockData['id']; ?>">
                     <a data-toggle="tooltip" data-placement="top" title="Copy" href="javascript:void(0);" onclick="BetSlipCopy(<?php echo $blockData['id']; ?>)">
                     <i id="CountCopy<?php echo $blockData['id']; ?>">0</i>
                     <i class="fa fa-clone" aria-hidden="true"></i>
                     </a>
                  </li>
                  <?php
                     }else{
                     ?>
                  <li class="Copy<?php echo $blockData['id']; ?> active" id="RemoveClass<?php echo $blockData['id']; ?>">
                     <a data-toggle="tooltip" data-placement="top" title="Copy" href="javascript:void(0);" onclick="BetSlipCopy(<?php echo $blockData['id']; ?>)" style="pointer-events:none">
                     <i id="CountCopy<?php echo $blockData['id']; ?>"><?php echo $CountNumber;?></i>
                     <i class="fa fa-clone" aria-hidden="true"></i>
                     </a>
                  </li>
                  <?php
                     }
                     ?>
                  <li>
                     <a data-toggle="tooltip" data-placement="top" title="Facebook"  href="javascript:void(0)" class="icon-fb" onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo urlencode($base_url.'/social-share-facebook/'.$blockData['id']); ?>')">
                     <i class="fa fa-facebook" aria-hidden="true"></i>
                     </a>
                  </li>
                  <li>
                     <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Twitter" onclick="javascript:genericSocialShare('http://twitter.com/share?url=<?php echo $base_url.'/social-share-twitter/'.$blockData['id'];?>&amp;text=Social media sharing my bet')">
                     <i class="fa fa-twitter" aria-hidden="true"></i>
                     </a>
                  </li>
                  <div class="clearfix"></div>
               </ul>
            </div>
            <div class="comment_section">
               <div class="Search_loader" style="display: none;" id="CommentLoader<?php echo $blockData['id']; ?>">
                  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
               </div>
               <div id="SeeComments<?php echo $blockData['id']; ?>">
                  <?php
                     $FetchComments = news_feed_comments::where('post_id',$blockData['id'])->orderBy('creation_date','DESC')->limit(2)->get()->toArray();
                     $CountComments = news_feed_comments::where('post_id',$blockData['id'])->get()->toArray();
                     $GetCount = count($CountComments);
                     if(!empty($FetchComments))
                     {
                         foreach($FetchComments as $key=>$Comments)
                         {
                             $user_name = Users::select('id','name','profile_picture')->where('id',$Comments['user_id'])->get()->toArray();
                     ?>
                  <div class="comment_wrap">
                     <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>">
                     <?php if(empty($user_name[0]['profile_picture'])) { ?>
                     <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                     <?php } else{  ?>
                     <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$user_name[0]['profile_picture']; ?>"/>
                     <?php } ?>
                     </a>
                     <div class="">
                        <p>
                           <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>"> <?php echo $user_name[0]['name']; ?> </a>
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
                              <li><a data-toggle="modal" data-target="#EditCommentModal" href="javascript:void(0);" onclick="DisplayEditCommentModal('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>')">Edit</a></li>
                              <li><a href="javascript:void(0);" onclick="DeleteComments('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>')">Delete</a></li>
                           </ul>
                        </div>
                        <?php }elseif($blockData['user_id'] == $user_id){ ?>
                        <div class="dropdown feed_more">
                           <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                           <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                           </a>
                           <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                              <li><a href="javascript:void(0);" onclick="DeleteComments('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>')">Delete</a></li>
                           </ul>
                        </div>
                        <?php } ?>
                        <!-- End edit and delete -->
                        </p>
                        <!-- Comment reply activity  -->
                        <div class="comment_reply_activity">
                           <ul>
                              <?php
                                 $GetCountOfLikeOnComment = comment_likes::where('post_id',$blockData['id'])->where('comment_id',$Comments['id'])->get()->toArray();
                                 $CheckloggedUserLikeReply = comment_likes::where('from_user_id',$user_id)->get()->toArray();
                                 $GetCountOnLike = count($GetCountOfLikeOnComment);
                                 if($GetCountOnLike == 0)
                                 {
                                 ?>
                              <li class="">
                                 <i id="likepost" class="likepost_hover">
                                 <?php echo $GetCountOnLike; ?>
                                 </i>
                                 <a href="javascript:void(0);" onclick="NewsFeedCommentsLikes('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')">  <i class="fa fa-thumbs-up" aria-hidden="true"></i> Like</a>
                              </li>
                              <?php
                                 }else{
                                 ?>
                              <li class="<?php if(!empty($CheckloggedUserLikeReply)) { echo "active"; } ?>">
                                 <i id="likepost" class="likepost_hover">
                                    <?php echo $GetCountOnLike; ?>
                                    <div class="live_user">
                                       <button type="button" data-toggle="modal" data-target="#LikeViewModalForComment" onclick="PeopleLikeDeatilsOnComment('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>')">People who liked</button>
                                    </div>
                                 </i>
                                 <a href="javascript:void(0);" onclick="NewsFeedCommentsLikes('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')">  <i class="fa fa-thumbs-up" aria-hidden="true"></i> <?php if($GetCountOnLike == 1) { echo "Like"; }else{ echo "Likes"; }?></a>
                              </li>
                              <?php
                                 }
                                 ?>
                              <?php $GetCountOfReplyOnComment = comment_replies::where('post_id',$blockData['id'])->where('comment_id',$Comments['id'])->get()->toArray(); $GetCountOnReply = count($GetCountOfReplyOnComment);
                                 if($GetCountOnReply == 0)
                                 {
                                 ?>
                              <li>
                                 <a href="javascript:void(0);" onclick="SubCommentReply('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')"> <?php echo $GetCountOnReply; ?>  <i class="fa fa-reply-all" aria-hidden="true"></i> Reply </a>
                              </li>
                              <?php }else{?>
                              <li class="active">
                                 <a href="javascript:void(0);" onclick="SubCommentReply('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>')"> <?php echo $GetCountOnReply; ?>  <i class="fa fa-reply-all" aria-hidden="true"></i> <?php if($GetCountOnReply == 1) { echo "Reply" ; }else{ echo "Replies"; }?> </a>
                              </li>
                              <?php } ?>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <!-- Comment reply -->
                  <?php
                     $GetReplyAgainstComment = comment_replies::where('post_id',$blockData[id])->where('comment_id',$Comments['id'])->get()->toArray();
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
                        <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0]['id']; ?>"> <?php echo $user_name[0]['name']; ?></a>
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
                           <li><a data-toggle="modal" data-target="#ReplyModal" href="javascript:void(0);" onclick="DisplayOldReply('<?php echo $blockData['id']; ?>','<?php echo $CommentValue['comment_id']; ?>','<?php echo $CommentValue['id']; ?>')">Edit</a></li>
                           <li><a href="javascript:void(0);" onclick="DeleteReply('<?php echo $blockData['id']; ?>','<?php echo $CommentValue['id']; ?>')">Delete</a></li>
                        </ul>
                     </div>
                     <?php }elseif($blockData['user_id'] == $user_id || $Comments['user_id'] == $user_id) { ?>
                     <div class="dropdown feed_more">
                        <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                           <li><a href="javascript:void(0);" onclick="DeleteReply('<?php echo $blockData['id']; ?>','<?php echo $CommentValue['id']; ?>')">Delete</a></li>
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
                  <div class="SubCommentsInput" style="display: none;" id="SubComments<?php echo $Comments[id]; ?>">
                     <?php $user_id = Session::get('user_id');
                        $logged_in_user_name = Users::select('id','name','profile_picture')->where('id',$user_id)->get()->toArray();
                        if(empty($logged_in_user_name[0]['profile_picture'])) { ?>
                     <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                     <?php } else{  ?>
                     <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$logged_in_user_name[0]['profile_picture']; ?>"/>
                     <?php } ?>
                     <form id="SubCommentForm<?php echo $Comments['id']; ?>" action="javascript:void(0);" autocomplete="off">
                        <input class="form-control input" type="text" name="ReplyComment" id="GetReply<?php echo $Comments['id']; ?>" placeholder="Add a Comment ..." onkeyup="SubCommentBlockId(event,<?php echo $Comments['id']; ?>)"/>
                        <button type="button" style="display: block;" id="SubCommentButton<?php echo $Comments['id'];; ?>" value="post" onclick="GetSubComments('<?php echo $blockData['id']; ?>','<?php echo $Comments['id']; ?>','<?php echo $Comments['user_id']; ?>','<?php echo $blockData['user_id']; ?>')"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                     </form>
                  </div>
                  <!-- replied against comment end -->
                  <?php
                     }
                     ?>
                  <?php
                     if($GetCount > 2)
                     {
                     ?>
                  <a class="Comment_SeeAll" href="javascript:void(0);" id="Comments<?php echo $blockData['id']; ?>" onclick="SeeAllComments('<?php echo $blockData['id']; ?>')" >See All Comments</a>
                  <?php
                     }
                     }
                     ?>
               </div>
               <form id="CommentForm" action="javascript:void(0);" autocomplete="off">
                  <input class="form-control input" type="text" name="comment" id="comment<?php echo $blockData['id']; ?>" placeholder="Add a Comment ..." onkeyup="PasingBlockId(event,<?php echo $blockData['id']; ?>)"/>
                  <button type="button" style="display: block;" id="CommentButton<?php echo $blockData['id']; ?>" value="post" onclick="GetComments('<?php echo $blockData['id']; ?>','<?php echo $blockData['user_id']; ?>')"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
               </form>
            </div>
         </div>
         <!--div class="dropdown feed_more">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <img src="{{asset('assets/front_end/images/arrow_down.png')}}"/>
            </a>
            <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
               <li><a data-toggle="modal" data-target="#report_abuse" href="javascript:void(0);" onclick="setPostId('<?php echo $blockData['id']; ?>')">Report</a></li>
            </ul>
            </div-->
      </div>
   </div>
 <?php
 } }
 ?>
 <div class="feed_loader" style="display: none;" id="body_loader">
    <img src="{{asset('assets/front_end/images/spinner.gif')}}"/>
 </div>
 <!-- end -->
 <script src="{{asset('assets/front_end/js/dropdownanimation.js')}}" type="text/javascript"></script>
 <script>
 function PasingBlockId(e,BlockId)
 {
    if (e.keyCode == 13) {
        $("#CommentButton"+BlockId).trigger("click");
    }
 }
</script>
