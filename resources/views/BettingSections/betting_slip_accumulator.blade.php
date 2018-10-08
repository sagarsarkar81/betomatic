<div id="whole_slip_accu<?php echo $UniqueId; ?>" class="CommonClass <?php echo $CheckOddsValue[0][match_id]; ?>">
<ul class="betingSlipBet betingSlipBetCombination">
    <li>
       <h4 data-toggle="tooltip" title="<?php echo $CheckOddsValue[0][match_hometeam_name]; ?> | <?php echo $CheckOddsValue[0][match_awayteam_name]; ?>">
       <?php
         if(strlen($CheckOddsValue[0][match_hometeam_name]) > 10)
         {
           echo substr($CheckOddsValue[0][match_hometeam_name],0,10)."...";
         } else{
           echo $CheckOddsValue[0][match_hometeam_name];
         }
         ?> |
      <?php
         if(strlen($CheckOddsValue[0][match_awayteam_name]) > 10)
         {
           echo substr($CheckOddsValue[0][match_awayteam_name],0,10)."...";
         } else{
           echo $CheckOddsValue[0][match_awayteam_name];
         }
         ?>
       </h4>
       <p><?php echo $CheckOddsValue[0][market]; ?></p>
       <h3><?php echo $BetFor; ?> <span class="Accu_odds"><?php echo $CheckOddsValue[0][odds_value]; ?></span></h3>
       <input type="hidden" class="MacthId" value="<?php echo $CheckOddsValue[0][match_id]; ?>"/>
    </li>
    <li onclick="RemoveBetSlip('<?php echo $UniqueId; ?>','<?php echo $CheckOddsValue[0][match_id]; ?>')"> x </li>
</ul>
</div>