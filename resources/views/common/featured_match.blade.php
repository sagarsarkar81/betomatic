<?php
//aa($GetFeaturedMatch);
?>
<div class="featured_match">
   <h3>Featured Match</h3>
   <hr/>
   <div class="featured_icon">
     <div class="teamA">
       <img width="40px" src="{{asset('assets/front_end/images/home_team.png')}}" />    
       <a href="javascript:void(0);" data-toggle="tooltip" title="<?php echo $GetFeaturedMatch[0][featured_match][match_hometeam_name]; ?>">
        <p>
          <?php //echo $GetFeaturedMatch[0][featured_match][match_hometeam_name]; ?>
          <?php
             if(strlen($GetFeaturedMatch[0][featured_match][match_hometeam_name]) > 10)
             {
               echo substr($GetFeaturedMatch[0][featured_match][match_hometeam_name],0,10)."...";
             } else{
               echo $GetFeaturedMatch[0][featured_match][match_hometeam_name];
             }
          ?>
        </p>
       </a>
     </div>
     <div class="featured_time">
       <p><?php echo date("H:i",strtotime($GetFeaturedMatch[0][featured_match][match_time])); ?></p>
       <h5>Today</h5>
     </div>
     <div class="teamB">
      <img width="40px" src="{{asset('assets/front_end/images/away_team.png')}}" />
      <a href="javascript:void(0);" data-toggle="tooltip" title="<?php echo $GetFeaturedMatch[0][featured_match][match_awayteam_name]; ?>">
       <p><?php //echo $GetFeaturedMatch[0][featured_match][match_awayteam_name]; ?>
          <?php
             if(strlen($GetFeaturedMatch[0][featured_match][match_awayteam_name]) > 10)
             {
               echo substr($GetFeaturedMatch[0][featured_match][match_awayteam_name],0,10)."...";
             } else{
               echo $GetFeaturedMatch[0][featured_match][match_awayteam_name];
             }
          ?>
       </p>
      </a>
     </div>
   </div>
   <hr class="odd_view" />
   <div class="featured_odds">
     <h4>ODDS</h4>
     <?php if(!empty($GetFeaturedMatch[0][featured_match_odds])) { ?>
      <ul class="League_odd_list">
        <li><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip <?= in_array($UniqueKey.'-'.'Home',Session::get('BetSlipExtraData')) ? 'active': '';?>" MatchId="<?php echo $GetFeaturedMatch[0][match_id]; ?>" BetFor="Home" Bookmaker="<?php echo $GetFeaturedMatch[0][featured_match_odds][0][odd_bookmakers]; ?>" MatchTime="<?php echo $GetFeaturedMatch[0][match_time]; ?>" BetType="Full time"><?php echo $GetFeaturedMatch[0][featured_match_odds][0][odds_value]; ?></a></li>
        <li><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip <?= in_array($UniqueKey.'-'.'Draw',Session::get('BetSlipExtraData')) ? 'active': '';?>" MatchId="<?php echo $GetFeaturedMatch[0][match_id]; ?>" BetFor="Draw" Bookmaker="<?php echo $GetFeaturedMatch[0][featured_match_odds][1][odd_bookmakers]; ?>" MatchTime="<?php echo $GetFeaturedMatch[0][match_time]; ?>" BetType="Full time"><?php echo $GetFeaturedMatch[0][featured_match_odds][1][odds_value]; ?></a></li>
        <li><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip <?= in_array($UniqueKey.'-'.'Away',Session::get('BetSlipExtraData')) ? 'active': '';?>" MatchId="<?php echo $GetFeaturedMatch[0][match_id]; ?>" BetFor="Away" Bookmaker="<?php echo $GetFeaturedMatch[0][featured_match_odds][2][odd_bookmakers]; ?>" MatchTime="<?php echo $GetFeaturedMatch[0][match_time]; ?>" BetType="Full time"><?php echo $GetFeaturedMatch[0][featured_match_odds][2][odds_value]; ?></a></li>
      </ul>
     <?php }else{ ?>
     <div class="no_odds_available">No odds available</div>
     <?php } ?>
  </div>
</div> 