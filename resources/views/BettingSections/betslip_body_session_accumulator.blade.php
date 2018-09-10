<?php
//aa($GetSessionData);
if(!empty($GetSessionData))
{
    foreach($GetSessionData as $key=>$value)
    {
?>
<div id="whole_slip_accu<?php echo $value[betslip_id]; ?>" class="CommonClass <?php echo $value[match_id]; ?>">
<ul class="betingSlipBet betingSlipBetCombination">
    <li>
       <h4 data-toggle="tooltip" title="<?php echo $value[home_team]; ?> | <?php echo $value[away_team]; ?>">
       <?php
         if(strlen($value[home_team]) > 10)
         {
           echo substr($value[home_team],0,10)."...";
         } else{
           echo $value[home_team];
         }
         ?> |
      <?php
         if(strlen($value[away_team]) > 10)
         {
           echo substr($value[away_team],0,10)."...";
         } else{
           echo $value[away_team];
         }
         ?>
       </h4>
       <p><?php echo $value[market]; ?></p>
       <h3><?php if(empty($value[Odds_type])){ echo "--"; }else{ echo $value[Odds_type]; } ?> <span class="Accu_odds"><?php echo $value[bet_odds]; ?></span></h3>
       <input type="hidden" class="MacthId" value="<?php echo $value[match_id]; ?>"/>
    </li>
    <li onclick="RemoveBetSlip('<?php echo $value[betslip_id];; ?>','<?php echo $value[match_id]; ?>')"> x </li>
</ul>
</div>
<?php        
    }   
} 
?>