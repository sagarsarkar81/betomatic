<?php
if($BetFor == 'Home')
{ 
?>
<div class="slip_content" id="slip<?php echo $UniqueId; ?>">
    <div class="bet_slip_content">
       <h4><?php echo $CheckOddsValue[0][home_team]; ?>  <b>@<?php echo $CheckOddsValue[0][odds_value]; ?></b>  <span>matchday - <?php echo $EventDate = date("jS F",strtotime($CheckOddsValue[0][match_betting_date])); ?></span></h4>
       <p>Match Winner</p>
       <p><?php echo $CheckOddsValue[0][home_team] .' vs '. $CheckOddsValue[0][away_team]; ?></p>
       <div class="row">
          <div class="col-md-6">
             <input type="text" name="" placeholder="Enter stake" class="BetStake form-control bet_slip_input number-only validate[required]" onkeyup="BetStakeAmount(this.value,'<?php echo $UniqueId; ?>','<?php echo $CheckOddsValue[0][odds_value]; ?>','Home')"/> 
          </div>
          <div class="col-md-6">
             <p class="slip_peyment" id="Payment<?php echo $UniqueId; ?>">Payment :</p>
          </div>
       </div>
    </div>
    <div class="close_img">
    <a href="javascript:void(0);" onclick="RemoveBetSlip(<?php echo $UniqueId; ?>)">
        <img src="{{asset('assets/front_end/images/close.png')}}"/>
    </a>
    </div>
</div>
<?php 
}elseif($BetFor == 'Draw')
{
?>
<div class="slip_content" id="slip<?php echo $UniqueId; ?>">
    
    <div class="bet_slip_content">
       <h4>Draw  <b>@<?php echo $CheckOddsValue[0][odds_value]; ?></b>  <span>matchday - <?php echo $EventDate = date("jS F",strtotime($CheckOddsValue[0][match_betting_date])); ?></span></h4>
       <p>Match Winner</p>
       <p><?php echo $CheckOddsValue[0][home_team] .' vs '. $CheckOddsValue[0][away_team]; ?></p>
       <div class="row">
          <div class="col-md-6">
             <input type="text" name="" placeholder="Enter stake" class="BetStake form-control bet_slip_input number-only validate[required]" onkeyup="BetStakeAmount(this.value,'<?php echo $UniqueId; ?>','<?php echo $CheckOddsValue[0][odds_value]; ?>','Draw')"/> 
          </div>
          <div class="col-md-6">
             <p class="slip_peyment" id="Payment<?php echo $UniqueId; ?>">Payment :</p>
          </div>
       </div>
    </div>
    <div class="close_img">
    <a href="javascript:void(0);" onclick="RemoveBetSlip(<?php echo $UniqueId; ?>)">
        <img src="{{asset('assets/front_end/images/close.png')}}"/>
    </a>
    </div>
</div>
<?php 
}else{
?>
<div class="slip_content" id="slip<?php echo $UniqueId; ?>">
    
    <div class="bet_slip_content">
       <h4><?php echo $CheckOddsValue[0][away_team]; ?>  <b>@<?php echo $CheckOddsValue[0][odds_value]; ?></b>  <span>matchday - <?php echo $EventDate = date("jS F",strtotime($CheckOddsValue[0][match_betting_date])); ?></span></h4>
       <p>Match Winner</p>
       <p><?php echo $CheckOddsValue[0][home_team] .' vs '. $CheckOddsValue[0][away_team]; ?></p>
       <div class="row">
          <div class="col-md-6">
             <input type="text" name="" placeholder="Enter stake" class="BetStake form-control bet_slip_input number-only validate[required]" onkeyup="BetStakeAmount(this.value,'<?php echo $UniqueId; ?>','<?php echo $CheckOddsValue[0][odds_value]; ?>','Away')"/> 
          </div>
          <div class="col-md-6">
             <p class="slip_peyment" id="Payment<?php echo $UniqueId; ?>">Payment :</p>
          </div>
       </div>
    </div>
    <div class="close_img">
    <a href="javascript:void(0);" onclick="RemoveBetSlip(<?php echo $UniqueId; ?>)">
        <img src="{{asset('assets/front_end/images/close.png')}}"/>
    </a>
    </div>
</div>
<?php    
}
?>
<script>
$('.number-only').on('input', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
