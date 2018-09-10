<?php
if(!empty($GetAccumulatorBetInfo))
{
?>
	<li> Minimum number of Combination: <?php echo $GetAccumulatorBetInfo[0][minimum_combination]; ?> </li>
	<li> Maximum number of Combination: <?php echo $GetAccumulatorBetInfo[0][maximum_combination]; ?> </li>
	<li> Minimum Stake : <?php echo $GetAccumulatorBetInfo[0][minimum_stake]; ?> </li>
	<!--li> Maximum Stake : <?php echo $GetAccumulatorBetInfo[0][maximum_stake]; ?> </li>
	<li> Maximum Prize : <?php echo $GetAccumulatorBetInfo[0][maximum_prize]; ?>  </li-->
<?php
}
?>