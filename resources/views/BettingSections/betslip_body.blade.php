<div id="whole_slip<?php echo $UniqueId; ?>">
<ul class="betingSlipBet betingSlipBetSingles">
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
       <h3><?php if(empty($BetFor)){ echo "--"; }else{ echo $BetFor; } ?> <span><?php echo $CheckOddsValue[0][odds_value]; ?></span></h3>
       <input class="betingSlipBetInput BetStake number-only validate[required]" onkeyup="BetStakeAmount(this.value,'<?php echo $UniqueId; ?>','<?php echo $CheckOddsValue[0][odds_value]; ?>','<?php echo $CheckOddsValue[0][odds_name]; ?>')"type="text" name="" />
       <input  type="hidden" value="0" id="Payment<?php echo $UniqueId; ?>" class="PotentialPayout"/>
    </li>
    <li onclick="RemoveBetSlip('<?php echo $UniqueId; ?>','<?php echo $CheckOddsValue[0][match_id]; ?>')"> x </li>
</ul>
<script>
$('.number-only').on('input', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
</div>