@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <div class="loader_total" style="" id="body_loader_fullpage">
       <img src="{{asset('assets/front_end/images/spinner.gif')}}"/>
   </div>
   <!-- Page header top -->
   @include('common/register_header')
   <!-- Page body content -->
   <div class="container team_details">
      <div class="row">
         <div class="col-md-12 game_heading">
            <h3><img width="25px" src="{{asset('assets/front_end/images/game_list/soccer.png')}}" alt=""> Football</h3>
         </div>
         <div class="col-md-8 col-sm-7">
            <div class="loader" style="display: none;" id="body_loader_extraOdd">
                <img src="{{asset('assets/front_end/images/spinner.gif')}}"/>
            </div>
            <div class="row">
               <div class="league_wrap">
                  <div class="col-md-6">
                     <div class="teame_heading">
                        <a href="{{url('soccer-odds')}}"><img src="{{asset('assets/front_end/images/back-arrow.svg')}}" width="40px"></a>
                        <p><?php echo $match_info->league_name; ?><b><?php echo $match_info->match_hometeam_name; ?> - <?php echo $match_info->match_awayteam_name; ?> </b></p>
                     </div>
                  </div>
                  <input type="hidden" value="<?php echo $match_info->match_id; ?>" id="MatchId"/>
                  <input type="hidden" value="<?php echo $match_info->match_hometeam_name; ?>" id="HomeTeam">
                  <input type="hidden" value="<?php echo $match_info->match_awayteam_name; ?>" id="AwayTeam">
                  <input type="hidden" value="<?php echo $match_info->league_id; ?>" id="league_id">
                  <div class="col-md-6">
                     <div class="Select_odds">
                        <select  onchange="GetBookmakerNameForExtraOdds(this.value,'<?php echo $match_info->match_id; ?>')">
                           <?php
                              if(!empty($bookmakers))
                              {
                                foreach($bookmakers as $key=>$value)
                                {
                              ?>
                           <option value=<?php echo $value; ?>><?php echo $value; ?></option>
                           <?php
                                 }
                              }
                           ?>
                        </select>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>
                  <!-- choose league -->
                  <div class="col-md-4 col-sm-12">
                     <div class="top_league_wrap">
                        <h3>Top Leagues</h3>
                        <ul>
                           <?php
                              if(!empty($GetTopLeagueList))
                              {
                                foreach($GetTopLeagueList as $TopKey=>$TopValue)
                                {
                              ?>
                           <li><a href="javascript:void(0)" onclick="MoveToSelectedLeague('<?php echo $TopValue[league_id]; ?>')"><?php echo $TopValue[country_name]; ?></a></li>
                           <?php
                                }
                              }
                            ?>
                        </ul>
                     </div>
                  </div>
                  <!-- choose league --> 
                  <!-- choose league -->
                  <div class="col-md-8 col-sm-12">
                     <div id="ExtraOddImport">
                  <?php 
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
                                       <li><span>1X</span><a style="<?php if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Home/Draw" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Double chance" ><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
                                       <li><span>12</span><a style="<?php if(empty($OddsValue[1][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Home/Away" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Double chance" ><?php  if(empty($OddsValue[1][odds_value])) { echo "--"; }else{ echo $OddsValue[1][odds_value]; } ?></a></li>
                                       <li><span>X2</span><a style="<?php if(empty($OddsValue[2][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Draw/Away" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Double chance" ><?php  if(empty($OddsValue[2][odds_value])) { echo "--"; }else{ echo $OddsValue[2][odds_value]; } ?></a></li>
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
                           <?php foreach($OddsValue as $key=>$value) { ?>
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
                                       <li><span>1 (<?php echo $value['extra_value']; ?>)</span><a style="<?php  if(empty($value[odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Home" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Asian handicap" ExtraOdds="<?php echo $value['extra_value']; ?>"><?php  if(empty($value[odds_value])) { echo "--"; }else{ echo $value[odds_value]; } ?></a></li>
                                       <li><span>2 (<?php echo $value['extra_value']; ?>)</span><a style="<?php  if(empty($value[odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Away" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Asian handicap" ExtraOdds="<?php echo $value['extra_value']; ?>"><?php  if(empty($value[odds_value])) { echo "--"; }else{ echo $value[odds_value]; } ?></a></li>
                                    </ul>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                           <?php } ?>
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
                                       <li><span>Over/<?php  if(empty($OddsValue[0][extra_value])) { echo "--"; }else{ echo $OddsValue[0][extra_value]; } ?> </span><a style="<?php  if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Over" ExtraOdds="<?php echo $OddsValue[0]['extra_value']; ?>" ><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
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
                                       <li><span>Under/<?php  if(empty($OddsValue[0][extra_value])) { echo "--"; }else{ echo $OddsValue[0][extra_value]; } ?></span><a style="<?php  if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="Under" ExtraOdds="<?php echo $OddsValue[0]['extra_value']; ?>"><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
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
                                       <li><span>Yes</span><a style="<?php  if(empty($OddsValue[0][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="Yes" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="BTS"><?php  if(empty($OddsValue[0][odds_value])) { echo "--"; }else{ echo $OddsValue[0][odds_value]; } ?></a></li>
                                       <li><span>No</span><a style="<?php  if(empty($OddsValue[1][odds_value])) { echo "pointer-events: none" ; } else{ echo "pointer-events: auto " ; } ?>" id="<?php echo $UniqueId = rand(10000,1000000); ?>" href="javascript:void(0);" data-original-title="" title="" class="PlaceInBetSlip" MatchId="<?php echo $match_info->match_id; ?>" BetFor="No" Bookmaker="<?php echo $bookmakers[0]; ?>" MatchTime="<?php echo $match_info->match_time; ?>" BetType="ExtraOdds" Market="BTS"><?php  if(empty($OddsValue[1][odds_value])) { echo "--"; }else{ echo $OddsValue[1][odds_value]; } ?></a></li>
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
                  ?>
                     </div>
                  </div>

                  <!-- choose league --> 
                  <div class="clearfix"></div>
               </div>
            </div>
         </div>
         <!-- rightbar part Start -->
         <div class="col-md-4 col-sm-5">
            <!-- match Result -->
            <div class="Match_Result">
               <p>Live Score</p>
               <div class="live_team">
                  <span>Arsenal</span>
                  <span>20:45</span>
                  <span>Liverpool</span>
               </div>
               <div class="Result_view">
                  <span>05</span> : <span>05</span>
               </div>
            </div>
            <!-- match Result end -->
            <!-- h2h -->
            <div class="h2h_wrap">
               <div class="betingslip_main">
                  <ul class="nav nav-tabs " role="tablist">
                     <li role="presentation" class="active"><a href="#matches" role="tab" data-toggle="tab">Matches </a></li>
                     <li role="presentation"><a href="#players" role="tab" data-toggle="tab">Players </a></li>
                     <li role="presentation"><a href="#lineup" role="tab" data-toggle="tab">Line-up </a></li>
                     <li role="presentation"><a href="#others" role="tab" data-toggle="tab">Others </a></li>
                  </ul>
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active" id="matches">
                        <div class="Matches_wrap">
                           <div class="Pre_game">
                              <p>Pre-game form</p>
                              <div class="team_a">
                                 <p>Arsenal </p>
                                 <span>W - L - L - W - W</span>
                              </div>
                              <div class="team_b">
                                 <p>Liverpool </p>
                                 <span>W - L - L - W - W</span>
                              </div>
                           </div>
                           <hr/>
                           <div class="H2H_wrap">
                              <p>H2H</p>
                              <div class="h2h_content">
                                 <div class="team">
                                    10 wins
                                    <span>Arsenal</span>
                                 </div>
                                 <div class="team_draw">
                                    7 draws
                                 </div>
                                 <div class="team">
                                    4 wins
                                    <span>Liverpool</span>
                                 </div>
                              </div>
                           </div>
                           <hr/>
                           <div class="latest_meetings_wrap">
                              <p>Latest meetings</p>
                              <h4>
                                 <img src="{{asset('assets/front_end/images/flag/irre.png')}}"/>   
                                 Italy - Seria A
                              </h4>
                              <div class="latest_meetings_itme">
                                 <p>06 Mars 17</p>
                                 <p><span>Arsenal</span> <span>Liverpool</span></p>
                                 <p><span>1</span> <span>2</span></p>
                              </div>
                              <div class="latest_meetings_itme">
                                 <p>06 Mars 17</p>
                                 <p><span>Arsenal</span> <span>Liverpool</span></p>
                                 <p><span>1</span> <span>2</span></p>
                              </div>
                              <div class="latest_meetings_itme">
                                 <p>06 Mars 17</p>
                                 <p><span>Arsenal</span> <span>Liverpool</span></p>
                                 <p><span>1</span> <span>2</span></p>
                              </div>
                           </div>
                           <hr/>
                           <div class="latest_meetings_wrap">
                              <p>Team Statistics</p>
                              <div class="statistics_heading">
                                 <p>Team</p>
                                 <p>Matches</p>
                                 <p>Scored</p>
                                 <p>Conceded </p>
                              </div>
                              <div class="statistics_content">
                                 <p>Arsenal </p>
                                 <p>10</p>
                                 <p>10</p>
                                 <p>10</p>
                              </div>
                              <div class="statistics_content">
                                 <p>Liverpool </p>
                                 <p>10</p>
                                 <p>10</p>
                                 <p>10</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane " id="players">
                        <div class="players_wrap">
                           <div class="latest_meetings_wrap">
                              <p>Goal statistics</p>
                              <div class="statistics_heading">
                                 <p>Name</p>
                                 <p>Matches</p>
                                 <p>Goals</p>
                              </div>
                              <div class="statistics_content">
                                 <p>Alexis Sanchez </p>
                                 <p>10</p>
                                 <p>13</p>
                              </div>
                              <div class="statistics_content">
                                 <p>Mohamed Salah </p>
                                 <p>10</p>
                                 <p>10</p>
                              </div>
                           </div>
                           <hr/>
                           <div class="latest_meetings_wrap">
                              <p>Assist statistics</p>
                              <div class="statistics_heading">
                                 <p>Name</p>
                                 <p>Matches</p>
                                 <p>Assist</p>
                              </div>
                              <div class="statistics_content">
                                 <p>Alexis Sanchez </p>
                                 <p>10</p>
                                 <p>13</p>
                              </div>
                              <div class="statistics_content">
                                 <p>Mohamed Salah </p>
                                 <p>10</p>
                                 <p>10</p>
                              </div>
                           </div>
                           <hr/>
                           <div class="latest_meetings_wrap">
                              <p>Injuries</p>
                              <div class="statistics_content">
                                 <p>Alexis Sanchez </p>
                                 <p>Misses match</p>
                              </div>
                              <div class="statistics_content">
                                 <p>Mohamed Salah </p>
                                 <p>Misses match</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane " id="lineup">
                        <div class="lineup">
                           <p>Last update: 10:12, 10 Dec 2017</p>
                           <p>Arsenal <span>4-3-3</span></p>
                            <div class="lingup_bg">
                              <img src="{{asset('assets/front_end/images/home/4-3-3.png')}}" class="img-responsive"/>
                              <img src="{{asset('assets/front_end/images/away/4-2-3-1.png')}}" class="img-responsive"/>
                            </div>
                           <p>Liverpool <span>4-2-3-1</span></p>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane " id="others">
                        <div class="others">
                           <p>League table</p>
                           <div class="latest_meetings_wrap">
                              <div class="statistics_heading">
                                 <p>Pos</p>
                                 <p>Club</p>
                                 <p>M</p>
                                 <p>W</p>
                                 <p>D</p>
                                 <p>L</p>
                                 <p>GD</p>
                                 <p>p</p>
                              </div>
                              <div class="statistics_content">
                                 <p>1</p>
                                 <p>Man City</p>
                                 <p>10</p>
                                 <p>10</p>
                                 <p>12</p>
                                 <p>13</p>
                                 <p>10</p>
                                 <p>14</p>
                              </div>
                              <div class="statistics_content">
                                 <p>2</p>
                                 <p>Man UTD</p>
                                 <p>10</p>
                                 <p>10</p>
                                 <p>12</p>
                                 <p>13</p>
                                 <p>10</p>
                                 <p>14</p>
                              </div>
                              <div class="statistics_content">
                                 <p>3</p>
                                 <p>Chelsea</p>
                                 <p>10</p>
                                 <p>10</p>
                                 <p>12</p>
                                 <p>13</p>
                                 <p>10</p>
                                 <p>14</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- h2h end -->
         </div>
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/betting_slip')
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

