<!--current betting slip-->
<!-- Betting slip sticky start-->
<div class="open_slip" id="Open_bet_slip">
   <a href="javascript:void(0);">
   <img src="{{asset('assets/front_end/images/slip.svg')}}"/>
   <span class="slip_count">0</span>
   </a>
</div>
<div class="BetSlipContainer" id="BetSlipWrapSticky" >
   <div class="panel panel-default">
      <div class="panel-heading top-bar">
         <h3 class="panel-title">
            Betting Slip
            <span class="slipActivity">
            <a href="javascript:void(0);" class="closeBet">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </span>
            </a>
            <!-- <a href="#">
               <i class="fa fa-thumb-tack icon_close" data-id="BetSlipWrap" aria-hidden="true"></i>

               </a> -->
            </span>
         </h3>
      </div>
      <div class="panel-body ">
         <ul class="slip_tab" role="tablist">
            <li role="presentation" class="active" >
               <a href="#singles" aria-controls="singles" role="tab" data-toggle="tab">
               Singles
                   <span class="betingSlipInfo  betingSlipInfoSingel " id="" data-original-title="" title="">
                     <i class="fa fa-info-circle" aria-hidden="true" data-original-title="" title=""></i>
                     <div class="betting_slip_info betting_slip_infosingle" data-original-title="" title="">
                      <ul id="SingleBetInfo">
                      </ul>
                    </div>
                   </span>
               </a>
            </li>
            <li role="presentation">
               <a href="#combination" aria-controls="combination" role="tab" data-toggle="tab">
               Accumulator
                   <span class="betingSlipInfo  " id="" data-original-title="" title="">
                     <i class="fa fa-info-circle" aria-hidden="true" data-original-title="" title=""></i>
                     <div class="betting_slip_info betting_slip_infocombo" data-original-title="" title="">
                      <ul id="AccumulatorInfo">
                      </ul>
                    </div>
                   </span>
               </a>
            </li>
            <div class="clearfix"></div>
         </ul>
         <div class="tab-content slip_tab_content">
            <div role="tabpanel" class="tab-pane active" id="singles">
               <div class="slip_container_base">
                  <div class="no_bet" style="display: block;" id="EmptyBetSlip">
                     <img src="{{asset('assets/front_end/images/empty.svg')}}"/>
                     <h3>Your betslip is empty</h3>
                  </div>
                  <div class="betingSlipBody" id="BetSlip">
                  </div>
               </div>
               <div class="betslip_Footer">
                  <div class="betSlipText">
                      <input class="form-control Comments" type="text" id="BetComments" placeholder="{{__('label.Write Something about your bet')}}"/>
                      <div class="dropdown privacy_setting">
                          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                           <i class="fa fa-ellipsis-v"></i>
                          </a>
                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                            <input type="hidden" value="" id="PrivacyValue"/>
                            <li><a class="active" id="Public" href="javascript:void(0)" onclick="SelectPrivacy('Public')">{{__('label.Public')}}</a></li>
                            <li><a class="" id="Private" href="javascript:void(0)" onclick="SelectPrivacy('Private')">{{__('label.Private')}}</a></li>
                          </ul>
                      </div>
                  </div>
                  <h3>Total stake :   <span id="TotalStake">0</span></h3>
                  <h3>Potential payout :   <span class="PotentialPayout" id="TotalReturn">0</span></h3>
                  <button type="button" id="PlaceBet" onclick="PlaceBetConfirmation()">Place Bet</button>
               </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="combination">
               <div class="slip_container_base accumulator_slip_container_base">
                  <div class="no_bet" style="display: none;" id="EmptyBetSlipAccu">
                     <img src="{{asset('assets/front_end/images/empty.svg')}}"/>
                     <h3>Your betslip is empty</h3>
                  </div>
                  <div class="betingSlipBody" id="BettingSlipAccumulator">
                  </div>
               </div>
               <div class="betslip_Footer">
                   <div class="betSlipText">
                      <input class="form-control Comments" type="text" id="BetCommentsAccu" placeholder="{{__('label.Write Something about your bet')}}"/>
                      <div class="dropdown privacy_setting">
                          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                           <i class="fa fa-ellipsis-v"></i>
                          </a>
                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                            <input type="hidden" value="" id="PrivacyValueAccu"/>
                            <li><a class="active" id="Accu_public" href="javascript:void(0)" onclick="SelectPrivacyForAccumulator('Public')">{{__('label.Public')}}</a></li>
                            <li><a class="" id="Accu_private" href="javascript:void(0)" onclick="SelectPrivacyForAccumulator('Private')">{{__('label.Private')}}</a></li>
                          </ul>
                      </div>
                   </div>
                  <div class="bet_form_wrap">
                     <span>Stake : </span>
                     <input type="text" name="" class="bet_form number-only" id="Accu_Stake" onkeyup="AccumulatorStake(this.value)"/>
                  </div>
                  <div class="clearfix"></div>
                  <h3>Total Odds :   <span id="Accu_odds">0.00</span></h3>
                  <h3>Total stake :   <span id="Accu_stake">0.00</span></h3>
                  <h3>Potential payout :   <span id="Accu_payout">0.00</span></h3>
                  <button type="button" onclick="AccumulatorBetPlaceConfirmation()" id="AccumulatorId">Place Bet</button>
               </div>
            </div>
        </div>
        <div class="betPlace_show" style="display:none;" id="display_confirmation_alert">
            <img src="{{asset('assets/front_end/images/rightbet.png')}}"/>
            <p>{{__('label.You betslip has been added to')}} <br/> {{__('label.your bets')}}</p>
            <a class="Got_section" href="javascript:void(0);" onclick="PlaceBet()">{{__('label.Okay')}}</a>
        </div>
        <div class="betPlace_show" style="display:none;" id="display_confirmation_alert_accu">
            <img src="{{asset('assets/front_end/images/rightbet.png')}}"/>
            <p>{{__('label.You betslip has been added to')}} <br/> {{__('label.your bets')}}</p>
            <a class="Got_section" href="javascript:void(0);" onclick="PlaceAccumulatorBet()">{{__('label.Okay')}}</a>
        </div>
      </div>
   </div>
</div>
<!--current betting slip-->
<script>
$('.number-only').on('input', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>