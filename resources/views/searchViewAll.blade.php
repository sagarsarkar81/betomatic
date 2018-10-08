<?php
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
                  <div class="live_search_result">
                     <p>See your search result <span>"<?php echo $username;?>"</span></p>
                  </div>
                  <!-- Tab panes -->
                  <div class="Leaderboard_wrap">
                     <div class="leaderboard_body follow_body">
                     <?php 
                     if(!empty($GetAllUser)) 
                     {
                        foreach($GetAllUser as $UserKey=>$userValue)
                        {
                            $user_id = Session::get('user_id');
                            if($userValue[id] != $user_id) 
                            {
                     ?>
                        <div class="panel panel-default">
                           <div class="panel-heading" role="tab" id="headingOne">
                              <h4 class="panel-title">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="leader_user">
                                          <div class="leader_userDetails">
                                            <?php if($userValue[profile_picture] == '') {?>
                                            <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                                            <?php } else { ?>
                                             <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$userValue[profile_picture]; ?>"/>
                                             <?php } ?>
                                             <h3>
                                                <a href="{{url('visit-user-profile')}}/<?php echo $userValue[id]; ?>"> <?php echo $userValue[user_name]; ?></a>
                                             </h3>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <ul class="leader_user_content">
                                          <?php
                                          $GetFollowers = follow_users::where('to_user_id',$userValue[id])->get()->toArray();
                                          $CountFollowers = count($GetFollowers);
                                          ?>
                                          <li class="pull-left">
                                             <p><?php echo $CountFollowers;?></p>
                                             <span><?php if($CountFollowers == 0 || $CountFollowers == 1) { echo 'Follower'; }else{ echo 'Followers'; }?></span>
                                          </li>
                                          <li class="pull-left">
                                             <p>0</p>
                                             <span>placed bets</span>
                                          </li>
                                          <li class="user_arrow pull-right">
                                             <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $UserKey; ?>" aria-expanded="true" aria-controls="collapseOne"></a>
                                          </li>
                                          <?php 
                                          $user_id = Session::get('user_id');
                                          $UserFollowData = follow_users::where('from_userid',$user_id)->where('to_user_id',$userValue[id])->get()->toArray();
                                          ?>
                                          <?php if(empty($UserFollowData)) { ?>
                                          <li class="pull-right">
                                            <button type="button" id="follow<?php echo $userValue[id]; ?>" class="user_follow active" onclick="FollowUser('<?php echo $userValue[id];?>','<?php echo $userValue[user_name];?>')">Follow</button>
                                          </li>
                                          <?php }else{ ?>
                                          <li class="pull-right">
                                            <button type="button" id="follow<?php echo $userValue[id]; ?>" class="user_follow active" onclick="FollowUser('<?php echo $userValue[id];?>','<?php echo $userValue[user_name];?>')">Unfollow</button>
                                          </li>
                                          <?php } ?>
                                          <div class="clearfix"></div>
                                       </ul>
                                    </div>
                                 </div>
                              </h4>
                           </div>
                           <div id="collapse<?php echo $UserKey; ?>" class="panel-collapse collapse " role="tabpanel">
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
                                                <button type="button" class="user_view_profile" onclick="location.href='{{url('view-user-profile')}}/<?php echo $userValue[id]; ?>'"> View Profile </button>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } } } ?>
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
<script>
   $('.sidenav').click (function(){
     $('.sidenav').hasClass('showhide')
     $(this).toggleClass ('showhide');
   }) 
</script>
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
                    if(result == 'follow')
                    {
                        //$("#follow3").text('Unfollow');
                        $("#follow"+FollowingUserId).text('Unfollow');
                    }else{
                        $("#follow"+FollowingUserId).text('Follow');
                    }
              }
        });
    }
}
</script>