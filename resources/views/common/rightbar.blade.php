<div class="col-md-4 col-sm-5 col-xs-12" id="rightSidebar">
   <div class="right_bar">
      <!-- beting slip  
      <div class="beting_slip">
         <h3>{{__('label.Betslip')}} <span class="clear">
            <i class="fa fa-refresh" aria-hidden="true" onclick="RemoveTotalBetSlip()"></i>
            </span>
         </h3>
         <div id="BetSlip">
         </div>
         <div class="BetSlipEmpty" id="EmptyBetSlip">
            <p>{{__('label.Your Bet Slip Empty')}}</p>
         </div>
         <div class="bat_place_section">
            <div class="betSlipText">
              <input class="form-control" type="text" id="BetComments" placeholder="{{__('label.Write Something about your bet')}}"/>
            </div>
            <a href="javascript:void(0);" class="bet_place" id="PlaceBet">{{__('label.Place bet')}}</a>
            <select class="privacy" id="PrivacySettings">
               <option value="1">{{__('label.Public')}}</option>
               <option value="2">{{__('label.Private')}}</option>
            </select>
            <div class="clearfix"></div>
         </div>
         <div class="betPlace_show" style="display:none;">
            <img src="{{asset('assets/front_end/images/rightbet.png')}}"/>
            <p>{{__('label.You betslip has been added to')}} <br/> {{__('label.your bets')}}</p>
            <a class="Got_section" href="javascript:void(0);">{{__('label.Got it!')}}</a>
         </div>
      </div>
      <!-- beting slip end -->
      
      <div id="FeaturedMatch">
        <div class="featured_match">
           <h3>Featured Match</h3>
           <hr/>
          <div class="featured_icon">
             <div class="teamA">
               <img width="40px" src="{{asset('assets/front_end/images/home_team.png')}}" />    
               <a href="#">
                <p>West Ham</p>
               </a>
             </div>
             <div class="featured_time">
               <p>20:00</p>
               <h5>Today</h5>
             </div>
             <div class="teamB">
              <img width="40px" src="{{asset('assets/front_end/images/away_team.png')}}" />
              <a href="#">
               <p>Tottenham</p>
              </a>
             </div>
           </div>
           <hr class="odd_view" />

           <div class="featured_odds">
             <h4>ODDS</h4>

             <ul class="League_odd_list">
                <li><a id="" href="javascript:void(0);" data-original-title="" title="">6.00</a></li>
                <li><a id="" href="javascript:void(0);" data-original-title="" title="">3.80</a></li>
                <li><a id="" href="javascript:void(0);" data-original-title="" title="">1.57</a></li>
             </ul>

           </div>
        </div>
      </div>     
      
      
      <!-- Recommended  slip start -
      <div class="betingslip_main betingtab">
         <ul class="nav nav-tabs " role="tablist">
            <li role="presentation" class="active"><a href="#plays" aria-controls="plays" role="tab" data-toggle="tab">{{__('label.Recommended plays')}} </a></li>
            <li role="presentation"><a href="#betters" aria-controls="betters" role="tab" data-toggle="tab">{{__('label.Recommended Bettors')}}</a></li>
         </ul>
         <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="plays">
               <div class="plays_bet_wrap">
                  <div class="place_bet">
                     <div class="place_bet_img">
                        <img src="{{asset('assets/front_end/images/football_color.png')}}"/>
                     </div>
                     <div class="place_bet_content">
                        <h4>Juventus  <b>@1,45</b>  <span>{{__('label.matchday')}} - 20th September</span></h4>
                        <p>{{__('label.Matchodds')}} 1x2</p>
                        <p>Juventus vs AIK</p>
                        <a href="#">{{__('label.Place bet')}}</a>
                     </div>
                  </div>
                  <div class="place_bet">
                     <div class="place_bet_img">
                        <img src="{{asset('assets/front_end/images/basketball_color.png')}}"/>
                     </div>
                     <div class="place_bet_content">
                        <h4>Cavaliers <b>@1,45</b>  <span>{{__('label.matchday')}} - 20th September</span></h4>
                        <p>{{__('label.Matchodds')}} 1x2</p>
                        <p>Juventus vs AIK</p>
                        <a href="#">{{__('label.Place bet')}}</a>
                     </div>
                  </div>
                  <div class="place_bet">
                     <div class="place_bet_img">
                        <img src="{{asset('assets/front_end/images/boxing_color.png')}}">
                     </div>
                     <div class="place_bet_content">
                        <h4>Juventus  <b>@1,45</b>  <span>{{__('label.matchday')}} - 20th September</span></h4>
                        <p>{{__('label.Matchodds')}}  1x2</p>
                        <p>Juventus vs AIK</p>
                        <a href="#">{{__('label.Place bet')}}</a>
                     </div>
                  </div>
               </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="betters">
               <div class="betters_bet_wrap">
                  <div class="place_bet">
                     <div class="place_bet_img">
                        <img src="{{asset('assets/front_end/images/football_color.png')}}">
                     </div>
                     <div class="place_bet_content">
                        <h4>Juventus  <b>@1,45</b>  <span>{{__('label.matchday')}} - 20th September</span></h4>
                        <p>{{__('label.Matchodds')}} 1x2</p>
                        <p>Juventus vs AIK</p>
                        <a href="#">{{__('label.Place bet')}}</a>
                     </div>
                  </div>
                  <div class="place_bet">
                     <div class="place_bet_img">
                        <img src="{{asset('assets/front_end/images/basketball_color.png')}}">
                     </div>
                     <div class="place_bet_content">
                        <h4>Cavaliers <b>@1,45</b>  <span>{{__('label.matchday')}} - 20th September</span></h4>
                        <p>{{__('label.Matchodds')}} 1x2</p>
                        <p>Juventus vs AIK</p>
                        <a href="#">{{__('label.Place bet')}}</a>
                     </div>
                  </div>
                  <div class="place_bet">
                     <div class="place_bet_img">
                        <img src="{{asset('assets/front_end/images/boxing_color.png')}}">
                     </div>
                     <div class="place_bet_content">
                        <h4>Juventus  <b>@1,45</b>  <span>{{__('label.matchday')}} - 20th September</span></h4>
                        <p>{{__('label.Matchodds')}}  1x2</p>
                        <p>Juventus vs AIK</p>
                        <a href="#">{{__('label.Place bet')}}</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
       Recommended slip start -->
      <!-- following section start 
      <div class="bestoffer_wrap">
         <h3>{{__('label.Best Offer')}}</h3>
         <div class="offer_section">
            <img src="{{asset('assets/front_end/images/offer1.png')}}"/>
            <a href="">{{__('label.Explore')}}</a>
            <div class="clearfix"></div>
         </div>
         <div class="offer_section">
            <img src="{{asset('assets/front_end/images/offer2.png')}}"/>
            <a href="">{{__('label.Explore')}}</a>
            <div class="clearfix"></div>
         </div>
         <div class="offer_section">
            <img src="{{asset('assets/front_end/images/offer3.png')}}"/>
            <a href="">{{__('label.Explore')}}</a>
            <div class="clearfix"></div>
         </div>
      </div>
      <!-- following section start -->
      <!-- footer design -->
        <!--div class="footer_wrap">
           <p><a href="#">betogram.com</a> <i class="fa fa-copyright" aria-hidden="true"></i> 2017</p>
           <div class="languages">
             <div class="dropdown languages_drop">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  Langauge <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </a>
                  <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    <li><a  href="javascript:void(0)" onclick="SelectLangauge('en')">English</a></li>
                    <li><a  href="javascript:void(0)" onclick="SelectLangauge('sek')">Swedish</a></li>
                  </ul>
              </div>
           </div>
           <ul class="footer_link">
              <li><a href="#">Our service</a></li>
              <li><a href="#">About us </a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">FAQ</a></li>
           </ul>
        </div-->
      <!-- footer design end-->


      <!-- Ad list -->

      <div class="ad_item">
        <h2> Branding </h2>
        <div class="ad_holder">
          <iframe width="100%" scrolling='no' frameBorder='0' style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;' width='150' height='100' src="https://wlpinnacle.adsrv.eacdn.com/I.ashx?btag=a_18616b_11808c_&affid=17720&siteid=18616&adid=11808&c=" ></iframe>
        </div>
         <div class="ad_holder">
          <iframe width="100%" scrolling='no' frameBorder='0' style='padding:0px; margin:0px; border:0px;border-style:none;border-style:none;' width='150' height='100' src="https://wlpinnacle.adsrv.eacdn.com/I.ashx?btag=a_18616b_11808c_&affid=17720&siteid=18616&adid=11808&c=" ></iframe>
        </div>
      </div>



   </div>
</div>
