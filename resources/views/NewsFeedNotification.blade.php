<?php
use App\Users;
use App\news_feeds;
use App\comment_likes;
use App\comment_replies;
use App\bet_place_histories;
use App\news_feed_likes;
use App\news_feed_comments;

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
    $time = strtotime($GetFeedDetails[0][creation_date]);
}
$user_id = Session::get('user_id');
?>
@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header')
   @if (session('status'))
   <div class="alert alert-danger" style="text-align:center">
      {{ session('status') }}
   </div>
   @endif
   @if (session('success'))
   <div class="alert alert-success" style="text-align:center">
      {{ session('success') }}
   </div>
   @endif
   <!-- Page body content -->
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-sm-7" id="content">
            <div class="loader" style="display: none;" id="body_loader">
               <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
            </div>
            <div class="notification-section">
               <div class="ns-hd">Notifications</div>
               <div class="ns-content-container">
                  <div class="ns-c-notifrow">
                     <div class="ns-c-notifrow-date"><?php if(!empty($GetNotificationDetails)) { echo date("j M Y",strtotime($GetNotificationDetails[0][creation_date])); } ?></div>
                     <div class="ns-c-notifrow-event">
                     <a href="javascript:void(0);">
                        <i class="fa fa-thumbs-up"></i>
                        <div class="ns-c-notifrow-event-msg"><span><?php if(!empty($GetNotificationDetails)) { echo $GetNotificationDetails[0][text]; } ?></span></div>
                     </a>
                     </div>
                  </div>
               </div>
               <br/>
               <div class="col-md-6 col-md-offset-3">
                  <div class="feed_content_wrapper NotificationPost">
                  <?php
                  /****************Checking copied post****************************/
                  if(!empty($GetFeedDetails))
                  {
                      if($GetFeedDetails[0][copied_post_id] != NULL)
                      {
                        $GetUserId = news_feeds::select('user_id')->where('id',$GetFeedDetails[0][copied_post_id])->get()->toArray();
                        $GetUserName = Users::select('name')->where('id',$GetUserId[0]['user_id'])->get()->toArray();
                      ?>
                        <div class="copyItem" id="CopyComments<?php echo $IncidentId; ?>"><?php echo 'Copied from '.$GetUserName[0][name];?></div>
                      <?php
                      }
                  }
                  /*********************************************************************/
                  ?>

                    <div id="BetSlipSetteled<?php echo $post_id; ?>" style="display: none;"></div>
                     <div class="feed_profile_details">
                        <div class="feed_img">
                        <?php if(empty($GetUserDetails[0][profile_picture])) { ?>
                            <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                        <?php }else{ ?>
                            <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$GetUserDetails[0][profile_picture]; ?>"/>
                        <?php } ?>
                        </div>
                        <div class="feed_user_name">
                           <a href="{{url('visit-user-profile')}}/<?php echo $GetUserDetails[0][id]; ?>">
                              <h4><?php if(!empty($GetUserDetails)) { echo $GetUserDetails[0][name]; } ?>  <span><?php $time = strtotime($GetFeedDetails[0][creation_date]); echo humanTiming($time).' ago'; ?></span></h4>
                              <!--p>Place a bet via ladbrokers</p-->
                           </a>
                        </div>
                     </div>
                     <?php
                     $GetData = news_feeds::where('bet_id',$GetFeedDetails[0]['bet_id'])->get()->toArray();
                     foreach($GetData as $Blockdata)
                     {
                     ?>
                     <div class="feed_body">
                        <h4><?php if(!empty($Blockdata)) { echo $Blockdata[home_team].' vs '.$Blockdata[away_team]; } ?></h4>
                        <p>Match Betting : <span><?php echo $MatchbettingDate = date("jS F",strtotime($Blockdata[match_betting_date])) .'|'. date("H:i",strtotime($Blockdata[match_betting_date])) ;?></span></p>
                        <?php if($Blockdata[Odds_type] == 'Home'){ ?>
                           <h3><?php echo $Blockdata[home_team]; ?><span>@<?php echo $Blockdata[odds_value]; ?></span></h3>
                           <?php }elseif($Blockdata[Odds_type] == 'Draw'){ ?>
                           <h3><?php echo $Blockdata[home_team]; ?> | <?php echo $Blockdata[away_team]; ?> <span>@<?php echo $Blockdata[odds_value]; ?></span></h3>
                           <?php }elseif($Blockdata[Odds_type] == 'Away'){ ?>
                           <h3><?php echo $Blockdata[away_team]; ?><span>@<?php echo $Blockdata[odds_value]; ?></span></h3>
                           <?php } else { ?>
                           <h3><?php echo $Blockdata[Odds_type]; ?><span>@<?php echo $Blockdata[odds_value]; ?></span></h3>
                        <?php } ?>
                     </div>
                     <?php
                     }
                     ?>
                     <!-- difference according to odds -->
                      <div class="feed_chart">
                        <h3>Return <span>@<?php echo number_format($GetFeedDetails[0][total_return], 2, '.', ''); ?></span></h3>
                      </div>
                     <!-- difference according to odds end -->
                    </div>
                    <div id="ajaxpostdata<?php echo $post_id; ?>">
                        <div class="feed_social_wrap">
                           <ul class="feed_social">
                              <!-- count like -->
                              <?php
                              $CountLikes = news_feed_likes::where('post_id',$post_id)->get()->toArray();
                              $GetCountLikes = count($CountLikes);
                              if($GetCountLikes == 0)
                              {
                              ?>
                                <li>
                                   <a data-toggle="tooltip" data-placement="top" title="Like"  href="javascript:void(0);" onclick="NewsFeedLikes('<?php echo $post_id; ?>','<?php echo $GetFeedDetails[0][user_id]; ?>')">
                                     0
                                     <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                   </a>
                                </li>
                              <?php } else {
                              $CheckLoggedUserMakeLike = news_feed_likes::where('post_id',$post_id)->where('user_id',$user_id)->get()->toArray();
                              ?>
                              <li class="<?php if(!empty($CheckLoggedUserMakeLike)) { echo "active"; } ?>">
                               <i id="likepost" class="likepost_hover">
                                     <?php echo $GetCountLikes;?>
                                     <div class="live_user">
                                     <button type="button" data-toggle="modal" data-target="#LikeViewModal" onclick="PeopleLikeDeatils('<?php echo $post_id; ?>')">People who liked</button>
                                     </div>
                               </i>
                               <a data-toggle="tooltip" data-placement="top" title="Like" href="javascript:void(0);" onclick="NewsFeedLikes('<?php echo $post_id; ?>','<?php echo $GetFeedDetails[0][user_id]; ?>')">
                                 <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                               </a>
                             </li>
                             <?php } ?>
                              <!-- count like -->
                              <!-- count comment -->
                              <?php
                              //$CountComments = news_feed_comments::where('post_id',$post_id)->get()->toArray();
                              //$GetCount = count($CountComments);
                              if($GetCount == 0)
                              {
                              ?>
                              <li>
                                 <a data-toggle="tooltip" data-placement="top" title="Comment"  href="javascript:void(0);"> <?php echo $GetCount; ?> <i class="fa fa-comments" aria-hidden="true"></i></a>
                              </li>
                              <?php
                              }else{
                                  $CheckLoggedUserMakeComment = news_feed_comments::where('post_id',$post_id)->where('user_id',$user_id)->get()->toArray();
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
                              $GetCountDetails = news_feeds::where('copied_post_id',$post_id)->get()->toArray();
                              $CountNumber = count($GetCountDetails);
                              if($CountNumber == 0)
                              {
                              ?>
                                <li class="Copy<?php echo $post_id; ?>" id="RemoveClass<?php echo $post_id; ?>">
                                   <a data-toggle="tooltip" data-placement="top" title="copy"  href="javascript:void(0);" onclick="BetSlipCopy(<?php echo $post_id; ?>)">
                                     <i id="CountCopy<?php echo $post_id; ?>">0</i>
                                     <i class="fa fa-clone" aria-hidden="true"></i>
                                   </a>
                                </li>
                              <?php
                              }else{
                              ?>
                                <li class="Copy<?php echo $post_id; ?> active" id="RemoveClass<?php echo $post_id; ?>">
                                   <a data-toggle="tooltip" data-placement="top" title="copy"  href="javascript:void(0);" onclick="BetSlipCopy(<?php echo $post_id; ?>)" style="pointer-events:none">
                                     <i id="CountCopy<?php echo $post_id; ?>"><?php echo $CountNumber;?></i>
                                     <i class="fa fa-clone" aria-hidden="true"></i>
                                   </a>
                                </li>
                              <?php
                              }
                              ?>
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
                              <!-- li>
                                 <a href="#">
                                 <i class="fa fa-share-alt" aria-hidden="true"></i>
                                 </a>
                              </li -->
                              <div class="clearfix"></div>
                           </ul>
                        </div>
                        <div class="comment_section">
                           <div id="SeeComments<?php echo $post_id; ?>">

                              <!--div class="comment_wrap">
                                 <a href="http://127.0.0.1:8000/visit-user-profile/5">
                                 <img src="http://127.0.0.1:8000/assets/front_end/images/football_icon.png"/>
                                 </a>
                                 <p>
                                    <a href="http://127.0.0.1:8000/visit-user-profile/5"> Sumit Gupta <span>11:42:38am, 18.10.2017</span></a>
                                    Chelsea will win.
                                 </p>
                              </div-->
                                <?php
                                if(!empty($FetchComments))
                                {
                                    foreach($FetchComments as $key=>$Comments)
                                    {
                                        $user_name = Users::select('id','name','profile_picture')->where('id',$Comments[user_id])->get()->toArray();
                                ?>
                                <div class="comment_wrap">
                                     <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0][id]; ?>">
                                     <?php if(empty($user_name[0][profile_picture])) { ?>
                                     <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                                     <?php } else{  ?>
                                     <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$user_name[0][profile_picture]; ?>"/>
                                     <?php } ?>
                                     </a>
                                     <div class="">
                                        <p>
                                           <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0][id]; ?>"> <?php echo $user_name[0][name]; ?> </a>
                                           <span><?php echo $PostingTime = date("h:i:sa, d.m.Y",strtotime($Comments[creation_date]))?></span>
                                           <p><?php echo $Comments[comments]; ?></p>
                                        </p>
                                        <!-- Comment Edit and Delete -->
                                        <?php if($Comments[user_id] == $user_id) { ?>
                                        <div class="dropdown feed_more">
                                          <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                            <li><a data-toggle="modal" data-target="#EditCommentModal" href="javascript:void(0);" onclick="DisplayEditCommentModal('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>')">Edit</a></li>
                                            <li><a href="javascript:void(0);" onclick="DeleteComments('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>')">Delete</a></li>
                                          </ul>
                                       </div>
                                       <?php }elseif($GetFeedDetails[0]['user_id'] == $user_id){ ?>
                                       <div class="dropdown feed_more">
                                          <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                            <li><a href="javascript:void(0);" onclick="DeleteComments('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>')">Delete</a></li>
                                          </ul>
                                       </div>
                                       <?php } ?>
                                       <!-- End edit and delete -->
                                        <!-- Comment reply activity  -->
                                        <div class="comment_reply_activity">
                                           <ul>
                                              <?php
                                              $GetCountOfLikeOnComment = comment_likes::where('post_id',$post_id)->where('comment_id',$Comments[id])->get()->toArray();
                                              $CheckloggedUserLikeReply = comment_likes::where('post_id',$post_id)->where('from_user_id',$user_id)->get()->toArray();
                                              $GetCountOnLike = count($GetCountOfLikeOnComment);
                                              if($GetCountOnLike == 0)
                                              {
                                              ?>
                                                    <li class="">
                                                         <i id="likepost" class="likepost_hover">
                                                            <?php echo $GetCountOnLike; ?>
                                                         </i>
                                                         <a href="javascript:void(0);" onclick="NewsFeedCommentsLikes('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>','<?php echo $Comments[user_id]; ?>')">  <i class="fa fa-thumbs-up" aria-hidden="true"></i> Like</a>
                                                    </li>
                                              <?php
                                              }else{
                                              ?>
                                                    <li class="<?php if(!empty($CheckloggedUserLikeReply)) { echo "active"; } ?>">
                                                         <i id="likepost" class="likepost_hover">
                                                            <?php echo $GetCountOnLike; ?>
                                                            <div class="live_user">
                                                               <button type="button" data-toggle="modal" data-target="#LikeViewModalForComment" onclick="PeopleLikeDeatilsOnComment('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>')">People who liked</button>
                                                            </div>
                                                         </i>
                                                         <a href="javascript:void(0);" onclick="NewsFeedCommentsLikes('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>','<?php echo $Comments[user_id]; ?>')">  <i class="fa fa-thumbs-up" aria-hidden="true"></i> <?php if($GetCountOnLike == 1) { echo "Like"; }else{ echo "Likes"; }?></a>
                                                    </li>
                                              <?php
                                              }
                                              ?>
                                              <?php $GetCountOfReplyOnComment = comment_replies::where('post_id',$post_id)->where('comment_id',$Comments[id])->get()->toArray(); $GetCountOnReply = count($GetCountOfReplyOnComment);
                                              if($GetCountOnReply == 0)
                                              {
                                              ?>
                                                <li>
                                                 <a href="javascript:void(0);" onclick="SubCommentReply('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>','<?php echo $Comments[user_id]; ?>')"> <?php echo $GetCountOnReply; ?>  <i class="fa fa-reply-all" aria-hidden="true"></i> Reply </a>
                                                </li>
                                              <?php }else{?>
                                              <li class="active">
                                                 <a href="javascript:void(0);" onclick="SubCommentReply('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>','<?php echo $Comments[user_id]; ?>')"> <?php echo $GetCountOnReply; ?>  <i class="fa fa-reply-all" aria-hidden="true"></i> <?php if($GetCountOnReply == 1) { echo "Reply" ; }else{ echo "Replies"; }?> </a>
                                              </li>
                                              <?php } ?>
                                           </ul>
                                        </div>
                                     </div>
                                </div>
                               <!-- Comment reply -->
                              <?php
                               $GetReplyAgainstComment = comment_replies::where('post_id',$post_id)->where('comment_id',$Comments[id])->get()->toArray();
                               if(!empty($GetReplyAgainstComment))
                               {
                                    foreach($GetReplyAgainstComment as $CommentKey=>$CommentValue)
                                    {
                                        $user_name = Users::select('id','name','profile_picture')->where('id',$CommentValue[from_user_id])->get()->toArray();
                               ?>
                                    <div class="comment_reply">
                                        <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0][id]; ?>">
                                        <?php if(empty($user_name[0][profile_picture])) { ?>
                                            <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                                        <?php } else{  ?>
                                            <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$user_name[0][profile_picture]; ?>"/>
                                        <?php } ?>
                                        </a>
                                        <p>
                                        <a href="{{url('visit-user-profile')}}/<?php echo $user_name[0][id]; ?>"> <?php echo $user_name[0][name]; ?> </a>
                                        <span><?php echo $PostingTime = date("h:i:sa, d.m.Y",strtotime($CommentValue[creation_date]))?></span>
                                        <b><?php echo $CommentValue[replied_text]; ?></b>
                                        </p>
                                        <!-- Comment Edit and Delete -->
                                        <?php if($CommentValue[from_user_id] == $user_id) { ?>
                                        <div class="dropdown feed_more">
                                          <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                            <li><a data-toggle="modal" data-target="#ReplyModal" href="javascript:void(0);" onclick="DisplayOldReply('<?php echo $post_id; ?>','<?php echo $CommentValue[comment_id]; ?>','<?php echo $CommentValue[id]; ?>')">Edit</a></li>
                                            <li><a href="javascript:void(0);" onclick="DeleteReply('<?php echo $post_id; ?>','<?php echo $CommentValue[id]; ?>')">Delete</a></li>
                                          </ul>
                                       </div>
                                       <?php }elseif($GetFeedDetails[0][user_id] == $user_id || $Comments[user_id] == $user_id) { ?>
                                       <div class="dropdown feed_more">
                                          <a title="Comment Action" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </a>
                                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                             <li><a href="javascript:void(0);" onclick="DeleteReply('<?php echo $post_id; ?>','<?php echo $CommentValue[id]; ?>')">Delete</a></li>
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
                                    if(empty($logged_in_user_name[0][profile_picture])) { ?>
                                        <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                                    <?php } else{  ?>
                                        <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$logged_in_user_name[0][profile_picture]; ?>"/>
                                    <?php } ?>
                                    <form id="SubCommentForm<?php echo $Comments[id]; ?>" action="javascript:void(0);" autocomplete="off">
                                        <input class="form-control input" type="text" name="ReplyComment" id="GetReply<?php echo $Comments[id]; ?>" placeholder="Add a Comment ..." onkeyup="SubCommentBlockId(event,<?php echo $Comments[id]; ?>)"/>
                                        <button type="button" style="display: block;" id="SubCommentButton<?php echo $Comments[id]; ?>" value="post" onclick="GetSubComments('<?php echo $post_id; ?>','<?php echo $Comments[id]; ?>','<?php echo $Comments[user_id]; ?>','<?php echo $GetFeedDetails[0][user_id]; ?>')"> <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                               <!-- replied against comment end -->
                                <?php
                                 }
                                     if($GetCount > 2)
                                     {
                                 ?>
                                <a class="Comment_SeeAll" href="javascript:void(0);" id="Comments<?php echo $post_id; ?>" onclick="SeeAllComments('<?php echo $post_id; ?>')" >See All Comments</a>
                               <?php
                                     }
                                 }
                                 ?>
                           <!--------------------------------------->
                              <!--a class="Comment_SeeAll" href="javascript:void(0);" id="Comments31" onclick="SeeAllComments('31')">See All Comments</a-->
                           </div>
                           <form id="CommentForm" action="javascript:void(0);" autocomplete="off">
                            <input class="form-control" type="text" name="comment" id="comment<?php echo $post_id; ?>" placeholder="Add a Comment ..." onkeyup="PasingBlockId(event,<?php echo $post_id; ?>)"/>
                        	<button type="button" style="display: block;" id="CommentButton<?php echo $post_id;?>" value="post" onclick="GetComments('<?php echo $post_id; ?>','<?php echo $GetFeedDetails[0][user_id];?>')"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                           </form>
                        </div>
                    </div>
                </div>
               <div class="clearfix"></div>
            </div>
         </div>
         <!-- rightbar part Start -->
         @include('common/rightbar')
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
<!---modal for report abuse----->
<div id="report_abuse" data-easein="expandIn" class="registration_modal modal fade informaion_modal" role="dialog">
   <div class="modal-dialog">
      <!---loader--->
      <div class="loader" style="display: none;" id="body_loader">
         <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
      </div>
      <!----------------------->
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Select Why You are Reporting this Post ?</h4>
         </div>
         <div class="modal-body">
            <form class="col-md-8 col-md-offset-2" id="SubmitReportForm" action="javascript:void(0);" autocomplete="off" enctype="multipart/form-data">
               <div class="form-group">
                  <select class="selectpicker validate[required] AgeGroup" id="report" name="report" data-live-search="true">
                     <option value="">Select</option>
                     <?php
                        if(!empty($GetReportItems))
                        {
                             foreach($GetReportItems as $ReportItems)
                             {
                        ?>
                     <option value="<?php echo $ReportItems[id];?>"><?php echo $ReportItems[type_name];?></option>
                     <?php
                            }
                        }
                        ?>
                  </select>
               </div>
               <input name="postId" id="postId" value="" type="hidden"/>
               <button type="submit" class="btn" onclick="SubmitReport()">Save</button>
               <!--button type="submit" class="btn">Edit</button-->
            </form>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</div>
<!------------------------------->
@include('common/footer')
@include('common/footer_link')
<script type="text/javascript">
$(document.body).on('click','.panel-heading',function(){
   if($(this).hasClass('accordion-opened')){
     $(this).removeClass('accordion-opened');
   }
   else{
      $(this).addClass('accordion-opened');
   }
 });
function PasingBlockId(e,BlockId)
{
     if (e.keyCode == 13) {
         $("#CommentButton"+BlockId).trigger("click");
     }
}
function NewsFeedLikes(blockId,ToUserId)
{
     var post_id = blockId;
     $.ajax({
             type: "POST",
             url: "{{url('check-newsfeed-likes')}}",
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             data: {'post_id':post_id,'to_user_id':ToUserId},
             success: function(result)
             {
                 //console.log(result);
                 newsfeedpost(blockId);
             }
         });
}
function newsfeedpost(blockId)
{
     var post_id = blockId;
     $.ajax({
             type: "POST",
             url: "{{url('news-feed-post')}}",
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             data: {'post_id':post_id},
             success: function(result)
             {
                 //console.log(result);
                 $("#ajaxpostdata"+post_id).html(result);
             }
         });
}
function GetComments(blockId,ToUserId)
{
     var comment = $("#comment"+blockId).val();
     $.ajax({
             type: "POST",
             url: "{{url('news-feed-comment')}}",
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             data: {'post_id':blockId,'comment':comment,'to_user_id':ToUserId},
             success: function(result)
             {
                 //console.log(result);
                 newsfeedpost(blockId);
             }
     });
}
function SeeAllComments(BlockId)
{
    $.ajax({
         type: "POST",
         url: "{{url('see-all-comments')}}",
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data: {'post_id':BlockId},
         success: function(result)
         {
             //console.log(result);
             $("#SeeComments"+BlockId).html('');
             $("#SeeComments"+BlockId).html(result).hide();
             $("#SeeComments"+BlockId).html(result).fadeIn(3000);
             $("#Comments"+BlockId).fadeOut(3000);
         }
     });
}
function BetSlipCopy(PostId)
{
    $.ajax({
         type: "POST",
         url: "{{url('Check-betslip-existance')}}",
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data: {'post_id':PostId},
         success: function(result)
         {
             //console.log(result);
             if(result != '')
             {
                //alert(result);
                $("#BetSlipSetteled"+PostId).addClass('settledItem');
                $("#BetSlipSetteled"+PostId).html('Betslip settled can not be copied').show();
                setTimeout(function() {
            		$('#BetSlipSetteled'+PostId).fadeOut('fast');
            	}, 4000);
             }else{
                /************************************************/
                var CountValue = $("#CountCopy"+PostId).text();
                if(CountValue == 1)
                {
                   $("#CopyButton"+PostId).css('pointer-events','none');
                }else{
                    $.ajax({
                         type: "POST",
                         url: "{{url('bet-slip-copy')}}",
                         headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                         data: {'post_id':PostId},
                         success: function(result)
                         {
                             //console.log(result);
                             $("#EmptyBetSlip").html('');
                             $("#BetSlip").append(result);
                             //newsfeedpost(PostId);
                             $("#CountCopy"+PostId).html((parseInt(CountValue) + 1));
                             $("#RemoveClass"+PostId).addClass('active');
                             $("#RemoveClass"+PostId).css('pointer-events','none');
                         }
                    });
                }
             }
         }
     });
}
function RemoveBetSlip(BetslipId)
{
   if(BetslipId != '')
   {
        $("#slip"+BetslipId).remove();
        $("#"+BetslipId).removeClass('active');
        $.ajax({
            type: "POST",
            url: "{{url('Remove-Odds-From-Session')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'BetSlipId':BetslipId},
            success: function(result)
            {
                var blockId = result;
                var CountValue = $("#CountCopy"+blockId).text();
                $("#CountCopy"+blockId).html(parseInt(CountValue - 1));
                $("#RemoveClass"+blockId).removeClass('active');
                /*$("#EmptyBetSlip").html('');
                $("#BetSlip").append(result);
                $("#body_loader").hide();*/
            }
        });
   }
}
function PeopleLikeDeatils(PostId)
{
    if(PostId != '')
    {
        $("#modal_loader").show();
        $.ajax({
            type: "POST",
            url: "{{url('get-poeple-likes')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'PostId':PostId},
            success: function(result)
            {
                //console.log(result);
                $("#PeopleLikedDetails").html('');
                $("#PeopleLikedDetails").html(result);
                $("#modal_loader").hide();
            }
        });
    }
}
</script>
