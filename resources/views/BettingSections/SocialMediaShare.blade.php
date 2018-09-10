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
   <div class="feed_body">
      <h4><?php if(!empty($GetFeedDetails)) { echo $GetFeedDetails[0][home_team].' vs '.$GetFeedDetails[0][away_team]; } ?></h4>
      <p>Match Betting : <span><?php echo $MatchbettingDate = date("jS F",strtotime($GetFeedDetails[0][match_betting_date])) .'|'. date("H:i",strtotime($GetFeedDetails[0][match_betting_date])) ;?></span></p>
   </div>
   <!-- -----difference according to odds----------------- -->
    <?php
    if($GetFeedDetails[0][Odds_type] == 'Home')
    {
    ?>
    <div class="feed_chart">
      <h3><?php echo $GetFeedDetails[0][home_team]; ?><span>@<?php echo $GetFeedDetails[0][odds_value]; ?></span></h3>
      <h3>Return <span>@<?php echo number_format($GetFeedDetails[0][total_return], 2, '.', ''); ?></span></h3>
    </div>
    <?php
     $GetCommentsForBetslip = bet_place_histories::select('bet_text')->leftJoin('news_feeds', 'news_feeds.bet_id', '=', 'bet_place_histories.bet_id')->where('bet_place_histories.bet_id',$GetFeedDetails[0][bet_id])->get()->toArray();
     if(!empty($GetCommentsForBetslip[0][bet_text])) {
     ?>
     <p class="BettingSlipComment"><i class="fa fa-comments" aria-hidden="true"></i> <?php echo $GetCommentsForBetslip[0][bet_text]; ?></p>
    <?php } ?>
    <?php
    }elseif($GetFeedDetails[0][Odds_type] == 'Draw')
    {
    ?>
    <div class="feed_chart">
      <h3><?php echo $GetFeedDetails[0][home_team].' vs '.$GetFeedDetails[0][away_team]; ?><span>@<?php echo $GetFeedDetails[0][odds_value]; ?></span></h3>
      <h3>Single <span>@<?php echo $GetFeedDetails[0][total_return]; ?></span></h3>
    </div>
    <?php
     $GetCommentsForBetslip = bet_place_histories::select('bet_text')->leftJoin('news_feeds', 'news_feeds.bet_id', '=', 'bet_place_histories.bet_id')->where('bet_place_histories.bet_id',$GetFeedDetails[0][bet_id])->get()->toArray();
     if(!empty($GetCommentsForBetslip[0][bet_text])) {
     ?>
     <p class="BettingSlipComment"><i class="fa fa-comments" aria-hidden="true"></i> <?php echo $GetCommentsForBetslip[0][bet_text]; ?></p>
    <?php } ?>
    <?php
    }else{
    ?>
    <div class="feed_chart">
      <h3><?php echo $GetFeedDetails[0][away_team]; ?><span>@<?php echo $GetFeedDetails[0][odds_value]; ?></span></h3>
      <h3>Single <span>@<?php echo $GetFeedDetails[0][total_return]; ?></span></h3>
    </div>
    <?php
     $GetCommentsForBetslip = bet_place_histories::select('bet_text')->leftJoin('news_feeds', 'news_feeds.bet_id', '=', 'bet_place_histories.bet_id')->where('bet_place_histories.bet_id',$GetFeedDetails[0][bet_id])->get()->toArray();
     if(!empty($GetCommentsForBetslip[0][bet_text])) {
     ?>
     <p class="BettingSlipComment"><i class="fa fa-comments" aria-hidden="true"></i> <?php echo $GetCommentsForBetslip[0][bet_text]; ?></p>
    <?php } ?>
    <?php
    }
    ?>
  <!-- difference according to odds end -->
</div>