$(document).ready(function(){
    $("#EmptyBetSlipAccu").show();
    $("#BetComments").val('');
    //$("#BetComments").prop('disabled', true);
    $(".Comments").prop('disabled', true);
    $("#PlaceBet").css('pointer-events','none');
    $("#AccumulatorId").css('pointer-events','none');
    SelectPrivacy('Public');
    SelectPrivacyForAccumulator('Public');
    PageLoadCheckSession();
    GetDetailsForSingleBet();
    
});
jQuery(window).load(function () {
    $("#body_loader_fullpage").show();
     HeadToHeadData();  
    setTimeout(function () {
        //alert('page is loaded and 1 minute has passed');
        $("#body_loader_fullpage").hide();
    }, 3000);
    
});
/*function GetDetailsForSingleBet()
{
    $.ajax({
       type: "GET",
       async: false,
       url: "{{url('get-details-single-bet')}}",
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(result)
       {
          var Data = JSON.parse(result);
          var Stake = Data.Stake;
          var payout = Data.Payout;
          $("#TotalStake").html(Stake);
          $("#TotalReturn").html(payout);
          //var Stake = result.
       }
   });
}*/

/*function PageLoadCheckSession()
{
    $.ajax({
       type: "GET",
       async: false,
       url: "{{url('check-session-for-extra-odds')}}",
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       //data: {'BookmakerName':BookmakerName,'MatchId':MatchId},
       success: function(result)
       {
            //console.log(result);
            $("#EmptyBetSlip").hide();
            $("#BetSlip").append(result);
            var Count = $('#BetSlip').children().length;
            $(".slip_count").html(Count);
            //$("#BetComments").prop('disabled', false);
            $(".Comments").prop('disabled', false);
            $("#PlaceBet").css('pointer-events','auto');
            $(".BetStake").each(function(){
              var CheckStakeInput = $(this).val();
              if(CheckStakeInput == '')
              {
                  $("#PlaceBet").css('pointer-events','none');
              }
            });
       }
   });
   $.ajax({
        type: "GET",
        async: false,
        url: "{{url('check-session-for-accu-bet')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result)
        {
            //console.log(result);
            $("#EmptyBetSlipAccu").hide();
            $("#BettingSlipAccumulator").append(result);
            AccumultaorOdds();
            $.ajax({
                type: "POST",
                url: "{{url('check-same-matchId')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'MatchId':MatchId},
                success: function(res)
                {
                    //console.log(res);
                    $("."+MatchId).addClass(res);
                }
            });
        }
    });
}*/

function GetBookmakerNameForExtraOdds(BookmakerName,MatchId)
{
 if(BookmakerName != '')
 {
   $("#body_loader_extraOdd").show();
   $.ajax({
       type: "POST",
       url: "{{url('get-data-according-to-bookmaker-for-extra-odd')}}",
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       data: {'BookmakerName':BookmakerName,'MatchId':MatchId},
       success: function(result)
       {
           //console.log(result);
           $("#ExtraOddImport").html('');
           $("#ExtraOddImport").html(result);
           $("#body_loader_extraOdd").hide();
       }
   });
 }
}
function HeadToHeadData()
{
    var MatchId = $("#MatchId").val();
    var HomeTeam = $("#HomeTeam").val();
    var AwayTeam = $("#AwayTeam").val();
    var LeagueId = $("#league_id").val();
    $.ajax({
       type: "POST",
       url: "{{url('get-head-to-head-data')}}",
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       data: {'MatchId':MatchId,'HomeTeam':HomeTeam,'AwayTeam':AwayTeam,'leagueId':LeagueId},
       success: function(result)
       {
           //console.log(result);
           $("#matches").html('');
           $("#matches").html(result);
       }
   });
}
</script>