<?php //aa($TeamStat); ?>
<div class="Matches_wrap">
   <div class="Pre_game">
      <p>Pre-game form</p>
      <div class="team_a">
         <p><?php echo $HomeTeam; ?> </p>
         <span><?php echo substr($HomeLastResult,0,9); ?></span>
      </div>
      <div class="team_b">
         <p><?php echo $AwayTeam; ?> </p>
         <span><?php echo substr($AwayLastResult,0,9); ?></span>
      </div>
   </div>
   <hr/>
   <div class="H2H_wrap">
      <p>H2H</p>
      <div class="h2h_content">
         <div class="team">
           <?php echo $HomeTeamWin[W]; ?> <?php if($HomeTeamWin[W] == 1){ echo "win"; }else{ echo "wins"; } ?>
            <span><?php echo $HomeTeam; ?></span>
         </div>
         <div class="team_draw">
            <?php echo $HomeTeamWin[D]; ?> <?php if($HomeTeamWin[D] == 1){ echo "draw"; }else{ echo "draws"; } ?>
         </div>
         <div class="team">
            <?php echo $AwayTeamWin[W]; ?> <?php if($AwayTeamWin[W] == 1){ echo "win"; }else{ echo "wins"; } ?>
            <span><?php echo $AwayTeam; ?></span>
         </div>
      </div>
   </div>
   <hr/>
   <div class="latest_meetings_wrap">
      <p>Latest meetings</p>
      <?php 
      if(!empty($Matches)){
         foreach($Matches as $key=>$value) { 
            if(!empty($LeagueWiseMatch)){
               foreach($LeagueWiseMatch as $MatchKey=>$MatchValue){
                  if($MatchKey == $key){
      ?>
      <h4>
         <!-- img src="{{asset('assets/front_end/images/flag/irre.png')}}"/ -->   
         <?php echo $value[country_name]; ?> - <?php echo $value[league_name]; ?>
      </h4>
      <?php foreach($MatchValue as $infoKey=>$infoValue){ ?>
      <div class="latest_meetings_itme">
         <p><?php echo date("d M y",strtotime($infoValue[0][match_date])); ?></p>
         <p><span><?php echo $infoValue[0][match_hometeam_name]; ?></span> <span><?php echo $infoValue[0][match_awayteam_name]; ?></span></p>
         <p><span><?php echo $infoValue[0][match_hometeam_score]; ?></span> <span><?php echo $infoValue[0][match_awayteam_score]; ?></span></p>
      </div>
      <?php } } } } } } ?>
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
      <?php 
      if(!empty($TeamStat)){ 
         foreach($TeamStat as $value){ 
      ?>
      <div class="statistics_content">
         <p><?php echo $value[team_name];?> </p>
         <p><?php echo $value[matches];?></p>
         <p><?php echo $value[scored];?></p>
         <p><?php echo $value[conceeded];?></p>
      </div>
      <?php } } ?>
   </div>
</div>