<?php
use App\Users;
use App\follow_users;
?>
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
               <!-- feed section start  -->
               <div class="all_feed_wrap">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="active">
                        <a href="#followers" aria-controls="followers" role="tab" data-toggle="tab">Followers </a>
                     </li>
                     <li role="presentation">
                        <a href="#following" aria-controls="following" role="tab" data-toggle="tab">Following</a>
                     </li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active" id="followers">
                        <div class="Leaderboard_wrap">
                           <div class="leaderboard_body follow_body">
                            <?php 
                            if(!empty($FollowersData)) 
                            { 
                                foreach($FollowersData as $KeyFollowers=>$ValueFollowers) 
                                { 
                                    $UserDetails = Users::where('id',$ValueFollowers[from_userid])->get()->toArray();
                                    if(!empty($UserDetails))
                                    {
                                        foreach($UserDetails as $KeyUser=>$ValueUser)
                                        {
                            ?>
                             <div class="panel panel-default">
                                 <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="leader_user">
                                                <div class="leader_userDetails">
                                                   <?php if($ValueUser[profile_picture] == '') { ?>
                                                   <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                                                   <?php } else { ?>
                                                   <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$ValueUser[profile_picture]; ?>"/>
                                                   <?php } ?>
                                                   <h3>
                                                        <a href="{{url('visit-user-profile')}}/<?php echo $ValueUser[id]; ?>"> <?php echo $ValueUser[name]; ?></a>
                                                   </h3>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-8">
                                             <ul class="leader_user_content">
                                             <?php
                                             $GetFollowers = follow_users::where('to_user_id',$ValueUser[id])->get()->toArray();
                                             $CountFollowers = count($GetFollowers);
                                             ?>
                                                <li class="pull-left">
                                                   <p><?php echo $CountFollowers; ?></p>
                                                   <span><?php if($CountFollowers == 0 || $CountFollowers == 1) { echo 'follower'; }else{ echo 'followers'; }?></span>
                                                </li>
                                                <li class="pull-left">
                                                   <p>0</p>
                                                   <span>placed bets</span>
                                                </li>
                                                <li class="user_arrow pull-right">
                                                   <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $KeyFollowers; ?>" aria-expanded="true" aria-controls="collapseOne"></a>
                                                </li>
                                                <!--<?php 
                                                $user_id = Session::get('user_id');
                                                $UserFollowData = follow_users::where('from_userid',$user_id)->where('to_user_id',$ValueUser[id])->get()->toArray();
                                                ?>
                                                <?php if(empty($UserFollowData)) { ?>
                                                <li class="pull-right">
                                                   <button type="button" id="follow<?php echo $ValueUser[id]; ?>" class="user_follow active" onclick="FollowUser('<?php echo $ValueUser[id];?>','<?php echo $ValueUser[name];?>')">Follow</button>
                                                </li>
                                                <?php }else{ ?>
                                                <li class="pull-right">
                                                   <button type="button" id="follow<?php echo $ValueUser[id]; ?>" class="user_follow active" onclick="FollowUser('<?php echo $ValueUser[id];?>','<?php echo $ValueUser[name];?>')">Unfollow</button>
                                                </li>
                                                <?php } ?>-->
                                                <div class="clearfix"></div>
                                             </ul>
                                          </div>
                                       </div>
                                    </h4>
                                 </div>
                                 <div id="collapse<?php echo $KeyFollowers; ?>" class="panel-collapse collapse " role="tabpanel">
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
                                                      <button type="button" class="user_view_profile" onclick="location.href='{{url('view-user-profile')}}/<?php echo $ValueUser[id]; ?>'"> View Profile </button>
                                                   </li>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php } } }  }else{ ?>
                              <p class="No_team_info">No followers found</p>
                              <?php } ?>
                            </div>
                        </div>
                     </div>
                     <div role="tabpanel" class="tab-pane" id="following">
                     
                       
                        <div class="Leaderboard_wrap">
                           <div class="leaderboard_body follow_body">
                              <?php 
                              if(!empty($FetchUserData)) 
                              { 
                                    foreach($FetchUserData as $DataKey=>$DataValue) 
                                    { 
                                        $user_id = Session::get('user_id');
                                        if($DataValue[id] != $user_id) 
                                        {
                                            $UserFollowData = follow_users::where('from_userid',$user_id)->where('to_user_id',$DataValue[id])->get()->toArray();
                                            if(!empty($UserFollowData)) {
                                                foreach($UserFollowData as $ValueUserData)
                                                {
                              ?>
                              <div class="panel panel-default">
                                 <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="leader_user">
                                                <div class="leader_userDetails">
                                                   <?php if($DataValue[profile_picture] == '') { ?>
                                                   <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                                                   <?php } else { ?>
                                                   <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$DataValue[profile_picture]; ?>"/>
                                                   <?php } ?>
                                                   <h3>
                                                        <a href="{{url('visit-user-profile')}}/<?php echo $DataValue[id]; ?>"> <?php echo $DataValue[name]; ?></a>
                                                   </h3>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-8">
                                             <ul class="leader_user_content">
                                             <?php
                                             $GetFollowers = follow_users::where('to_user_id',$DataValue[id])->get()->toArray();
                                             $CountFollowers = count($GetFollowers);
                                             ?>
                                                <li class="pull-left">
                                                   <p><?php echo $CountFollowers; ?></p>
                                                   <span><?php if($CountFollowers == 0 || $CountFollowers == 1) { echo 'follower'; }else{ echo 'followers'; }?></span>
                                                </li>
                                                <li class="pull-left">
                                                   <p>0</p>
                                                   <span>placed bets</span>
                                                </li>
                                                <li class="user_arrow pull-right">
                                                   <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#Unfollow<?php echo $DataKey; ?>" aria-expanded="true" aria-controls="Unfollow1"></a>
                                                </li>
                                                <?php 
                                                //$user_id = Session::get('user_id');
                                                //$UserFollowData = follow_users::where('from_userid',$user_id)->where('to_user_id',$DataValue[id])->get()->toArray();
                                                ?>
                                                <?php //if(!empty($UserFollowData)) { ?>
                                                <li class="pull-right">
                                                   <button type="button" id="follow<?php echo $DataValue[id]; ?>" class="user_follow active" onclick="FollowUser('<?php echo $DataValue[id];?>','<?php echo $DataValue[name];?>')">Unfollow</button>
                                                </li>
                                                <?php //} ?>
                                                <div class="clearfix"></div>
                                             </ul>
                                          </div>
                                       </div>
                                    </h4>
                                 </div>
                                 <div id="Unfollow<?php echo $DataKey; ?>" class="panel-collapse collapse " role="tabpanel">
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
                                                      <button type="button" class="user_view_profile" onclick="location.href='{{url('view-user-profile')}}/<?php echo $DataValue[id]; ?>'"> View Profile </button>
                                                   </li>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php } } } } } ?>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                      <!-- friend suggestion  -->  
                        
                        
                         <div class="Leaderboard_wrap">
                         <h2>Suggestions</h2>
                           <div class="leaderboard_body follow_body">
                              <?php 
                              if(!empty($FetchUserData)) 
                              { 
                                    foreach($FetchUserData as $DataKey=>$DataValue) 
                                    { 
                                        $user_id = Session::get('user_id');
                                        if($DataValue[id] != $user_id) 
                                        {
                                            $UserFollowData = follow_users::where('from_userid',$user_id)->where('to_user_id',$DataValue[id])->get()->toArray();
                                            if(empty($UserFollowData)) {
            
                              ?>
                              <div class="panel panel-default">
                                 <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="leader_user">
                                                <div class="leader_userDetails">
                                                   <?php if($DataValue[profile_picture] == '') { ?>
                                                   <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                                                   <?php } else { ?>
                                                   <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$DataValue[profile_picture]; ?>"/>
                                                   <?php } ?>
                                                   <h3>
                                                        <a href="{{url('visit-user-profile')}}/<?php echo $DataValue[id]; ?>"> <?php echo $DataValue[name]; ?></a>
                                                   </h3>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-8">
                                             <ul class="leader_user_content">
                                             <?php
                                             $GetFollowers = follow_users::where('to_user_id',$DataValue[id])->get()->toArray();
                                             $CountFollowers = count($GetFollowers);
                                             ?>
                                                <li class="pull-left">
                                                   <p><?php echo $CountFollowers; ?></p>
                                                   <span><?php if($CountFollowers == 0 || $CountFollowers == 1) { echo 'follower'; }else{ echo 'followers'; }?></span>
                                                </li>
                                                <li class="pull-left">
                                                   <p>0</p>
                                                   <span>placed bets</span>
                                                </li>
                                                <li class="user_arrow pull-right">
                                                   <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#Unfollow<?php echo $DataKey; ?>" aria-expanded="true" aria-controls="Unfollow1"></a>
                                                </li>
                                                <?php 
                                                //$user_id = Session::get('user_id');
                                                //$UserFollowData = follow_users::where('from_userid',$user_id)->where('to_user_id',$DataValue[id])->get()->toArray();
                                                ?>
                                                <?php //if(empty($UserFollowData)) { ?>
                                                <li class="pull-right">
                                                   <button type="button" id="follow<?php echo $DataValue[id]; ?>" class="user_follow active" onclick="FollowUser('<?php echo $DataValue[id];?>','<?php echo $DataValue[name];?>')">Follow</button>
                                                </li>
                                                <?php //} ?>
                                                <div class="clearfix"></div>
                                             </ul>
                                          </div>
                                       </div>
                                    </h4>
                                 </div>
                                 <div id="Unfollow<?php echo $DataKey; ?>" class="panel-collapse collapse " role="tabpanel">
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
                                                      <button type="button" class="user_view_profile" onclick="location.href='{{url('view-user-profile')}}/<?php echo $DataValue[id]; ?>'"> View Profile </button>
                                                   </li>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php } } } } ?>
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
@include('common/footer_link')

<script type="text/javascript">
   $('.accordion-toggle').click( function() {
     $(".accordion-toggle").toggleClass("add_arrow");
   } );
</script>
<script>
function FollowUser(FollowingUserId,FollowingUserName)
{
    if(FollowingUserId != '')
    {
        $.ajax({
              url:"{{url('Follwing-User')}}",
              type:'POST',
              headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
              data: {'FollowingUserId':FollowingUserId,'FollowingUserName':FollowingUserName},
              success:function(result)
              {
                    //console.log(result);
                    if(result == 'follow')
                    {
                        //$("#follow3").text('Unfollow');
                        $("#follow"+FollowingUserId).text('Unfollow');
                        location.reload();
                    }else{
                        $("#follow"+FollowingUserId).text('Follow');
                        location.reload();
                    }
              }
        });
    }
}
</script>