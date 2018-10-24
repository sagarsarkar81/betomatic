<div id="whole_slip<?php echo $UniqueId; ?>">
<ul class="betingSlipBet betingSlipBetSingles">
    <li>
       <h4 data-toggle="tooltip" title="@php echo $homeTeam; @endphp | @php echo $awayTeam; @endphp">
        @php
         if(strlen($homeTeam) > 10)
         {
           echo substr($homeTeam,0,10)."...";
         } else{
           echo $homeTeam;
         }
        @endphp |
        @php
         if(strlen($awayTeam) > 10)
         {
           echo substr($awayTeam,0,10)."...";
         } else{
           echo $awayTeam;
         }
        @endphp
       </h4>
       <p>@php echo $BetType; @endphp</p>
       <h3>@php if(empty($BetFor)){ echo "--"; }else{ echo $BetFor; } @endphp <span>@php echo $OddsValue; @endphp</span></h3>
       <input class="betingSlipBetInput BetStake number-only validate[required]" onkeyup="BetStakeAmount(this.value,@php echo $UniqueId; @endphp,@php echo $OddsValue; @endphp,'@php echo $BetType; @endphp')" type="text" name="" />
       <input  type="hidden" value="0" id="Payment<?php echo $UniqueId; ?>" class="PotentialPayout"/>
    </li>
    <li onclick="RemoveBetSlip(@php echo $UniqueId; @endphp,@php echo $MatchId; @endphp)"> x </li>
</ul>
<script>
$('.number-only').on('input', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
</div>