@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header') 
   <!-- Page body content -->
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-sm-7" id="content">
            <div class="dashboard_left">
               <!-- top status section -->
               <div class="status_wrap">
                  <h3>Your Status</h3>
                  <ul class="status_content">
                     <li>
                        <h4>Pro</h4>
                        <p>Level</p>
                     </li>
                     <li>
                        <h4>67%</h4>
                        <p>Hit rate</p>
                     </li>
                     <li>
                        <h4>200</h4>
                        <p>GramS</p>
                     </li>
                     <li>
                        <h4>10</h4>
                        <p>Leaderboard</p>
                     </li>
                  </ul>
                  <div class="clearfix"></div>
               </div>
               <!-- top status section end -->
               <!-- feed section start  -->
               <div class="all_feed_wrap">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="active" ><a href="#news_feed" aria-controls="news_feed" role="tab" data-toggle="tab">News Feed</a></li>
                     <li role="presentation"><a href="#bets" aria-controls="bets" role="tab" data-toggle="tab">My Bets</a></li>
                     <li role="presentation" ><a href="#leaderboard" aria-controls="leaderboard" role="tab" data-toggle="tab">Leaderboard</a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active" id="news_feed">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="row">
                                 <div class="col-sm-12 feed_left ">
                                    <div class="feed_wrapper">
                                       <div class="feed_body_wrap">
                                          <div class="feed_content_wrapper">
                                             <div class="feed_profile_details">
                                                <div class="feed_img">
                                                   <img src="images/user_img.png">
                                                </div>
                                                <div class="feed_user_name">
                                                   <a href="">
                                                      <h4>Morkan Doe <span>2hrs. ago</span></h4>
                                                      <p>Place a bet via ladbrokers</p>
                                                   </a>
                                                </div>
                                             </div>
                                             <div class="feed_body">
                                                <h4>Braga v Benfica</h4>
                                                <p>Match Betting : <span>7th July | 20:30</span></p>
                                             </div>
                                             <div class="feed_chart">
                                                <h3>Benfica <span>@2.80</span></h3>
                                                <h3>Single <span> @2.80</span></h3>
                                             </div>
                                          </div>
                                          <div class="feed_social_wrap">
                                             <ul class="feed_social">
                                                <li>
                                                   <a href="#">
                                                   4
                                                   <i class="fa fa-heart" aria-hidden="true"></i>
                                                   Like
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   1
                                                   <i class="fa fa-clipboard" aria-hidden="true"></i>
                                                   Copy
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-facebook" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-twitter" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-share-alt" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="comment_section">
                                          <input class="form-control" type="text" name="" placeholder="Add a Comment ...">
                                       </div>
                                       <!-- dropdown More -->   
                                       <div class="dropdown feed_more">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                          <img src="./images/arrow_down.png">
                                          </a>
                                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                             <li><a href="#">Demo </a></li>
                                             <li><a href="#">Demo </a></li>
                                             <li><a href="#">Demo</a></li>
                                          </ul>
                                       </div>
                                       <!-- dropdown More -->  
                                    </div>
                                 </div>
                                 <div class="col-sm-12 feed_left win">
                                    <div class="feed_wrapper">
                                       <div class="feed_body_wrap">
                                          <div class="feed_content_wrapper">
                                             <div class="feed_profile_details">
                                                <div class="feed_img">
                                                   <img src="images/user_img.png">
                                                </div>
                                                <div class="feed_user_name">
                                                   <a href="">
                                                      <h4>Morkan Doe <span>2hrs. ago</span></h4>
                                                      <p>Place a bet via ladbrokers</p>
                                                   </a>
                                                </div>
                                             </div>
                                             <div class="feed_body">
                                                <h4>Braga v Benfica</h4>
                                                <p>Match Betting : <span>7th July | 20:30</span></p>
                                             </div>
                                             <div class="feed_chart">
                                                <h3>Benfica <span>@2.80</span></h3>
                                                <h3>Single <span><b>Win</b> @2.80</span></h3>
                                             </div>
                                          </div>
                                          <div class="feed_social_wrap">
                                             <ul class="feed_social">
                                                <li>
                                                   <a href="#">
                                                   4
                                                   <i class="fa fa-heart" aria-hidden="true"></i>
                                                   Like
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   1
                                                   <i class="fa fa-clipboard" aria-hidden="true"></i>
                                                   Copy
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-facebook" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-twitter" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-share-alt" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="comment_section">
                                          <input class="form-control" type="text" name="" placeholder="Add a Comment ...">
                                          <div class="comment_wrap">
                                             <a href="#"><img src="./images/user_img.png"></a>
                                             <p>
                                                <a href="#"> Sumit <span>05:04pm, 18.02.2017</span></a>
                                                Hello world
                                             </p>
                                          </div>
                                          <div class="comment_wrap">
                                             <a href="#"><img src="./images/user_img.png"></a>
                                             <p>
                                                <a href="#"> Sumit <span>05:04pm, 18.02.2017</span></a>
                                                A social betting network where you can place
                                             </p>
                                          </div>
                                       </div>
                                       <!-- dropdown More -->   
                                       <div class="dropdown feed_more">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                          <img src="./images/arrow_down.png">
                                          </a>
                                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                             <li><a href="#">Demo </a></li>
                                             <li><a href="#">Demo </a></li>
                                             <li><a href="#">Demo</a></li>
                                          </ul>
                                       </div>
                                       <!-- dropdown More -->  
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 ">
                              <div class="row">
                                 <div class="col-sm-12 feed_right loss">
                                    <div class="feed_wrapper">
                                       <div class="feed_body_wrap">
                                          <div class="feed_content_wrapper">
                                             <div class="feed_profile_details">
                                                <div class="feed_img">
                                                   <img src="images/user_img.png">
                                                </div>
                                                <div class="feed_user_name">
                                                   <a href="">
                                                      <h4>Morkan Doe <span>2hrs. ago</span></h4>
                                                      <p>Place a bet via ladbrokers</p>
                                                   </a>
                                                </div>
                                             </div>
                                             <div class="feed_body">
                                                <h4>Braga v Benfica</h4>
                                                <p>Match Betting : <span>7th July | 20:30</span></p>
                                             </div>
                                             <div class="feed_chart">
                                                <h3>Benfica <span>@2.80</span></h3>
                                                <h3>Single <span><b>Loss</b> @2.80</span></h3>
                                             </div>
                                          </div>
                                          <div class="feed_social_wrap">
                                             <ul class="feed_social">
                                                <li>
                                                   <a href="#">
                                                   4
                                                   <i class="fa fa-heart" aria-hidden="true"></i>
                                                   Like
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   1
                                                   <i class="fa fa-clipboard" aria-hidden="true"></i>
                                                   Copy
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-facebook" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-twitter" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-share-alt" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="comment_section">
                                          <input class="form-control" type="text" name="" placeholder="Add a Comment ...">
                                       </div>
                                       <!-- dropdown More -->   
                                       <div class="dropdown feed_more">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                          <img src="./images/arrow_down.png">
                                          </a>
                                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                             <li><a href="#">Demo </a></li>
                                             <li><a href="#">Demo </a></li>
                                             <li><a href="#">Demo</a></li>
                                          </ul>
                                       </div>
                                       <!-- dropdown More -->   
                                    </div>
                                 </div>
                                 <div class="col-sm-12 feed_right draw">
                                    <div class="feed_wrapper">
                                       <div class="feed_body_wrap">
                                          <div class="feed_content_wrapper">
                                             <div class="feed_profile_details">
                                                <div class="feed_img">
                                                   <img src="images/user_img.png">
                                                </div>
                                                <div class="feed_user_name">
                                                   <a href="">
                                                      <h4>Morkan Doe <span>2hrs. ago</span></h4>
                                                      <p>Place a bet via ladbrokers</p>
                                                   </a>
                                                </div>
                                             </div>
                                             <div class="feed_body">
                                                <h4>Braga v Benfica</h4>
                                                <p>Match Betting : <span>7th July | 20:30</span></p>
                                             </div>
                                             <div class="feed_chart">
                                                <h3>Benfica <span>@2.80</span></h3>
                                                <h3>Single <span><b>Draw</b> @2.80</span></h3>
                                             </div>
                                          </div>
                                          <div class="feed_social_wrap">
                                             <ul class="feed_social">
                                                <li>
                                                   <a href="#">
                                                   4
                                                   <i class="fa fa-heart" aria-hidden="true"></i>
                                                   Like
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   1
                                                   <i class="fa fa-clipboard" aria-hidden="true"></i>
                                                   Copy
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-facebook" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-twitter" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                                <li>
                                                   <a href="#">
                                                   <i class="fa fa-share-alt" aria-hidden="true"></i>
                                                   </a>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="comment_section">
                                          <input class="form-control" type="text" name="" placeholder="Add a Comment ...">
                                       </div>
                                       <!-- dropdown More -->   
                                       <div class="dropdown feed_more">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                          <img src="./images/arrow_down.png">
                                          </a>
                                          <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                                             <li><a href="#">Demo </a></li>
                                             <li><a href="#">Demo </a></li>
                                             <li><a href="#">Demo</a></li>
                                          </ul>
                                       </div>
                                       <!-- dropdown More -->   
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="bets">
                     </div>
                     <div role="tabpanel" class="tab-pane" id="leaderboard">
                        <div class="Leaderboard_wrap">
                           <div class="LeaderHeader">
                              <h3>Leaderboard</h3>
                              <div class="leaderboardFilter">
                                 <ul>
                                    <li class="active" dayamount="all_time">All time</li>
                                    <li dayamount="60_days">60 Days</li>
                                    <li dayamount="30_days" >30 Days</li>
                                    <li dayamount="7_days" >7 Days</li>
                                 </ul>
                              </div>
                           </div>
                           <div class="leaderboard_body">
                              <div class="panel panel-default">
                                 <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="leader_user">
                                                <p>1</p>
                                                <div class="leader_userDetails">
                                                   <img src="images/user_img.png">
                                                   <h3>
                                                      <a href="#"> John Smith </a>
                                                      <span> 
                                                      <button type="button" class="user_follow">Follow</button>
                                                      </span> 
                                                   </h3>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-8">
                                             <ul class="leader_user_content">
                                                <li class="loss">
                                                   <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                                                </li>
                                                <li>
                                                   <p>310</p>
                                                   <span>followers</span>
                                                </li>
                                                <li>
                                                   <p>0</p>
                                                   <span>placed bets</span>
                                                </li>
                                                <li>
                                                   <i class="fa fa-line-chart" aria-hidden="true"></i>
                                                   <span>profit</span>
                                                </li>
                                                <li class="user_arrow">
                                                   <a role="button" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"></a>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                    </h4>
                                 </div>
                                 <div id="collapseOne" class="panel-collapse collapse " role="tabpanel">
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class="leaderboard_body_content">
                                             <div class="col-md-4">
                                                <ul class="leaderboard_contentLeft">
                                                   <li class="loss">L</li>
                                                   <li class="loss">L</li>
                                                   <li class="loss">L</li>
                                                   <li class="loss">L</li>
                                                   <li class="win">W</li>
                                                </ul>
                                             </div>
                                             <div class="col-md-8">
                                                <ul class="leaderboard_contentRight">
                                                   <li>
                                                      <p>
                                                         <i class="fa fa-heartbeat active" aria-hidden="true"></i>
                                                         <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                                         <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                                      </p>
                                                      <span>risk level</span>
                                                   </li>
                                                   <li>
                                                      <p>
                                                         <i class="fa fa-bolt" aria-hidden="true"></i>
                                                         <i class="fa fa-bolt" aria-hidden="true"></i>
                                                         <i class="fa fa-bolt" aria-hidden="true"></i>
                                                      </p>
                                                      <span>average odd</span>
                                                   </li>
                                                   <li>
                                                      <p>36%</p>
                                                      <span>win rate</span>
                                                   </li>
                                                   <li>
                                                      <button type="button" class="user_view_profile"> View Profile </button>
                                                   </li>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel panel-default">
                                 <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="leader_user">
                                                <p>2</p>
                                                <div class="leader_userDetails">
                                                   <img src="images/user_img.png">
                                                   <h3>
                                                      <a href="#"> John Smith </a>
                                                      <span> 
                                                      <button type="button" class="user_follow">Follow</button>
                                                      </span> 
                                                   </h3>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-8">
                                             <ul class="leader_user_content">
                                                <li class="win">
                                                   <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                                </li>
                                                <li>
                                                   <p>310</p>
                                                   <span>followers</span>
                                                </li>
                                                <li>
                                                   <p>0</p>
                                                   <span>placed bets</span>
                                                </li>
                                                <li>
                                                   <i class="fa fa-line-chart" aria-hidden="true"></i>
                                                   <span>profit</span>
                                                </li>
                                                <li class="user_arrow">
                                                   <a class="accordion-toggle" role="button" data-toggle="collapse"  href="#collapsetwo" aria-expanded="true" aria-controls="collapseOne"></a>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                    </h4>
                                 </div>
                                 <div id="collapsetwo" class="panel-collapse collapse" role="tabpanel">
                                    <div class="panel-body">
                                       <div class="row">
                                          <div class="leaderboard_body_content">
                                             <div class="col-md-4">
                                                <ul class="leaderboard_contentLeft">
                                                   <li class="loss">L</li>
                                                   <li class="loss">L</li>
                                                   <li class="loss">L</li>
                                                   <li class="loss">L</li>
                                                   <li class="win">W</li>
                                                </ul>
                                             </div>
                                             <div class="col-md-8">
                                                <ul class="leaderboard_contentRight">
                                                   <li>
                                                      <p>
                                                         <i class="fa fa-heartbeat active" aria-hidden="true"></i>
                                                         <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                                         <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                                      </p>
                                                      <span>risk level</span>
                                                   </li>
                                                   <li>
                                                      <p>
                                                         <i class="fa fa-bolt" aria-hidden="true"></i>
                                                         <i class="fa fa-bolt" aria-hidden="true"></i>
                                                         <i class="fa fa-bolt" aria-hidden="true"></i>
                                                      </p>
                                                      <span>average odd</span>
                                                   </li>
                                                   <li>
                                                      <p>36%</p>
                                                      <span>win rate</span>
                                                   </li>
                                                   <li>
                                                      <button type="button" class="user_view_profile"> View Profile </button>
                                                   </li>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- feed section end  -->
               <div class="clearfix"></div>
            </div>
         </div>
         <!-- rightbar part Start -->
         @include('common/rightbar')
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/footer')
@include('common/footer_link')
<script>
   $('.sidenav').click (function(){
   
     $('.sidenav').hasClass('showhide')
   
     $(this).toggleClass ('showhide');
   
   }) 
   
</script>