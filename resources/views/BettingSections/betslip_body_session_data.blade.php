<?php
//aa($GetSessionData);
if(!empty($GetSessionData))
{
    foreach($GetSessionData as $key=>$value)
    {
?>
<div id="whole_slip<?php echo $value[betslip_id]; ?>">
<ul class="betingSlipBet betingSlipBetSingles">
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
       <h3><?php if(empty($value[Odds_type])){ echo "--"; }else{ echo $value[Odds_type]; } ?> <span><?php echo $value[bet_odds]; ?></span></h3>
       <input value="<?php if(empty($value[stake_amount])) { echo "0"; }else{ echo $value[stake_amount]; } ?>" class="betingSlipBetInput BetStake number-only validate[required]" onkeyup="BetStakeAmount(this.value,'<?php echo $value[betslip_id]; ?>','<?php echo $value[bet_odds]; ?>','<?php echo $value[Odds_type]; ?>')"type="text" name="" />
       <input  type="hidden" value="<?php if(!empty($value[stake_amount])) { echo $return = ($value[stake_amount] * $value[bet_odds]); }else{ echo "0"; } ?>" id="Payment<?php echo $value[betslip_id]; ?>" class="PotentialPayout"/>
    </li>
    <li onclick="RemoveBetSlip('<?php echo $value[betslip_id]; ?>','<?php echo $value[match_id]; ?>')"> x </li>
</ul>
<script>
$('.number-only').on('input', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
</div>
<?php        
    }   
} 
?>