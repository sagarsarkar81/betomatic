<?php
if(!empty($all_odds))
{
    foreach($all_odds as $OddsKey=>$OddsValue)
    {
    ?>
       <div class="panel panel-default League_wrap">
          <div class="panel-heading accordion-opened" role="tab" id="">
             <h4 class="panel-title">
                <a class="accordion-toggle" role="button" data-toggle="collapse" href="#<?php echo preg_replace('/\s+/', '', $OddsKey); ?>" aria-expanded="true" aria-controls="collapseOne">
                <?php echo $OddsKey; ?>
                </a>
             </h4>
          </div>
          <?php
          /*Double chance*/
          if($OddsKey == 'Double chance')
          {
          ?>
          <div id="<?php echo preg_replace('/\s+/', '', $OddsKey); ?>" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
             <div class="panel-body">
                <div class="match_holder">
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <div class="match_title_time"> 
                         <span class="pre_match_time" data-original-title="" title=""><?php echo $match_info->match_time; ?></span>
                         <span class="pre_match_title" title="" >
                            <a data-toggle="tooltip" title="<?php echo $match_info->match_hometeam_name; ?> | <?php echo $match_info->match_awayteam_name; ?>" href="javascript:void(0);">
                               
                               <?php
                               if(strlen($match_info->match_hometeam_name) > 10)
                               {
                                 echo substr($match_info->match_hometeam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_hometeam_name;
                               }
                            ?> |
                            <?php
                               if(strlen($match_info->match_awayteam_name) > 10)
                               {
                                 echo substr($match_info->match_awayteam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_awayteam_name;
                               }
                            ?>
                            </a>
                         </span>
                      </div>
                   </div>
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                     <ul class="League_odd_list">
                       <li><span>1X</span><a style="<?php if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Home/Draw" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Double chance"><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
                       <li><span>12</span><a style="<?php if(empty($OddsValue[1][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Home/Away" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Double chance"><?php  if(empty($OddsValue[1][odds_value])) { echo "--"; }else{ echo $OddsValue[1][odds_value]; } ?></a></li>
                       <li><span>X2</span><a style="<?php if(empty($OddsValue[2][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Draw/Away" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Double chance"><?php  if(empty($OddsValue[2][odds_value])) { echo "--"; }else{ echo $OddsValue[2][odds_value]; } ?></a></li>
                    </ul>
                   </div>
                   <div class="clearfix"></div>
                </div>
             </div>
          </div>
          <?php
          /*Asian handicap*/
          } elseif ($OddsKey == 'Asian handicap') {
          ?>
          <div id="<?php echo preg_replace('/\s+/', '', $OddsKey); ?>" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
             <div class="panel-body">
                <div class="match_holder">
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <div class="match_title_time"> 
                         <span class="pre_match_time" data-original-title="" title=""><?php echo $match_info->match_time; ?></span>
                         <span class="pre_match_title" title="" >
                            <a data-toggle="tooltip" title="<?php echo $match_info->match_hometeam_name; ?> | <?php echo $match_info->match_awayteam_name; ?>" href="javascript:void(0);">
                               
                               <?php
                               if(strlen($match_info->match_hometeam_name) > 10)
                               {
                                 echo substr($match_info->match_hometeam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_hometeam_name;
                               }
                            ?> |
                            <?php
                               if(strlen($match_info->match_awayteam_name) > 10)
                               {
                                 echo substr($match_info->match_awayteam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_awayteam_name;
                               }
                            ?>
                            </a>
                         </span>
                      </div>
                   </div>
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <ul class="League_odd_list">
                       <li><span>1</span><a style="<?php  if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Home" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Asian handicap" ExtraOdds="<?php echo $OddsValue[0]['extra_value']; ?>"><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
                       <li><span>2</span><a style="<?php  if(empty($OddsValue[1][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Away" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Asian handicap" ExtraOdds="<?php echo $OddsValue[1]['extra_value']; ?>"><?php  if(empty($OddsValue[1][odds_value])) { echo "--"; }else{ echo $OddsValue[1][odds_value]; } ?></a></li>
                      </ul>
                   </div>
                   <div class="clearfix"></div>
                </div>
             </div>
          </div>
          <?php
          /*Over*/
          }elseif ($OddsKey == 'Over') {
          ?>
          <div id="<?php echo preg_replace('/\s+/', '', $OddsKey); ?>" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
             <div class="panel-body">
                <div class="match_holder">
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <div class="match_title_time"> 
                         <span class="pre_match_time" data-original-title="" title=""><?php echo $match_info->match_time; ?></span>
                         <span class="pre_match_title" title="" >
                            <a data-toggle="tooltip" title="<?php echo $match_info->match_hometeam_name; ?> | <?php echo $match_info->match_awayteam_name; ?>" href="javascript:void(0);">
                               <?php
                               if(strlen($match_info->match_hometeam_name) > 10)
                               {
                                 echo substr($match_info->match_hometeam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_hometeam_name;
                               }
                            ?> |
                            <?php
                               if(strlen($match_info->match_awayteam_name) > 10)
                               {
                                 echo substr($match_info->match_awayteam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_awayteam_name;
                               }
                            ?>
                            </a>
                         </span>
                      </div>
                   </div>
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <ul class="League_odd_list">
                       <li><span>Over/<?php  if(empty($OddsValue[0][extra_value])) { echo "--"; }else{ echo $OddsValue[0][extra_value]; } ?> </span><a style="<?php  if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Over" ExtraOdds="<?php echo $OddsValue[0]['extra_value']; ?>"><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
                      </ul>
                   </div>
                   <div class="clearfix"></div>
                </div>
             </div>
          </div>
          <?php
          /*under*/
          }elseif ($OddsKey == 'Under') {
          ?>
          <div id="<?php echo preg_replace('/\s+/', '', $OddsKey); ?>" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
             <div class="panel-body">
                <div class="match_holder">
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <div class="match_title_time"> 
                         <span class="pre_match_time" data-original-title="" title=""><?php echo $match_info->match_time; ?></span>
                         <span class="pre_match_title" title="" >
                            <a data-toggle="tooltip" title="<?php echo $match_info->match_hometeam_name; ?> | <?php echo $match_info->match_awayteam_name; ?>" href="javascript:void(0);">
                               
                               <?php
                               if(strlen($match_info->match_hometeam_name) > 10)
                               {
                                 echo substr($match_info->match_hometeam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_hometeam_name;
                               }
                            ?> |
                            <?php
                               if(strlen($match_info->match_awayteam_name) > 10)
                               {
                                 echo substr($match_info->match_awayteam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_awayteam_name;
                               }
                            ?>
                            </a>
                         </span>
                      </div>
                   </div>
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <ul class="League_odd_list">
                       <li><span>Under/<?php  if(empty($OddsValue[0][extra_value])) { echo "--"; }else{ echo $OddsValue[0][extra_value]; } ?></span><a style="<?php  if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Under" ExtraOdds="<?php echo $OddsValue[0]['extra_value']; ?>"><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
                      </ul>
                   </div>
                   <div class="clearfix"></div>
                </div>
             </div>
          </div>
          <?php
          }elseif ($OddsKey == 'BTS') {
          ?>
          <div id="<?php echo preg_replace('/\s+/', '', $OddsKey); ?>" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
             <div class="panel-body">
                <div class="match_holder">
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <div class="match_title_time"> 
                         <span class="pre_match_time" data-original-title="" title=""><?php echo $match_info->match_time; ?></span>
                         <span class="pre_match_title" title="" >
                            <a data-toggle="tooltip" title="<?php echo $match_info->match_hometeam_name; ?> | <?php echo $match_info->match_awayteam_name; ?>" href="javascript:void(0);">
                               
                               <?php
                               if(strlen($match_info->match_hometeam_name) > 10)
                               {
                                 echo substr($match_info->match_hometeam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_hometeam_name;
                               }
                            ?> |
                            <?php
                               if(strlen($match_info->match_awayteam_name) > 10)
                               {
                                 echo substr($match_info->match_awayteam_name,0,10)."...";
                               } else{
                                 echo $match_info->match_awayteam_name;
                               }
                            ?>
                            </a>
                         </span>
                      </div>
                   </div>
                   <div class="col-md-6 col-sm-6 col-xs-12" data-original-title="" title="">
                      <ul class="League_odd_list">
                       <li><span>Yes</span><a style="<?php  if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Yes" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="BTS"><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
                       <li><span>No</span><a style="<?php  if(empty($OddsValue[1][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="No" Bookmaker="<?php echo $bookmakers; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="BTS"><?php  if(empty($OddsValue[1][odds_value])) { echo "--"; }else{ echo $OddsValue[1][odds_value]; } ?></a></li>
                     </ul>
                   </div>
                   <div class="clearfix"></div>
                </div>
             </div>
          </div>
          <?php
          }
          ?>
       </div>
<?php 
    }
} else{
?>
<div class="no_data">
 <img width="50px" src="{{asset('assets/front_end/images/warning.svg')}}"/>
 Sorry! No data found...
</div>
<?php
}
?>