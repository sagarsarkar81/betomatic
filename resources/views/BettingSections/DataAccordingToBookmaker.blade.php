<?php
   use Illuminate\Support\Facades\DB;
   use App\btg_events;
   use App\btg_odds;
   ?>
<div class="panel panel-default League_wrap">
    <?php
      if(!empty($leagues))
      {
        foreach($leagues as $key=>$value)
        {
          if(!empty($LeagueWiseMatch))
          {
            foreach($LeagueWiseMatch as $matchkey=>$matchValue)
            {
              if($matchkey == $key)
              {
      
    ?>
   <div class="panel-heading accordion-opened" role="tab" id="">
      <h4 class="panel-title">
         <a class="accordion-toggle" role="button" data-toggle="collapse" href="#League<?php echo $key; ?>" aria-expanded="true" aria-controls="collapseOne">
         <img src="" />   <?php echo $value[country_name]; ?> - <?php echo $value[league_name]; ?>
         </a>
      </h4>
   </div>
   <div id="League<?php echo $matchkey; ?>" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
      <div class="panel-body">
         <?php foreach($matchValue as $leagueKey=>$leagueValue) { ?>
         <div class="match_holder">
            <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
               <div class="match_title_time">
                  <span class="pre_match_time" data-original-title="" title=""><?php echo date("Y/m/d h:i",strtotime($leagueValue[0][match_time])); ?></span>
                  <span class="pre_match_title" title="" data-original-title="West Ham | Tottenham">
                  <a data-toggle="tooltip" href="{{url('move-to-extra-odd-page')}}/<?php echo $leagueValue[0][match_id]; ?>/<?php echo $leagueValue[0][odd_bookmakers]; ?>" title="<?php echo $leagueValue[0][match_hometeam_name]; ?> | <?php echo $leagueValue[0][match_awayteam_name]; ?>">
                  <?php
                     if(strlen($leagueValue[0][match_hometeam_name]) > 10)
                     {
                       echo substr($leagueValue[0][match_hometeam_name],0,10)."...";
                     } else{
                       echo $leagueValue[0][match_hometeam_name];
                     }
                     ?> |
                  <?php
                     if(strlen($leagueValue[0][match_awayteam_name]) > 10)
                     {
                       echo substr($leagueValue[0][match_awayteam_name],0,10)."...";
                     } else{
                       echo $leagueValue[0][match_awayteam_name];
                     }
                     ?>
                  </a>
                  </span>
               </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
               <ul class="League_odd_list">
                  <li><span>1</span><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $leagueValue[0][match_id]; ?>" BetFor="Home" Bookmaker="<?php echo $leagueValue[0][odd_bookmakers]; ?>" MatchTime="<?php echo $leagueValue[0][match_time]; ?>" BetType="Full time"><?php echo $leagueValue[0][odds_value]; ?></a></li>
                  <li><span>X</span><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $leagueValue[0][match_id]; ?>" BetFor="Draw" Bookmaker="<?php echo $leagueValue[0][odd_bookmakers]; ?>" MatchTime="<?php echo $leagueValue[0][match_time]; ?>" BetType="Full time"><?php echo $leagueValue[1][odds_value]; ?></a></li>
                  <li><span>2</span><a id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $leagueValue[0][match_id]; ?>" BetFor="Away" Bookmaker="<?php echo $leagueValue[0][odd_bookmakers]; ?>" MatchTime="<?php echo $leagueValue[0][match_time]; ?>" BetType="Full time"><?php echo $leagueValue[2][odds_value]; ?></a></li>
               </ul>
            </div>
            <div class="clearfix"></div>
         </div>
         <?php } ?>
      </div>
   </div>
   <?php
      }
      }
      }
      }
      } else {
      ?>
    <div class="no_data">
     <img width="50px" src="{{asset('assets/front_end/images/warning.svg')}}"/>
     Sorry! No data found...
    </div>
   <?php } ?>
</div>